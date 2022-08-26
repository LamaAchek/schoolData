<?php

namespace App\Controller;
use App\Repository\CourseRepository;
use App\Entity\Course;
use App\Form\AddcourseType;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CourseService;


class CourseController extends AbstractController
{

    private $em;
    private $courseRepository;
    
    public function __construct(EntityManagerInterface $em, CourseRepository $courseRepository, CourseService $CourseService) 
    {
        $this->em = $em;
        $this->courseRepository = $courseRepository;
        $this->CourseService = $CourseService;
    }

    #[Route('/addcourse', name: 'app_course')]
    public function addCourse(Environment $twig, Request $request  , EntityManagerInterface $entitymanager): Response
    {
        $course = new course();

        
        $form = $this->createForm(AddcourseType::class, $course );
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($course);
            $entitymanager->flush();

            return new Response(' course with id ' . $course->getId() . ' is added');
        }
        
        return new Response($twig->render('course/Addcourse.html.twig', [
            'add_course' => $form->createView()
        ]));
    }
    #[Route('/filter_course',  name: 'filter_courses')]
    public function index2(Request $request)
    {
        $courseTitle = $request->query->get('name',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $course = $this->courseRepository->getSearchCourses($courseTitle,$query);

        return $this->render('course/index.html.twig', [
            'course' => $course 
        ]);
    }

    #[Route('/courses',  name: 'show_courses')]
    public function show(): Response
    {
        $courses = $this->CourseService->getPaginatedCourses();
        
        return $this->render('course/index.html.twig', [
            'course' => $courses
        ]);
    }

    #[Route('/courses/{id}',methods: ['GET'],  name: 'show_course')]
    public function showspecific($id): Response
    {
        $course = $this->courseRepository->find($id);
        
        return $this->render('course/show.html.twig', [
            'course' => $course
        ]);
    }

    #[Route('/courses/edit/{id}', name: 'edit_course')]
    public function edit($id, Request $request): Response 
    {
        $course = $this->courseRepository->find($id);

        $form = $this->createForm(AddcourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $course->setName($form->get('name')->getData());
                $course->setDescription($form->get('description')->getData());
                $course->setModifiedDate();

                $this->em->flush();
                return $this->render('course/show.html.twig', [
                    'course' => $course
                ]);
            }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView()
        ]);
    }



    #[Route('/courses/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_course')]
    public function delete($id): Response
    {
        $course = $this->courseRepository->find($id);
        $this->em->remove($course);
        $this->em->flush();

        return new Response(' course is deleted');

        return $this->render('course/index.html.twig', [
            'course' => $course
        ]);
    }
}

