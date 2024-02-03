<?php
//Controlador
namespace Controllers;
//Me importa mis clases con los Modelos 
use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    //METODO PARA VALIDAR USUARIO
    public static function login(Router $router) {
        $alertas = [];

        //Verificar que la peticion fue echa por metodo post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            //validar si los campos estan vacios 
            if (empty($alertas)) {

                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                //Verificar usuario
                if ($usuario) {
                    //Autenticar el usuario
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {

                        session_start();
                        //USUARIO INICIANDO SESION CON...
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //REDIRECCIONAMIENTO admin o cliente 
                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            //ruta para admin
                            header('Location: /admin');
                        } else {
                            //ruta para clientes
                            header('Location: /cita');
                        }
                    }
                    //Error de login , no validado
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado...');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas' =>$alertas    
        ]);
    }
//Funcion para deslogear a mis usuarios
    public static function logout() {
         session_start();
         $_SESSION = [];
         header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];
        //Validar datos por post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //objeto para mis vistas
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            //Validar si si cumple con las alertas
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                //Confirmar que exista el correo electronico me devuelve un 1 registro del correo
                if ($usuario && $usuario->confirmado === '1') {
                    //Generar token de validacion
                    //Mando a llamar mis metodos
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario ->email,$usuario ->nombre, $usuario ->token );
                    //Mando a llamar mi metodo
                    $email ->enviarInstrucciones();


                    //Alerta al usuario
                    Usuario::setAlerta('exito', '¡Revisa tu correo!');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        //Renderisar vistas de alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    //RECUPERAR CONTRASEÑAS
    public static function recuperar(Router $router)
    {
        $alertas = [];

        $error = false;

        //Tomar token desde recuperar-password
        $token = s($_GET['token']);

        //Buscar al usuario por su toquen
        $usuario = Usuario::where('token', $token);

        //Si el token esta vacio o invalido
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }
        //Guardar la password y insertarlo en la bd
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);
            //Mando a llamar mi metodo
            $alertas = $password->validarPassword();

            if (empty($alertas)) {
                //Borro mi password anterior
                $usuario->password = null;
                //Coloca la nueva en mi nuevo objeto usuario
                $usuario->password = $password->password;
                //"Encripto" password
                $usuario->hashPassword();
                //Elimino de mi usuario su token
                $usuario->token = null;

                //Redirecciono a Login
                $resultado =  $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        //Le paso los datos a mi instancia por POST
        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];
        //Funcion para escuchar por el index.php que esta en public por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar si el usuario coloco toda la informacion
            if (empty($alertas)) {

                //Verificar si el usuario no esta registrado
                $resultado = $usuario->existeUsuario();

                //Validacion para ver que las validaciones han sido pasadas
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //No esta registrado insercion a la base de datos y se hashea
                    $usuario->hashPassword();


                    //Generacion de Token
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear usuario
                    $usuario = $usuario->guardar();
                    header('Location: /mensaje');

                    // debuguear($usuario);
                }
            }
        }

        //Vista de crear cuenta
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

//MANDAR A VENTANA DE CONFIRMACION
    public static function mensaje(Router $router) {
        //ruta
        $router->render('auth/mensaje');
    }
    
//CONFIRMAR USUARIO
    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        //Mando a llamar mi metodo en activerecord para la insercion a la base de datos
        $usuario = Usuario::where('token', $token);

        //Valido mi usuasrio en bd
        if (empty($usuario)) {

            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no valido...');

        } else {
            //Modificar a usuario confirmado
            $usuario-> confirmado = '1';
            $usuario -> token = null;

            //Metodo para guardar a db
            //Lo mando a llamar 
            $usuario ->guardar();

            //Mostrar al usuario
            Usuario::setAlerta('exito','¡Token valido Correctamente...!');
        }
        //Renderizo la vista con las alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}

?>