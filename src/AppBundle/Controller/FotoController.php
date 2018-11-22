<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Foto;

class FotoController extends Controller
{

    
    public function indexAction(Request $request,$zona="")
    {
        // replace this example code with whatever you need
        return $this->render('administracion/admiIndex.html.twig');
    }

  
    public function usuariosAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findBy(array('tipoUsuario'=>'cliente'));

        return $this->render('usuarios/lista_usuario.html.twig',['usuarioList'=>$usuarios]);
    }



  
    public function loginAction(Request $request)
    {
       

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

    
    public function logoutAction(Request $request){
        $session = $request->getSession();
        $session->clear();
        $this->get('session')->getFlashBag()->add('mensaje','Sesion Finalizada');
        return $this->redirect($this->generateUrl('loguear'));
    }



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



    public function clienteAction(Request $request){


        return $this->render('cliente/cliente_principal.html.twig');
    }

}
