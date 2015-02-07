<?php

namespace Dusan\Bundle\SimpleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimpleCrudType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                'text',
                [
                    'required' => true,
                    'label'    => 'dusan_simple.simple_crud.firstname.label'
                ]
            )
            ->add(
                'lastname',
                'text',
                [
                    'required'    => true,
                    'label'       => 'dusan_simple.simple_crud.lastname.label',
                ]
            )
            ->add(
                'email',
                'text',
                [
                    'required'    => true,
                    'label'       => 'dusan_simple.simple_crud.email.label',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'        => 'Dusan\Bundle\SimpleBundle\Entity\SimpleCrud',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dusan_simple_crud_form';
    }
}
