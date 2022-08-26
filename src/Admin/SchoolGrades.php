<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use App\Entity\Course;
use App\Entity\Classes;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Repository\CourseRepository;
use App\Repository\ClassesRepository;
use App\Repository\StudentRepository;


final class SchoolGrades extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
        ->with('General')
            ->add('grades', TextType::class)
        ->end()
        ->with('Student', array('collapsed' => true))
            ->add('studentid', EntityType::class , [
                'class' => Student::class,
                'query_builder' => function (StudentRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'id',
                'multiple' => true])
        ->end()
        ->with('Course', array('collapsed' => true))
            ->add('courseid', EntityType::class , [
                'class' => Course::class,
                'query_builder' => function (CourseRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'id',
                'multiple' => true])
        ->end()
        ->with('Class', array('collapsed' => true))
            ->add('classid', EntityType::class , [
                'class' => Classes::class,
                'query_builder' => function (ClassesRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'id',
                'multiple' => true])
        ->end();

    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('grades');
        $datagrid->add('studentid');
        $datagrid->add('courseid'); 
        $datagrid->add('classid'); 


    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('grades');
        $list->addIdentifier('studentid', EntityType::class , [
            'class' => Student::class,
            'query_builder' => function (CourseRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'id',
            'multiple' => true]);
        $list ->addIdentifier('classid', EntityType::class , [
            'class' => Classes::class,
            'query_builder' => function (ClassesRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'id',
            'multiple' => true]);
        $list->addIdentifier('courseid', EntityType::class , [
            'class' => Course::class,
            'query_builder' => function (CourseRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'id',
            'multiple' => true]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('student');
        $show->add('course');
        $show->add('class');
        $show->add('grades');
        
    }
}

?>