<?php

namespace AppBundle\Form\Extranet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiendaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('slug')
            ->add('login', 'text', array('read_only'=>true))
            ->add('password','repeated', array(
                'type'=>'password',
                'invalid_message'=>'Las dos contraseñas deben coincidir',
                'first_options'=>array('label'=>'Contraseña'),
                'second_options'=>array('label'=>'Repite Contraseña'),
                'required'=> false
            ))
            ->add('descripcion')
            ->add('direccion')
            ->add('ciudad');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tienda'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tienda';
    }


}
