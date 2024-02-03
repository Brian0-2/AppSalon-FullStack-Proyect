<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML libre de caracteres raros
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo):bool {
    if($actual!== $proximo){
        return true;
    }else{
        return false;
    }
}

//Funcion para rpoteger mis rutas para saber si mi usuario esta autentidaco

function isAuth() : void{
     if(!isset($_SESSION['login'])){
         //enviar a iniciar sesion
         header('Location: /');
     }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}