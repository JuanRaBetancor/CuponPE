<?php

namespace AppBundle\Listener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class OfertaTypeListener
{
    public function preSubmit(FormEvent $event)
    {
        $formulario = $event->getForm();
        if($formulario->get('acepto')->getData() == false){
            $formulario->get('acepto')->addError(new FormError('Debes aceptar las condiciones legales'));
        }
    }
}