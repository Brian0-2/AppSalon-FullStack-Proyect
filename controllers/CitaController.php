<?php

namespace Controllers;

use Model\AdminCita;
use Model\Cita;
use MVC\Router;

class CitaController
{

    public static function index(Router $router)
    {
        session_start();
        //Funcion para verificar usuairo
        isAuth();
        date_default_timezone_set('America/Mexico_City');

        $addFecha = $_GET['addFecha'] ?? date('Y-m-d');

        if (!$addFecha) {
          header('Location: /404');
          exit;
        }
        
        $fechas = explode('-', $addFecha);

        if (count($fechas) < 3) {
        header('Location: /404');
        exit;
        }

      list($ano, $mes, $dia) = $fechas;
      if (!is_numeric($ano) || !is_numeric($mes) || !is_numeric($dia)) {
      header('Location: /404');
      exit;
      }

      if (!checkdate($mes, $dia, $ano)) {
      header('Location: /404');
      exit;
      }
        
      $currentDate = date('Y-m-d');
      if ($addFecha < $currentDate) {
        header('Location: /404');
          
        exit;
      }
        

        $consult = "SELECT * FROM citas WHERE ";
        $consult .= "fecha = '{$addFecha}'";

        $ocupadas = Cita::SQL($consult);

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
            'ocupadas' => $ocupadas,
            'addFecha' => $addFecha

        ]);
    }
    
    public static function verCitas(Router $router){
      session_start();
      //Funcion para verificar usuairo
      isAuth();
      $usuario = $_SESSION['id'];

      $query ="SELECT citas.id, citas.hora, citas.fecha, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, 
               servicios.nombre as servicio, servicios.precio   
              FROM citas   
              LEFT OUTER JOIN usuarios  
                ON citas.usuario_id=usuarios.id   
              LEFT OUTER JOIN citasservicios  
                ON citasservicios.cita_id=citas.id  
              LEFT OUTER JOIN servicios  
                ON servicios.id=citasservicios.servicio_id  
              WHERE citas.usuario_id = {$usuario} 
 ";

      
      $apartadas = AdminCita::SQL($query);

      //debuguear($query);
      $router->render('cita/verCita',[
        'nombre' => $_SESSION['nombre'],
        'apartadas' => $apartadas
      ]);
    }
}
