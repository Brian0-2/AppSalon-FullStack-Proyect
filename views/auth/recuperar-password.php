<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu Nueva Contraseña a Continuacion</p>

<?php include_once __DIR__ .'/../templates/alertas.php';?>

<!-- VALIDAR MI VISTA SI EL TOKEN ESTA MAL O VACIO -->
<?php if($error) return; ?>
<form class="formulario" method="POST" >
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="text"
            id="password"
            name="password"
            placeholder="Tu Nueva Contraseña"
        />
    </div>
    <input type="submit" class="boton" value="Guardar Nueva Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes Cuenta?<br> <span>Iniciar Sesión</span></a>
    <a href="/crear-cuenta">¿Aun no Tienes Cuenta?<br> <span>Iniciar Sesión</span></a>
</div>