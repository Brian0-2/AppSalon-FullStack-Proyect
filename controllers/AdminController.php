<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        session_start();

        isAdmin();

        date_default_timezone_set('America/Mexico_City');
        
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-',$fecha);

        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
            header('Location: /404');
        }

        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuario_id=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.cita_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicio_id ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        // debuguear($consulta);
       $citas = AdminCita::SQL($consulta);
        // debuguear($consulta);
        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas'=>$citas,
            'fecha' =>$fecha
        ]);
    }
}