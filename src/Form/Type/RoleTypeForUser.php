<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Roles;

class RoleTypeForUser extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('description', TextareaType::class)
        ;

        $builder->add('save', SubmitType::class, array('label' => 'Save Role'));
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([
            'data_class' => Roles::class
        ]);
    }
}
