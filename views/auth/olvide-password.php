<h2 class="nombre-pagina">¿Olvide mi Contraseña?</h2>
    <p class="descripcion-pagina">Restablece tu Contraseña Escribiendo tu correo</p>

    <?php include_once __DIR__ .'/../templates/alertas.php';?>
    
    <form class="formulario" action="/olvide" method="POST">
        <div class="campo">
            <label for="email">Correo</label>
            <input 
                type="email"
                id="email"
                name="email"
                placeholder="Tu Correo@"
            />
        </div>

        <input 
            class="boton"
            type="submit"
            value="¡Envia Instrucciones!"
        />
    </form>

    <div class="acciones">
        <!--la ruta "/Es para login"-->
        <a href="/">¿Ya Creaste tu Cuenta?<br> <span>Iniciar Sesión</span></a>
        <a href="/crear-cuenta">¿Aun no Tienes Cuenta?<br> <span>Crea Una</span></a>
    </div>