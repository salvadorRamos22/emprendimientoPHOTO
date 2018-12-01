<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Foto;

class GaleriaController extends Controller
{
      /**
     * @Route("/cliente/galeria", name="galeria")
     */
    public function clientesAction(Request $request)
    {
      $session = $request->getSession();

        if($session->has("id")){
          $listado=$this->getDoctrine()->getRepository(Categoria::class)->findAll();

           return $this->render('galeria/inicio.html.twig', array('listado' => $listado));

        }else{

            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
      
    }

    /**
   * @Route("/cliente/galeria/{categoria}", name="galeria_categoria")
   */
  public function galeriaFiltradaAction(Request $request,$categoria)
  {

    $session = $request->getSession();

        if($session->has("id")){
          $repository = $this->getDoctrine()->getRepository(Categoria::class);
          $categoria = $repository->findOneBy(array('nombreCategoria' => $categoria));
          $repository = $this->getDoctrine()->getRepository(Foto::class);
          $listado = $repository->findBy(array('idCategoria' => $categoria->getId()));

          return $this->render('galeria/categoriaGaleria.html.twig', array('listado' => $listado));

        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
    
  }
}
