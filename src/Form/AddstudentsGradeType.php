<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Classes;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\ClassesRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





class AddstudentsGradeType extends AbstractType
{

    public function __construct(EntityManagerInterface $em, ClassesRepository $classesRepository , StudentRepository $studentRepository,CourseRepository $courseRepository) 
    {
        $this->em = $em;
        $this->classesRepository = $classesRepository;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {

        
        $builder

        ->add('studentid' , EntityType::class , [
            'class' => Student::class,
            'query_builder' => function (StudentRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'id',
            'multiple' => true,
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'student ',
            ),
        ])
        ->add('courseid' , EntityType::class , [
            'class' => Course::class,
            'query_builder' => function (CourseRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
            'multiple' => true,
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'course ',
            ),
        ])
        ->add('classid' , EntityType::class , [
            'class' => Classes::class,
            'query_builder' => function (ClassesRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
            'multiple' => true,
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'class ',
            ),
        ])

        ->add('grades' , TextType::class ,[
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'grade ',
            ),
            'label' => false,
            'required' => false, 
            
        ])

        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $choices = [];
        foreach ( $this->classesRepository->findAll('name') as $name){
            $choices[$name->getName()] = $name->getName();
        }

        $choices2 = [];
        foreach ( $this->courseRepository->findAll('name') as $name2){
            $choices2[$name2->getName()] = $name2->getName();
        }

        $choices3 = [];
        foreach ( $this->studentRepository->findAll('id') as $name3){
            $choices3[$name3->getId()] = $name3->getId();
        }


        $resolver->setDefaults([
            'choices'        => $choices,
            'choices2'        => $choices2,
            'choices3'        => $choices3,
        ]);
    }
}
