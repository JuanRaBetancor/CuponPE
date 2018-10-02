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


    public function portadaAction(){
        $em = $this->getDoctrine()->getManager();

        $tienda = $this->get('security.context')->getToken()->getUser();

        $ofertas = $em->getRepository('AppBundle:Tienda')->findOfertasRecientes($tienda->getId(), 50);

        return $this->render('extranet/portad.html.twig', array('ofertas' => $ofertas));
    }


    public function ofertaVentasAction($id){
        $em = $this->getDoctrine()->getManager();
        $ventas = $em ->getRepository('AppBundle:Oferta')->findVentasByOferta2($id);
        return $this->render('extranet/vent.html.twig', array(
           'ofertas'=>$ventas[0]->getOferta(), 'ventas'=> $ventas
        ));
    }


}