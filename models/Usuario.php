<?php
namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','correo','telefono','tipo','confirmado','token','password'];
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;
    public $tipo;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($args =[]){
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->apellido=$args['apellido'] ?? '';
        $this->correo=$args['correo'] ?? '';
        $this->telefono=$args['telefono'] ?? '';
        $this->tipo=$args['tipo'] ?? null;
        $this->confirmado=$args['confirmado'] ?? null;
        $this->token=$args['token'] ?? 0;
        $this->password=$args['password'] ?? '';

    }

    //Mensajes de Validacion para la creacion de la cuenta

    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][]= 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]= 'El apellido es obligatorio';
        }
        if(!$this->correo){
            self::$alertas['error'][]= 'El correo es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]= 'El password es obligatorio';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]= 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    //Revision de usuario existente
    public function existeUsuario(){
        $query= "SELECT *FROM ". self::$tabla." WHERE correo ='".$this->correo."' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado -> num_rows){
            self::$alertas['error'][]= 'El Usuario ya esta registrado';
        }

        return $resultado;
        
    }
    public function validarLogin(){
        if(!$this->correo){
            self::$alertas['error'][]='El Correo es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]='El Password es obligatorio';
        }

        return self::$alertas;
    }
    public function validarCorreo(){
        if(!$this->correo){
            self::$alertas['error'][]='El Correo es obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]= "El password es obligatorio";
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]="Debe tener al menos 6 caracteres";
        }
        return self::$alertas;
    }

    public function  hashPassword(){
        $this->password= password_hash($this->password,PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado= password_verify($password,$this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][]= "Password incorrecto o cuenta sin confirmar";
        }else{
            return true;
        }
    }
}   