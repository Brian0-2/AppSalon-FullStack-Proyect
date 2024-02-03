
    <h2 class="nombre-pagina">Login</h2>
        <p class="descripcion-pagina">Iniciar Sesión con tus Datos</p>
        <!-- Incluir mis alertas de validacion -->
        <?php include_once __DIR__ .'/../templates/alertas.php';?>

<form  class="formulario" method="POST" action="/">

    <div class="campo">
        <label for="email">Correo@</label>

        <!-- type = tipo de input
             name = el nombre que toma para el metodo GET    -->
        <input type="text"
            type="email"
            id="email"
            placeholder="Tu correo@"
            name="email"
        />
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" 
               id="password"
               placeholder="Tu contraseña" 
               name="password" 
        />
    </div>

    <input type="submit" class="boton" value="!Iniciar Sesión¡">
</form>

<div class="acciones">
    <!--la ruta "/Es para crear-cuenta"-->
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?<br> <span>Crear Una</span></a>
    <!--la ruta "/Es para crear-cuenta"-->
    <a href="/olvide">¿Olvidaste tu contraseña?<br> <span>Recuperarla</span></a>
</div>