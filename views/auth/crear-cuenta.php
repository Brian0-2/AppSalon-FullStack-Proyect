<h2 class="nombre-pagina">Crear Cuenta</h2>
<p class="descripcion-pagina">Llena los Siguientes Espacios Para Crear una Cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Tu Nombre</label>
            <input 
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Tu Nombre"
                value="<?php echo s($usuario -> nombre);?>"
        />
    </div>
    <div class="campo">
        <label for="apellido">Tu Apellido</label>
            <input 
                type="text"
                id="apellido"
                name="apellido"
                placeholder="Tu Apellido"
                value="<?php echo s($usuario -> apellido);?>"
        />
    </div>
    <div class="campo">
        <label for="telefono">Tu Telefono</label>
            <input 
                type="tel"
                maxlength="10"
                id="telefono"
                name="telefono"
                placeholder="Tu Telefono"
                value="<?php echo s($usuario -> telefono);?>"
        />
    </div>
    <div class="campo">
        <label for="email">Tu correo</label>
            <input 
                type="email"
                id="email"
                name="email"
                placeholder="Tu Correo@correo"
                value="<?php echo s($usuario -> email);?>"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholder="Tu Contraseña"
        />
    </div>
    <div class="campo">
    <label for="confirm_password">Confirmar Contraseña</label>
            <input 
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirmar Contraseña"
               
    />
    </div>

        <input type="submit" value="¡Crear Cuenta!" class="boton">

</form>

    <div class="acciones">
        <!--la ruta "/Es para login"-->
        <a href="/">¿Ya Creaste tu Cuenta?<br> <span> Iniciar Sesión</span></a>
        <a href="/olvide">¿Olvidaste tu Contraseña?<br> <span>Recuperala</span></a>
    </div>
  