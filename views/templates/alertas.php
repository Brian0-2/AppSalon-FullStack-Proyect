<?php
//METODO PARA RECORRER MIS ALERTAS PARA MIS VALIDACIONES
foreach ($alertas as $key => $mensajes) :
    foreach ($mensajes as $mensaje) :

?>
        <!--IMPRIMIR ALERTAS POR VALIDACION -->
        <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>

<?php
    endforeach;
endforeach;
?>