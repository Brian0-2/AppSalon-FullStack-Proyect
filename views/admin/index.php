<h1 class="nombre-pagina">Panel de ADMINISTRACION</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
date_default_timezone_set('America/Mexico_City');
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
            type="date" 
            id="fecha" 
            name="fecha" 
            value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>
<?php 
    if(count($citas) === 0){
        echo "<h2 class='no-hay-citas'>No hay Citas en esta fecha</h2>";
    }
?>
<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        $contador = 0;
        foreach ($citas as $key => $cita) {

            if ($idCita !== $cita->id) {
                $total = 0;
        ?>
                <li>
                    <h3> <?php echo $contador += 1; ?>.- Cliente</h3>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Num.Cita: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>
        <?php
                $idCita = $cita->id;
            } //FIN IF
                $total += $cita->precio;
            ?>

                    <p class="servicio"> <?php echo $cita->servicio." ". $cita->precio; ?> </p>
                <?php
                $actual = $cita -> id;
                $proximo = $citas[$key + 1] ->id ?? 0;

                if(esUltimo($actual, $proximo)){ ?>
                   <p class="total">Total: <span>$ <?php echo $total; ?> </span> </p>
                   
                    <form id="eliminar-form" action="/api/eliminar" method="POST">
                        <input type="hidden"
                               name="id"
                               value="<?php echo $cita->id; ?>"
                               />
                        <input type="submit"
                               class="boton-eliminar"
                               value="Eliminar"
                               />
                    </form>

                <?php } 
            } //FIN FOREAChH?>
            <li>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    var formularios = document.querySelectorAll("form#eliminar-form");
    for (var i = 0; i < formularios.length; i++) {
        formularios[i].addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que la página se recargue al hacer clic en el botón

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción Borrara tus datos',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Borrar',
                cancelButtonText: 'No,Cancelar',
                customClass: {
                    popup: 'tamaño-alerta'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Envía el formulario
                }
            });
        });
    }
</script>
<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>