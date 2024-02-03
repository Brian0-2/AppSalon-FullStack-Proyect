<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function citas(){
        $citas = Cita::fh();
        echo json_encode($citas);
    }

    public static function guardar(){

        // Almacena la Cita y devuelve el ID
         $cita = new Cita($_POST);
         $resultado = $cita->guardar();

        $id = $resultado['id'];

         // Almacenar los servicios con el id de la cita
        $idServicios = explode(',', $_POST['servicios']);
        foreach($idServicios as $idServicio){
            $args = [
                'cita_id' => $id,
                'servicio_id' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        //Retorno respuesta
        echo json_encode(['resultado' => $resultado]);
}
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id']; //guardamos el id
            $cita = Cita::find($id);//Encontramos el id
            $cita->eliminar();//Eliminamos el id

            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
