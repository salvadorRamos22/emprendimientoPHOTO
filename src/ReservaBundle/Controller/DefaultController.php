<?php

namespace ReservaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/reserva", name="reservas")
     */
    public function indexAction(Request $request)
    {
        return $this->render('reserva/reservaIndex.html.twig');
    }
}
