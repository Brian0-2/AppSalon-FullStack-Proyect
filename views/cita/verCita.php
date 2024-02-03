<h1 class="nombre-pagina">Ver Citas</h1>
<p class="descripcion-pagina">Visualiza tus citas</p>


<div class="barra">
    <p><span>! </span>Hola: <?php echo $nombre ?? ''; ?><span> ¡</span> </p>
    <a class="boton" href="/logout"><span> > </span> Cerrar Sesion <span>
            < </span></a>
    <a class="boton" href="/cita"><span> - </span> Volver <span> - </span></a>
</div>

<div class="citas-admin">
    <?php

    if (count($apartadas) === 0) {
        echo "<h3>No hay Citas</h3>";
    } else {
        echo "<h3>Horarios Apartados</h3>";
    }

    $idCita = $apartadas->id;
    $fecha = date('Y-m-d');
    foreach ($apartadas as $key => $apartado) :
        // Agrupar servicios por cita y sumar precios
        $servicios = array();
        $total = 0;
        $horaCita = strtotime($apartado->hora);
        $horaActual = time();
        foreach ($apartadas as $apartado_servicio) {
            if ($apartado_servicio->id == $apartado->id) {
                array_push($servicios, $apartado_servicio->servicio);
                $total += $apartado_servicio->precio;
            }
        }

        $servicios = implode(", ", $servicios);
        if ($idCita !== $apartado->id) :
    ?>
            <ul class="citas">
                <li>
                    <?php if ($apartado->fecha !== $fecha) { ?>
                        <h2>Fecha Pasada</h2>
                    <?php
                    } else { ?>
                        <h2>Fecha Actual</h2>
                    <?php } ?>
                    <p>ID Cita: <span><?php echo $apartado->id; ?></span> </p>
                    <p>Nombre: <span><?php echo $apartado->cliente; ?></span> </p>
                    <p>Fecha: <span><?php echo $apartado->fecha; ?></span> </p>
                    <p>Horas: <span><?php echo date('h:i A', $horaCita); ?></span></p>
                    <p>Servicios: <span><?php echo $servicios . "."; ?></span> </p>
                    <p>Total: <span><?php echo '$' . $total; ?></span> </p>
                </li>
                <?php ?>
            </ul>
        <?php
            $idCita = $apartado->id;
        endif;
        ?>

    <?php endforeach; ?>
</div>