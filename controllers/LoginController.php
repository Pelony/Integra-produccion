<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController{
    public static function login(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas= $auth->validarLogin();
            if(empty($alertas)){
                //Combrobar usuario
                $usuario= Usuario::where('correo',$auth->correo);
                if($usuario){
                    //verificar password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //Autenticar al usuario
                        session_start();

                        $_SESSION['id']=$usuario->id;
                        $_SESSION['nombre']=$usuario->nombre." ".$usuario->apellido;
                        $_SESSION['correo']=$usuario->correo;
                        $_SESSION['login']=true;

                        //Redireccionamiento

                        if($usuario->tipo==="1"){
                            //admin
                            
                            $_SESSION['admin']= $usuario->tipo ?? null;
                            
                            header('Location: /admin');
                        }else{
                            //cliente
                            header('Location: /cita');

                        }

                    }
                }else {
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/login',['alertas'=>$alertas]);
    }
    public static function logout(){
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $auth->validarCorreo();
            if(empty($alertas)){
                $usuario= Usuario::where('correo',$auth->correo);
                
                if($usuario && $usuario->confirmado==="1"){
                    //Generar token
            
                    $usuario->crearToken();
                    $usuario->guardar();

                    $correo=new Email($usuario->correo,$usuario->nombre,$usuario->token);
                    $correo->enviarInstrucciones();
                    Usuario::setAlerta('exito', 'Revisa tu email');

        
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                    
                }
            }
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/olvide-password',[
            'alertas'=>$alertas
        ]);
    }




    public static function recuperar(Router $router){

        $alertas=[];
        $error=false;
        
        $token= s($_GET['token']);

        //Busqueda de usuario

        $usuario= Usuario::where('token',$token);

        if(empty($usuario)){
            Usuario::sertAlerta('error','Token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $password= new Usuario($_POST);
            $alertas= $password->validarPassword();

            if(empty($alertas)){
                $usuario->password=null;

                $usuario->password=$password->password;
                $usuario->token=null;
                $usuario->hashPassword();   
                $resultado=$usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }
        $alertas=Usuario::getAlertas();
        
        $router->render('auth/recuperar-password',['alertas'=>$alertas,'error'=>$error]);
    }
    public static function crear(Router $router){
        $usuario = new Usuario($_POST);
        //Alertas 
        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] ==='POST' ){
            $usuario->sincronizar($_POST);
            
            $alertas=$usuario->validarNuevaCuenta();
            //Revisar las alertas
            if(empty($alertas)){
                 //Verificar Usuario no exista
                $resultado=$usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else{
                    //No esta registrado
                    $usuario -> hashPassword();

                    $usuario -> crearToken();
                    
                    //Enviar Email

                    $email=new Email($usuario->correo,$usuario->nombre,$usuario->token);

                    $email->enviarConfirmacion();

                    //Crear Usuario
                    
                    $resultado=$usuario->guardar();
                    //debuguear($resultado);
                    if($resultado){
                         header('Location: /mensaje');
                    }

                }
            }
        }
            $router->render('auth/crear-cuenta',[
                'usuario'=> $usuario,
                'alertas' => $alertas

            ]);
        
        
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router){
        $alertas=[];
        $token=s($_GET['token']);
        $usuario= Usuario::where('token',$token);
        if(empty($usuario)){
            //Mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        }else{
            //Confirmar usuario
            echo "Token valido";
            $usuario->confirmado="1";
            $usuario->token=null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',['alertas'=> $alertas]);
    }

}

