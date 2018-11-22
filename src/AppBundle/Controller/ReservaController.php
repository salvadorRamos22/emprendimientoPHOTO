<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\reserva_tipo_servicio;


class ReservaController extends Controller
{
    /**
     * @Route("/admi/reserva", name="reservas")
     */
    public function indexAction(Request $request)
    {
        return $this->render('reserva/reserva.html.twig');
    }

    /**
     * @Route("/cliente/reserva", name="reserva_cliente")
     */
    public function reservaClienteAction(Request $request){


    	return $this->render('reserva/reserva_cliente.html.twig');
    }

    /**
     * @Route("/admi/tipo_reserva", name="reserva_tipo")
     */
    public function tipoReservaAction(Request $request){

    	if($request->getMethod()=="POST"){

    		$post = new reserva_tipo_servicio();
    		$nombre = $request->get('nombre');
    		$descripcion = $request->get('descripcion');
    		$precio = $request->get('precio');

    		$post->setNombre($nombre);
    		$post->setDescripcion($descripcion);
    		$post->setPrecio($precio);
    		$em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $flush = $em->flush();

            return $this->render('reserva/tipo_reserva.html.twig');
    	}
    	return $this->render('reserva/tipo_reserva.html.twig');
    }
}