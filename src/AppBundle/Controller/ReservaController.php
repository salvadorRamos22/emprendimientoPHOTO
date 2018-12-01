<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\reserva_tipo_servicio;
use AppBundle\Entity\reserva;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextArea;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservaController extends Controller
{
    
    
    /**
     * @Route("/cliente/reserva", name="reserva_cliente")
     */
    public function reservaClienteAction(Request $request){
        $idr=$this->get('session')->get("id");
        $em = $this->getDoctrine()->getEntityManager();
        $reservas = $em->getRepository('AppBundle:reserva')->findBy(array('idUsuario'=>$idr));

        return $this->render('reserva/reserva_cliente.html.twig',['listado'=>$reservas]);
    }

     /**
    * @Route("/reserva/create", name="reserva_create")
    */
    public function reservaCreateAction(Request $request)
    {
      //consulta las servicios para crear una lista que se usará para cargar en el formulario (ChoiceType)
      $listado_servicio=$this->getDoctrine()->getRepository('AppBundle:reserva_tipo_servicio')->findAll();
      foreach($listado_servicio as $ob){
        $lista[$ob->getId()]=$ob->getNombre();
      }

      //se crea el formulario
      $rese=new reserva;
      $form=$this->createFormBuilder($rese)
      ->add('reservaFecha',DateType::class,array('label'=>'Fecha de reserva','attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('reservaLugar',TextType::class,array('label'=>'Lugar','attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('reservaTipoId',ChoiceType::class,array('label'=>'Seleccione tipo de Servicio','placeholder'=>false,
      'choices'=>array_flip($lista),
      'attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar',SubmitType::class,array('attr' => array('class'=>'btn btn-success btn-sm','style'=>'margin-bottom:15px')))
      ->getForm();
      $form->handleRequest($request);

      //Después de llenar el formulario
       if ($form->isSubmitted() && $form->isValid()) {
         $rese->setReservaFecha($form['reservaFecha']->getData());
         $rese->setReservaLugar($form['reservaLugar']->getData());
         $cat = $this->getDoctrine()->getRepository(reserva_tipo_servicio::class)->find($form['reservaTipoId']->getData());
         $rese->setreservaTipoId($cat);
         $idr=$this->get('session')->get("id");
         $rese->setidUsuario($idr);

         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $em=$this->getDoctrine()->getManager();
         $em->persist($rese);
         $em->flush();
         $this->addFlash('notice','Reserva Agregada con éxito');
        return $this->redirectToRoute('reserva_cliente');
       }//fin

      return $this->render('reserva/agregar_reserva.html.twig',array('form' => $form->createView()));

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


    /**
     * @Route("/admi/listado_tipo_reserva", name="reserva_tipoList")
     */
    public function listTporeservAction(Request $request){
    	$em = $this->getDoctrine()->getEntityManager();
    	$listado = $em->getRepository('AppBundle:reserva_tipo_servicio')->findAll();

    	return $this->render('reserva/listado_tipo_reserva.html.twig',['listado'=>$listado]);
    }

     /**
     * @Route("/admi/eliminar/{id}", name="eliminarTipoReserva")
     */
    public function eliminarTipoReservaAction(Request $request,$id){

    	$em = $this->getDoctrine()->getEntityManager();
        $tipo = $em->getRepository('AppBundle:reserva_tipo_servicio')->find($id);
        $em->remove($tipo);
        $em->flush();

        return $this->redirect($this->generateUrl('reserva_tipo'));
    }


     /**
     * @Route("/admi/ver_tipo/{id}", name="verTipoReserva")
     */
    public function verTipoReserva(Request $request,$id){
    	$em = $this->getDoctrine()->getEntityManager();
        $tipo = $em->getRepository('AppBundle:reserva_tipo_servicio')->find($id);

        return $this->render('reserva/ver_tipoReserva.html.twig',['tipo_ver'=>$tipo]);
    }
}