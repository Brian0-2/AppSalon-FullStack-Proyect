
<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos.</p>

<?php 
include_once __DIR__ . '/../templates/barra.php';
date_default_timezone_set('America/Mexico_City');
?>
<div class="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios Informacion Cita</button>
        <button type="button" data-paso="2">Servicios Cita</button>
        <button type="button" data-paso="3">Resumen Cita</button>
    </nav>
   
    <div id="paso-2" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion.</p>
        <input class="formulario" type="text" id="buscar" placeholder="Buscar...">
        <br>
        <br>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-1" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita.</p>
            
        <form class="formulario">
            <p><span>Nota:</span> De Lunes a Viernes son de: 9:00 AM a 9:00 PM.  </p>
            <p><span>Ojo:</span> Los Sabados son de : 6:00 AM a 9:00 PM. </p>
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input  id="nombre" 
                            type="text" 
                            placeholder="Tu nombre" 
                            value="<?php echo $nombre; ?>" 
                            disabled 
                            />
                </div>

                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <input  id="fecha" 
                            type="date" 
                            min ="<?php echo date('Y-m-d'); ?>"
                            name="fecha" 
                            value="<?php echo $addFecha; ?>"
                           
                            />
                  </div>

                <div class="campo">
                    <label for="hora">Hora</label>
                    <input  id="hora" 
                            type="time" 
                            name="hora"
                            />
                </div>
               <div class="citas-user">
               <?php 
                        if(count($ocupadas) === 0){
                            echo "<h3>Horarios Libres</h3>";
                        }else{
                            echo "<h3>Horarios Ocupados</h3>";
                        }
                    ?>
                   <div class="ocupadas">
                                    
                     <?php
                    foreach ($ocupadas as $key => $ocupada):
                        if ($idCita !== $ocupada->id):

                            $total = 0;
                            $horaCita = strtotime($ocupada->hora);
                            $horaActual = time();

                            // Si han pasado más de una hora desde la hora de la cita, no la mostramos
                            if ($horaActual - $horaCita >= 3600):
                                continue;
                            endif;
                            ?>
                                <li>
                                    <p>Horas: <span><?php echo date('h:i A', $horaCita); ?></span></p>
                                </li>
                            <?php

                            $idCita = $ocupada->id;
                        endif;
                    endforeach;
                ?>

                   </div>
               </div>
                <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form> 
        
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p>Verifica que tu informacion sea correcta</p>
    </div>
    <div class="paginacion">
        <button id="anterior"  class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php
//Mi variable script solo esta creada en este archivo por eso es que no me afecta mi index.php /principal o login
$script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>   
    ";
?>
