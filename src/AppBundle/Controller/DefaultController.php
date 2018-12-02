<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Categoria;


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

    public function crearCategoriasBase(){
        $array = array("Premiaciones","Viajes","Moda y Estilo de vida","Bodas","Celebraciones");
        $em = $this->getDoctrine()->getEntityManager();
        $categoria = $em->getRepository('AppBundle:Categoria')->findAll();
        if(!$categoria){
            foreach ($array as $key) {
                $cate = new Categoria();
                $cate->setNombreCategoria($key);
                $em->persist($cate);
                $flush = $em->flush();
            }
            
        }
    }

    /**
     * @Route("/admi", name="admi")
     */ 
    public function indexAction(Request $request)
    {
        $session = $request->getSession();

        if($session->has("id")){

         return $this->render('administracion/admiIndex.html.twig');   
        }
        else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }        
    }

    /**
     * @Route("/admi/lista_usuario", name="usuarioList")
     */
    public function usuariosAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getEntityManager();
            $usuarios = $em->getRepository('AppBundle:Usuario')->findBy(array('tipoUsuario'=>'cliente'));

            return $this->render('usuarios/lista_usuario.html.twig',['usuarioList'=>$usuarios]);
        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));

        }
        
    }


    /**
     * @Route("/admi/ver_usuario/{id}", name="verUsuario")
     */
    public function verusuarioAction(Request $request,$id){
        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getEntityManager();
            $usuario = $em->getRepository('AppBundle:Usuario')->find($id);

            return $this->render('usuarios/usuario_ver.html.twig',['usu_ver'=>$usuario]);
        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
    }

    /**
     * @Route("/admi/eliminar_usuario/{id}", name="eliminarUsuario")
     */
    public function eliminarusuarioAction(Request $request,$id){

        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getEntityManager();
            $usuario = $em->getRepository('AppBundle:Usuario')->find($id);
            $em->remove($usuario);
            $em->flush();
            return $this->redirect($this->generateUrl('usuarioList'));
        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
    }
  

    /**
     * @Route("/", name="loguear")
     */
    public function loginAction(Request $request)
    {   
        $this->crearRegistroBase();
        $this->crearCategoriasBase();

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
                    $session->set("tipoUsuario",$user->gettipoUsuario());
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
                $email = $request->get('email');
                $existe = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findOneBy(array('correo'=>$email));
                if($existe){
                    $this->get('session')->getFlashBag()->add('mensaje','El Email ya existe');
                    return $this->redirect($this->generateUrl('registrar'));
                }else{
                    $registrar = new Usuario();
                    $nombre = $request->get('nombre');
                    $apellido = $request->get('apellido');
                 
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
                 
            }
        
       
        return $this->render('usuarios/registrar.html.twig');
    }



    /**
     * @Route("/cliente/principal", name="cliente")
     */
    public function clienteAction(Request $request){
        $session = $request->getSession();
        if($session->has("id")){
           return $this->render('cliente/cliente_principal.html.twig'); 
        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
        
    }


    //METODOS DE IMPRESION DE RESERVA y RESERVA ADMINISTRADOR

    /**
     * @Route("/admi/reserva", name="reservas")
     */
    public function reservadmiAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getEntityManager();
            $reservas = $em->getRepository('AppBundle:reserva')->findAll();
            return $this->render('reserva/reserva.html.twig',['listado'=>$reservas]);
        }else{
            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
        
    }

     /**
     * @Route("/admi/reserva/{id}", name="ver_reservas")
     */
    public function vereservAction(Request $request,$id){

        $session = $request->getSession();
        if($session->has("id")){    
            $em = $this->getDoctrine()->getEntityManager();
            $reserva = $em->getRepository('AppBundle:reserva')->find($id);

            $tipo = $reserva->getreservaTipoId();
            $tipoReserva = $em->getRepository('AppBundle:reserva_tipo_servicio')->find($tipo);

            return $this->render('reserva/ver_reserva_admi.html.twig',['reserva'=>$reserva,'tipoReserva'=>$tipoReserva]);
        }else{

            $this->get('session')->getFlashBag()->add('mensaje','Debe estar Logueado para este contenido');
            return $this->redirect($this->generateUrl('loguear'));
        }
        

    }
       
}
