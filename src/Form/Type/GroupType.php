<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Group Name (if compiled a new group will be forced)'
                )
            )
            ->add(
                'sutterAcademy',
                CheckboxType::class,
                array('required' => false)
            )
            ->add(
                'editSutter',
                CheckboxType::class,
                array('required' => false)
            )
            ->add(
                'prodotti',
                CheckboxType::class,
                array('required' => false)
            )
            ->add(
                'wizard',
                CheckboxType::class,
                array('required' => false)
            )
            ->add(
                'piani',
                CheckboxType::class,
                array('required' => false)
            )
        ;
    }

    /**
     * @throws AccessException
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([]);
    }
}
