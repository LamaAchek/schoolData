<?php

namespace App\Controller;
use App\Repository\ClassesRepository;
use App\Entity\Classes;
use App\Form\AddclassType;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ClassesService;


class ClassController extends AbstractController
{

    private $em;
    private $classesRepository;
    
    public function __construct(EntityManagerInterface $em, ClassesRepository $classesRepository,ClassesService $ClassesService) 
    {
        $this->em = $em;
        $this->classesRepository = $classesRepository;
        $this->ClassesService = $ClassesService;
    }

    #[Route('/addclass', name: 'app_classes')]
    public function addClass(Environment $twig, Request $request  , EntityManagerInterface $entitymanager): Response
    {
        $class = new classes();

        
        $form = $this->createForm(AddclassType::class, $class );
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($class);
            $entitymanager->flush();

        }
        
        return new Response($twig->render('class/Addclass.html.twig', [
            'add_classes' => $form->createView()
        ]));
    }

    #[Route('/classess',  name: 'show_classes')]
    public function show(): Response
    {
        $classess = $this->ClassesService->getPaginatedClasses();
        
        return $this->render('class/index.html.twig', [
            'classes' => $classess
        ]);
    }

    #[Route('/filter',  name: 'filter_classes')]
    public function index(Request $request)
    {
        $classTitle = $request->query->get('name',null);
        $query = $request->query->get('query',null);

        // if has not $classTitle and $query it will find all

        $classes = $this->classesRepository->getSearchClasses($classTitle,$query);

        return $this->render('class/index2.html.twig', [
            'classes' => $classes 
        ]);
    }


    #[Route('/classess/{id}',methods: ['GET'],  name: 'show_class')]
    public function showspecific($id): Response
    {
        $class = $this->classesRepository->find($id);
        
        return $this->render('class/show.html.twig', [
            'classes' => $class
        ]);
    }

    #[Route('/classess/edit/{id}', name: 'edit_classes')]
    public function edit($id, Request $request): Response 
    {
        $class = $this->classesRepository->find($id);

        $form = $this->createForm(AddclassType::class, $class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $class->setName($form->get('name')->getData());
                $class->setModifiedDate();

                $this->em->flush();
                return $this->render('class/show.html.twig', [
                    'classes' => $class
                ]);
            }

        return $this->render('class/edit.html.twig', [
            'classes' => $class,
            'form' => $form->createView()
        ]);
    }



    #[Route('/classess/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_class')]
    public function delete($id): Response
    {
        $class = $this->classesRepository->find($id);
        $this->em->remove($class);
        $this->em->flush();


        return $this->render('base.html.twig', [
            'class' => $class
        ]);
    }
}

