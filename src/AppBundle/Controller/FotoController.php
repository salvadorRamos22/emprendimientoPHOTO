<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Entity\Foto;
use AppBundle\Entity\Categoria;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextArea;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FotoController extends Controller
{

      /**
     * @Route("/foto", name="foto_index")
     */
    public function indexAction(Request $request)
    {

      $session = $request->getSession();

        if($session->has("id")){

          $listado=$this->getDoctrine()->getRepository('AppBundle:Foto')->findAll();
          return $this->render('fotos/listadoFotos.html.twig', array('listado' => $listado));

        }else{

          $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
          return $this->redirect($this->generateUrl('loguear'));
        }
        
    }

    /**
    * @Route("/foto/create", name="foto_create")
    */
    public function createAction(Request $request)
    {

      $session = $request->getSession();

        if($session->has("id")){

      //consulta las categorias para crear una lista que se usará para cargar en el formulario (ChoiceType)
      $listado=$this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
      foreach($listado as $ob){
        $lista[$ob->getId()]=$ob->getNombreCategoria();
      }

      //se crea el formulario
      $foto=new Foto;
      $form=$this->createFormBuilder($foto)
      ->add('titulo',TextType::class,array('label'=>'Titulo de la foto','attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('fotoDescripcion',TextType::class,array('label'=>'Descripción','attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('fotoLink',FileType::class,array('label'=>'Agregar la Fotografía','attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('idcategoria',ChoiceType::class,array('label'=>'Seleccione una categoría','placeholder'=>false,
      'choices'=>array_flip($lista),
      'attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar',SubmitType::class,array('attr' => array('class'=>'btn btn-success btn-sm','style'=>'margin-bottom:15px')))
      ->getForm();
      $form->handleRequest($request);

      //Después de llenar el formulario
       if ($form->isSubmitted() && $form->isValid()) {
         $foto->setTitulo($form['titulo']->getData());
         $foto->setFotoDescripcion($form['fotoDescripcion']->getData());
         $cat = $this->getDoctrine()->getRepository(Categoria::class)->find($form['idcategoria']->getData());
         $foto->setIdCategoria($cat);

         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
          $file = $foto->getFotoLink();
          $filename= md5(uniqid()).'.'.$file->guessExtension();
          $file->move($this->getParameter('image_directory'),$filename);


          $foto->setFotoLink($filename);

       $em=$this->getDoctrine()->getManager();
         $em->persist($foto);
         $em->flush();
         $this->addFlash('notice','Foto Agregada con éxito');
        return $this->redirectToRoute('foto_index');
       }//fin

      return $this->render('fotos/agregarFoto.html.twig',array('form' => $form->createView()));

        }else{

            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
      

    }


    /**
   * @Route("/foto/edit/{id}", name="foto_edit")
   */
  public function editAction(Request $request,$id)
  {

  }


/**
* @Route("/foto/delete/{id}", name="foto_delete")
*/
public function deleteAction(Request $request,$id)
{

     $session = $request->getSession();

      if($session->has("id")){

        $entityManager = $this->getDoctrine()->getManager();
        $foto = $entityManager->getRepository(Foto::class)->find($id);
        if (!$foto) {
             throw $this->createNotFoundException(
             'FOTO NO ENCONTRADA POR ID '.$id
             );
         }

         $entityManager->remove($foto);
         $entityManager->flush();
         return $this->redirectToRoute('foto_index');
      
      }else{

          $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
          return $this->redirect($this->generateUrl('loguear'));
      }
    
  }
}
