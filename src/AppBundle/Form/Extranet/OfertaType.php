<?php

namespace AppBundle\Form\Extranet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; //Deprecated a partir de la v2.6

class OfertaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('condiciones')
            ->add('foto','file',array('required' => false))
            ->add('precio','money')
            ->add('descuento','money')
            ->add('umbral');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data-class'=>'AppBundle\Entity\Oferta'));
    }

    public function getName()
    {
        return 'oferta_tienda';
    }


}