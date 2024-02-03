<?php

namespace Model;

//Extiende de active record para usar mis metodos
class Servicio extends ActiveRecord{
    //Base de datos
    //objeto
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];

    //atributos
    public $id;
    public $nombre; 
    public $precio;

    public function __construct($args = []) {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? '';
        $this -> precio = $args['precio'] ?? '';
    }

    public function validar() {
        if(!$this->nombre){
            self::$alertas['error'][] ='El Nombre del Servicio es Obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] ='El Precio del Servicio es Obligatorio';
        }
        if(!is_numeric($this->precio)){
            self::$alertas['error'][] ='El Precio NO es Valido';
        }

        return self::$alertas;
    }

}

?>
