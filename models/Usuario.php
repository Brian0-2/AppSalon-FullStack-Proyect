<?php

namespace Model;
//active record contiene los metodos para mi base de datos esta en models
class Usuario extends ActiveRecord
{

    //Identifico la tabla a la que voy a manipular
    protected static $tabla = 'usuarios';
    //Identifico las columnas a las que voy a manipular
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
//ATRIBUTOS
    //Creo atrubuto por cada una de las columnas
    //para acceder en la misma clase o al objeto una vez que se instancian
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

//CONSTRUCTOR
    //Definimos el constructor con argumentos pero por default esta vacio
    public function __construct($args = [])
    {
        //Le paso los argumentos y en caso de no estar presente que agrege vacio o null
        $this->id = $args['id'] ?? null;
        $this->nombre  = $args['nombre'] ?? '';
        $this->apellido  = $args['apellido'] ?? '';
        $this->email  = $args['email'] ?? '';
        $this->password  = $args['password'] ?? '';
        $this->telefono  = $args['telefono'] ?? '';
        $this->admin  = $args['admin'] ?? '0';
        $this->confirmado  = $args['confirmado'] ?? '0';
        $this->token  = $args['token'] ?? '';

    }

//MENSAJES DE VALIDACION
//VALIDACION DE CREAR CUENTA
    public function validarNuevaCuenta() {
        //referencia de un atributo de mi objeto
        $confirmar_password = $_POST['confirm_password'];

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es Obligatorio';
        }else if (!preg_match('/^[a-zA-Z]+$/', $this->nombre)) {
            self::$alertas['error'][] = 'El Nombre debe contener solo letras';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es Obligatorio';
        } else if (!preg_match('/^[a-zA-Z]+$/', $this->apellido)) {
            self::$alertas['error'][] = 'El apellido debe contener solo letras';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es Obligatorio';

        }else if(strlen($this -> telefono) > 10){
            self::$alertas['error'][] = 'El numero de celular es solo de 10 numeros';

        }else if (strlen($this->telefono) <=9) {
            self::$alertas['error'][] = 'El numero de celular debe de contener por lo menos (10) letras';
        }else if (!is_numeric($this->telefono)){
            self::$alertas['error'][] = 'No es valido el numero de celular';

        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El correo@ es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es Obligatoria';
        }

        if (strlen($this->password) < 6 && $this->password !== '') {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        if ($this->password !== $confirmar_password) {
            self::$alertas['error'][] = 'La contraseña y la confirmación de la contraseña no coinciden';
        }

        return self::$alertas;
    }

//VALIDAR MI USUARIO
    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        }

        return self::$alertas;
    }

//VALIDAR LA CONTRASEÑA
    public function validarEmail(){
        if(!$this ->email){
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        return self::$alertas;
    }

//VALIDAR LA PASSWORD EN RECUPERRAR CUENTA
    public function validarPassword(){
        if(!$this -> password){
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        }
        if(strlen($this -> password)< 6){
            self::$alertas['error'][] = 'La Contraseña Debe Contener por lo menos (6) Caracteres';
        }
        
        return self::$alertas;
    }

//VALIDAR SI EL USUARIO YA EXISTE
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            //Agrego a mis alertas
            self::$alertas['error'][] = 'El Usuario ya Esta Registrado';
        }
        return $resultado;
    }

//HASHEAR PASSWORD
    public function hashPassword() {                      //metodo de hash
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

//CREAR TOKEN USUARIOS
    public function crearToken() {
        //metodo de creacion de token 13 digitos
        $this->token = uniqid();
    }

//VALIDAR usuario en base de datos
    public function comprobarPasswordAndVerificado($password){
        //metodo que me retorna true o false
       $resultado = password_verify($password,$this ->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Contraseña incorrecta o tu cuenta no a sido confirmada';
        }else{
           return true;
        }
    }
}