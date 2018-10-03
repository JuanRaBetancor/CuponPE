<?php

namespace AppBundle\Controller;

use AppBundle\Form\OfertaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Oferta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
           'oferta'=>$ventas[0]->getOferta(), 'ventas'=> $ventas
        ));
    }

    public function perfilAction(Request $request){
        $tienda = $this->get('security.token_storage')->getToken()->getUser();
        $formulario = $this->createForm('AppBundle\Form\Extranet\TiendaType', $tienda);


        $passwordOriginal = $formulario->getData()->getPassword();

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            //$this->get('app.manager.tienda_manager')->guardar($tienda);

            if($tienda->getPassword() == null){
                $tienda->setPassword($passwordOriginal);
            }else{
                $encoder = $this->get('security.encoder_factory')->getEncoder($tienda);
                $passwordCodificado = $encoder->encodePassword($tienda->getPassword(),$tienda->getSalt());
                $tienda->setPassword($passwordCodificado);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($tienda);
            $em->flush();


            $this->addFlash('info', 'Los datos de tu perfil se han actualizado correctamente');

            return $this->redirectToRoute('extranet_perfil');
        }

        return $this->render('extranet/perfi.html.twig', array(
            'tienda' => $tienda,
            'formulario' => $formulario->createView(),
        ));
    }


    public function ofertaNuevaAction(Request $request)
    {
        /**
        $peticion = $this->getRequest();
        $oferta = new Oferta();
        $formulario = $this->createForm(new OfertaType(), $oferta);
        $formulario->handleRequest($peticion);

        if($formulario->isValid()){
            $tienda = $this->get('security.context')->getToken()->getUser();
            $oferta->setCompras(0);
            $oferta->setTienda($tienda);
            $oferta->setCiudad($tienda->getCiudad());

            $oferta->subirFoto();

            $em = $this->getDoctrine()->getManager();
            $em->persist($oferta);
            $em->flush();
            return $this->redirect($this->generateUrl('extranet_portada'));
        }

        return $this->render('extranet/formulario.html.twig', array('formulario'=>$formulario->createView()));
        */

        $tienda = $this->get('security.token_storage')->getToken()->getUser();

        $oferta = Oferta::crearParaTienda($tienda);
        $formulario = $this->createForm('AppBundle\Form\OfertaType', $oferta, array('mostrar_condiciones' => true));
        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            $this->get('app.manager.oferta_manager')->guardar($oferta);

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render(
            'extranet/oferta.html.twig', array(
            'accion' => 'crear',
            'formulario' => $formulario->createView(),
        ));
    }



}