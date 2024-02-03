<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de Servicios</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    date_default_timezone_set('America/Mexico_City');
?>
 <h1>Buscar Servicios</h1>
<div class="campo">
    <input class="formulario" type="text" placeholder="Buscar..." name="buscador" id="buscador">
</div>
<ul class="servicios">
    <?php foreach($servicios as $servicio){ ?>
        <li class="cada-uno">
            <p>id.- <span><?php echo $servicio->id; ?></span></p>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

            <div class="acciones">
                <a class="boton verde" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>

                <form id="eliminar-form" action="/servicios/eliminar" method="POST">
                    <input type="hidden"
                            name="id"
                            value="<?php echo $servicio -> id;?>"
                    />
                    <input type="submit"
                            value="Borrar"
                            class="boton-eliminar"
                    />
                </form>
            </div>
        </li>
    <?php }?> <!--Fin foreach-->
</ul>
<script src="build/js/buscador.js"></script>
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