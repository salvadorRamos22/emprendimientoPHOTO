<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ReservaController extends Controller
{
    /**
     * @Route("/reserva", name="reservas")
     */
    public function indexAction(Request $request)
    {
        return $this->render('reserva/reservaIndex.html.twig');
    }
}