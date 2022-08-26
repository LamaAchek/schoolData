<?php

namespace App\Controller;

use App\Entity\Studentgrades;
use App\Form\AddstudentsGradeType;
use App\Repository\StudentgradesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentGradeController extends AbstractController
{

    private $em;
    private $StudentgradesRepository;
    
    public function __construct(EntityManagerInterface $em, StudentgradesRepository $StudentgradesRepository) 
    {
        $this->em = $em;
        $this->StudentgradesRepository = $StudentgradesRepository;
    }
    
    #[Route('/addgrade', name: 'add_grade')]
    public function add( Request $request,  EntityManagerInterface $entitymanager,): Response 
    {
        $grade = new Studentgrades();

        $form = $this->createForm(AddstudentsGradeType::class, $grade);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager->persist($grade);
            $entitymanager->flush();

            $this->em->flush();
            return $this->render('studentgrades/index.html.twig', [
                'add_grade' => $form->createView()
            ]);
            
        }
        
            return $this->render('studentgrades/index.html.twig', [
                'add_grade' => $form->createView()
            ]);
    }

    #[Route('/filter_grades',  name: 'filter_grades')]
    public function index(Request $request)
    {
        $student = $request->query->get('student',null);
        $course = $request->query->get('course',null);
        $class = $request->query->get('class',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $grade = $this->StudentgradesRepository->getSearchGrades($student,$query);

        return $this->render('studentgrades/show.html.twig', [
            'grades' => $grade 
        ]);
    }
    #[Route('/filter_grades_course',  name: 'filter_grades_course')]
    public function searchgradecourse(Request $request)
    {
        $course = $request->query->get('course',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $grade = $this->StudentgradesRepository->getSearchGradesCourse($course, $query);

        return $this->render('studentgrades/show.html.twig', [
            'grades' => $grade 
        ]);
    }
    #[Route('/filter_grades_classes',  name: 'filter_grades_classes')]
    public function searchgradeclass(Request $request)
    {
        $class = $request->query->get('class',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $grade = $this->StudentgradesRepository->getSearchGradesClasses($class,$query);

        return $this->render('studentgrades/show.html.twig', [
            'grades' => $grade 
        ]);
    }

    #[Route('/grades',  name: 'show_grades')]
    public function show(): Response
    {
        $grades = $this->StudentgradesRepository->findAll();
        
        return $this->render('studentgrades/show.html.twig', [
            'grades' => $grades
        ]);
    }
    
}