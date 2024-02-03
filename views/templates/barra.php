<div class="barra">
    <p><span>! </span>Hola:  <?php echo $nombre ?? ''; ?><span> ¡</span> </p>
    <a class="boton" href="/logout"><span> > </span> Cerrar Sesion <span> < </span></a>
   <?php  $isAdmin = $_SESSION['admin'];
        if($isAdmin !== '1'):
        ?>
        <a class="boton" href="cita/verCita"><span> - </span> Ver citas <span> - </span></a>
   <?php endif; ?>
    
</div>

<?php if(isset($_SESSION['admin'])){?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>

<?php } ?>

