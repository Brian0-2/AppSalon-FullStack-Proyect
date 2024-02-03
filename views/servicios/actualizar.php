<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los Valores del Formulario</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="fromulario">
    
<?php include_once __DIR__ . '/formulario.php';?>

    <input type="submit" 
           class="boton" 
           id="actualizar" 
           value="Actualizar">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("actualizar").onclick = function(event) {
    event.preventDefault(); // Evita que la página se recargue al hacer clic en el botón
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción actualizará tus datos',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'No,Cancelar',
        customClass: {
                    popup: 'tamaño-alerta'
                }
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector(".fromulario").submit(); // Envía el formulario
        }
    });
};
</script>
