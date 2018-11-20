<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class GaleriaController extends Controller
{
    /**
     * @Route("/venta")
     */
    public function indexAction()
    {
        return $this->render('venta/indexVenta.html.twig');
    }


      /**
     * @Route("/cliente/galeria", name="galeria")
     */ 
    public function clientesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('galeria/index.html.twig');
    }

}