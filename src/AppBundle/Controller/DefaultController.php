<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admi")
     */ 
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('administracion/admiIndex.html.twig');
    }

    /**
     * @Route("/cliente", name="cliente")
     */ 
    public function clientesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('galeria/index.html.twig');
    }
}
