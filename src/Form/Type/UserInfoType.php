<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class UserInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('companyName', TextType::class, array('required' => false))
            ->add('address', TextType::class, array('required' => false))
            ->add('moreInfo', TextareaType::class, array('required' => false))
            ->add('telephone', TelType::class, array('required' => false))
            ->add('cellphone', TelType::class, array('required' => false))
            ->add('fax', TelType::class, array('required' => false))
        ;
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
