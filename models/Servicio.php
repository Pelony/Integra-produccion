<?php 
namespace Model;

class Servicio extends ActiveRecord{
    //Base de datos

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio','descripcion'];

    public $id;
    public $nombre;
    public $precio;
    public $descripcion;
   

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][]= 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][]= 'El precio del servicio es obligatorio';
        }
        if(!$this->descripcion){
            self::$alertas['error'][]= 'La descripcion del servicio es obligatorio';
        }
        if(!is_numeric($this->precio)){
            self::$alertas['error'][]= 'El precio debe ser numerico';
        }
        return self::$alertas;
    }
}