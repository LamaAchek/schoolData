<?php

namespace App\Controller;
use App\Repository\StudentRepository;
use App\Repository\CourseRepository;
use App\Entity\Student;
use App\Service\StudentService;
use App\Form\AddstudentType;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class StudentController extends AbstractController
{

    private $em;
    private $studentRepository;
    
    public function __construct(EntityManagerInterface $em, StudentRepository $studentRepository, StudentService $studentService) 
    {
        $this->em = $em;
        $this->studentRepository = $studentRepository;
        $this->studentService = $studentService;
    }

    #[Route('/addstudent', name: 'app_student')]
    public function addStudent(Environment $twig, Request $request  , EntityManagerInterface $entitymanager, SluggerInterface $slugger): Response
    {
       
        
        $student = new student();
        
        $form = $this->createForm(AddstudentType::class, $student );
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $newStudent = $form->getData();
        $imagePath = $form->get('imagepath')->getData();
        
        if ($imagePath) {
            $newFileName = uniqid() . '.' . $imagePath->guessExtension();

            try {
                $imagePath->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $newFileName
                );
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }
            $newStudent->setImagePath('/uploads/' . $newFileName);
        }

        $this->em->persist($newStudent);
        $this->em->flush();

    }
        
        return new Response($twig->render('student/Addstudent.html.twig', [
            'add_student' => $form->createView()
        ]));
    }

    

    #[Route('/students',  name: 'show_students')]
    public function show(): Response
    {
        $students = $this->studentService->getPaginatedStudents();
        
        return $this->render('student/index.html.twig', [
            'student' => $students
        ]);
    }

    #[Route('/filter_students',  name: 'filter_students')]
    public function index(Request $request)
    {
        $studentL = $request->query->get('last_name',null);
        $studentF = $request->query->get('first_name',null);
        $class = $request->query->get('classid',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $student = $this->studentRepository->getSearchStudentL($studentF, $studentL,$class,$query);

        return $this->render('student/index2.html.twig', [
            'student' => $student 
        ]);
    }

    #[Route('/filter_students_course',  name: 'filter_students_course')]
    public function filtercourse(Request $request)
    {
        $course = $request->query->get('courseid',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $student = $this->studentRepository->getSearchStudentCourse($course,$query);

        return $this->render('student/index2.html.twig', [
            'student' => $student 
        ]);
    }

    #[Route('/filter_students_classes',  name: 'filter_students_classes')]
    public function filterclasses(Request $request)
    {
        $classes = $request->query->get('classid',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $student = $this->studentRepository->getSearchStudentClasses($classes,$query);

        return $this->render('student/index2.html.twig', [
            'student' => $student 
        ]);
    }

   

    

   

    #[Route('/students/{id}',methods: ['GET'],  name: 'show_student')]
    public function showspecific($id): Response
    {
        $student = $this->studentRepository->find($id);
        
        return $this->render('student/show.html.twig', [
            'student' => $student
        ]);
    }

    #[Route('/students/edit/{id}', name: 'edit_student')]
    public function edit($id, Request $request): Response 
    {
        $student = $this->studentRepository->find($id);

        $form = $this->createForm(AddstudentType::class, $student);

        $form->handleRequest($request);
        $imagePath = $form->get('imagepath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
    
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $student->setImagePath('/uploads/' . $newFileName);
            }
    
                $student->setFirstName($form->get('first_name')->getData());
                $student->setLastName($form->get('last_name')->getData());
                $student->setDob($form->get('dob')->getData());
                $student->setModifiedDate();

                $this->em->flush();
                return $this->render('student/show.html.twig', [
                    'student' => $student
                ]);
            
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView()
        ]);
    }



    #[Route('/students/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_student')]
    public function delete($id): Response
    {
        $student = $this->studentRepository->find($id);
        $this->em->remove($student);
        $this->em->flush();

        return $this->render('base.html.twig', [
            'student' => $student
        ]);
    }
    

}

