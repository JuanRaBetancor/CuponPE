<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class ExtraController extends Controller
{

    public function loginAction(){

        // NO FUNCIONA SEGÚN EL PDF, ADEMÁS LAS FUNCIONES USADAS ESTÁN EN DESUSO
        //$peticion = $this->getRequest();
        //$sesion = $peticion->getSession();
        //$error = $peticion->attributes->get(SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR));
        //return $this->render('extranet/logina.html.twig', array('error' => $error));


        $authUtils = $this->get('security.authentication_utils');
        return $this->render('extranet/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));

    }


}