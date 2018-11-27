<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuario;

class DefaultController extends Controller
{
    
    public function crearRegistroBase(){

        $em = $this->getDoctrine()->getEntityManager();
        $admi =  $em->getRepository('AppBundle:Usuario')->findOneBy(array('tipoUsuario'=>'admi')); 
        if(!$admi)
        {
           $registrar = new Usuario();
           $registrar->setNombre('Administrador');
           $registrar->setApellido('Administrador');
           $registrar->setCorreo('rodriguezprime@hotmail.com');
           $hash = password_hash('Administrador',PASSWORD_DEFAULT,[15]);
           $registrar->setPassword($hash);
           $registrar->settipoUsuario('admi');

           $em = $this->getDoctrine()->getEntityManager();
           $em->persist($registrar);
           $flush = $em->flush(); 
        }    
        
        return 0;
    }

    /**
     * @Route("/", name="admi")
     */ 
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('administracion/admiIndex.html.twig');
    }

    /**
     * @Route("/admi/lista_usuario", name="usuarioList")
     */
    public function usuariosAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findBy(array('tipoUsuario'=>'cliente'));

        return $this->render('usuarios/lista_usuario.html.twig',['usuarioList'=>$usuarios]);
    }


    /**
     * @Route("/admi/ver_usuario/{id}", name="verUsuario")
     */
    public function verusuarioAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($id);

        return $this->render('usuarios/usuario_ver.html.twig',['usu_ver'=>$usuario]);

    }

    /**
     * @Route("/admi/eliminar_usuario/{id}", name="eliminarUsuario")
     */
    public function eliminarusuarioAction(Request $request,$id){

        $em = $this->getDoctrine()->getEntityManager();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($id);
        $em->remove($usuario);
        $em->flush();
        return $this->redirect($this->generateUrl('usuarioList'));

    }
  

    /**
     * @Route("/login", name="loguear")
     */
    public function loginAction(Request $request)
    {   
        $this->crearRegistroBase();

        if($request->getMethod()=="POST")
        {
            $email = $request->get('email');
            $password = $request->get('password');
            $user = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findOneBy(array('correo'=>$email));

            if($user)
            {
                $hash = $user->getPassword();
                if(password_verify($password,$hash))
                {
                    $session = $request->getSession();
                    $session->set("id",$user->getId());
                    $session->set("nombre",$user->getNombre());

                    $var = $user->gettipoUsuario();
                    if($var == 'cliente'){
                        return $this->redirect($this->generateUrl('cliente'));
                    }else{
                        return $this->redirect($this->generateUrl('admi'));
                    }
                }else
                {
                    $this->get('session')->getFlashBag()->add('mensaje','El Password es incorrecto');
                    return $this->redirect($this->generateUrl('loguear'));
                }
            }else
            {
                $this->get('session')->getFlashBag()->add('mensaje','El correo es incorrecto');
                return $this->redirect($this->generateUrl('loguear'));
            }
        }

        return $this->render('usuarios/login.html.twig');
    }

    /**
     * @Route("/sesionF", name="logout")
     */
    public function logoutAction(Request $request){
        $session = $request->getSession();
        $session->clear();
        $this->get('session')->getFlashBag()->add('mensaje','Sesion Finalizada');
        return $this->redirect($this->generateUrl('loguear'));
    }


    /**
     * @Route("/registrar", name="registrar")
     */
    public function registerAction(Request $request)
    {
        if($request->getMethod()=="POST")
            {
                 $registrar = new Usuario();
                 $nombre = $request->get('nombre');
                 $apellido = $request->get('apellido');
                 $email = $request->get('email');
                 $password = $request->get('password');
                 $hash = password_hash($password,PASSWORD_DEFAULT,[15]);


                 $registrar->setNombre($nombre);
                 $registrar->setApellido($apellido);
                 $registrar->setCorreo($email);
                 $registrar->setPassword($hash);
                 $registrar->settipoUsuario("cliente");

                 $em = $this->getDoctrine()->getEntityManager();
                 $em->persist($registrar);
                 $flush = $em->flush();

                 return $this->redirectToRoute('loguear');
            }
        
       
        return $this->render('usuarios/registrar.html.twig');
    }



    /**
     * @Route("/cliente/principal", name="cliente")
     */
    public function clienteAction(Request $request){


        return $this->render('cliente/cliente_principal.html.twig');
    }


    //METODOS DE IMPRESION DE RESERVA y RESERVA ADMINISTRADOR

    /**
     * @Route("/admi/reserva", name="reservas")
     */
    public function reservadmiAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $reservas = $em->getRepository('AppBundle:reserva')->findAll();
        //$fecha = $reservas->getReservaFecha();

        return $this->render('reserva/reserva.html.twig',['listado'=>$reservas]);
    }

     /**
     * @Route("/admi/reserva/{id}", name="ver_reservas")
     */
    public function vereservAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $reserva = $em->getRepository('AppBundle:reserva')->find($id);

        $tipo = $reserva->getreservaTipoId();
        $tipoReserva = $em->getRepository('AppBundle:reserva_tipo_servicio')->find($tipo);

        return $this->render('reserva/ver_reserva_admi.html.twig',['reserva'=>$reserva,'tipoReserva'=>$tipoReserva]);

    }

    


    
    
}
