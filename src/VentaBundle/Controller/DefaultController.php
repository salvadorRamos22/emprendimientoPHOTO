<?php

namespace VentaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/venta")
     */
    public function indexAction()
    {
        return $this->render('VentaBundle:Default:index.html.twig');
    }
}
