<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('name', TextType::class)
            ->add('reference', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ;

        $builder->add('save', SubmitType::class, array('label' => 'Save Client'));
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([]);
    }
}
