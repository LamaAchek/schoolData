<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use App\Entity\Course;
use App\Entity\Classes;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Repository\CourseRepository;
use App\Repository\ClassesRepository;

final class SchoolStudent extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
        ->with('General')
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('dob', DateType::class)
            ->add('imagepath', FileType::class)
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
        $datagrid->add('first_name');
        $datagrid->add('last_name');
        $datagrid->add('dob');
        $datagrid->add('classid');
        $datagrid->add('courseid'); 

    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('first_name');
        $list->addIdentifier('last_name');
        $list->addIdentifier('dob');
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
        $show->add('first_name');
        $show->add('last_name');
        $show->add('dob');
        $show->add('classid');
        $show->add('courseid');

    }
}

?>