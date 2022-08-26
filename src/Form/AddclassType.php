<?php

namespace App\Form;

use App\Entity\classes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AddclassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class , [
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'name',
            ),
            'label' => false,
            'required' => true
        ])
        ->add('Section', TextType::class ,[
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-6 text-1xl outline-none',
                'placeholder' => 'section',
            ),
            'label' => false,
            'required' => true
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_classes' => classes::class,
        ]);
    }
}

