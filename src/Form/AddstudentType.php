<?php

namespace App\Form;
use App\Entity\Classes;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClassesRepository;
use App\Repository\CourseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddstudentType extends AbstractType
{

    public function __construct(EntityManagerInterface $em, ClassesRepository $classesRepository, CourseRepository $courseRepository) 
    {
        $this->em = $em;
        $this->classesRepository = $classesRepository;
        $this->courseRepository = $courseRepository;
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {

        
        $classes = $this->classesRepository->findAll('name');

        
        $builder
            ->add('first_name', TextType::class , [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                    'placeholder' => 'first name',
                ),
                'label' => false,
                'required' => true
            ])
            ->add('last_name', TextType::class ,[
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                    'placeholder' => 'last name',
                ),
                'label' => false,
                'required' => true,
            ])

            


            ->add('courseid' , EntityType::class , [
                'class' => Course::class,
                'query_builder' => function (CourseRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' =>true,
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                    'placeholder' => 'student ',
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
                'expanded' =>true,
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                    'placeholder' => 'student ',
                ),
            ])
        
        

            ->add('dob', DateType::class,  array(
                'required' => true,
                'widget' => 'single_text',
                'label' => false,
                'attr' => ['class' => ' bg-transparent block border-b-2 w-full datepicker form-control']
            ))

            ->add('imagepath' , FileType::class, array(
                'required' => false,
                'mapped' => false
            ))

            

            ;

            


        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $choices = [];
        foreach ( $this->classesRepository->findAll('name') as $name){
            $choices[$name->getName()] = $name->getName();
        }


        $choices2 = [];
        foreach ( $this->courseRepository->findAll('name') as $name){
            $choices2[$name->getName()] = $name->getName();
        }
       
        $resolver->setDefaults(array(
            'choices' => $choices,
            'choices2' => $choices2,
        ));
    }
}
