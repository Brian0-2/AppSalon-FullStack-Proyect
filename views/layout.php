<!-- //ESTRUCTURA DE MI HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy-Citas App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="shortcut icon" type="image/png" href="../src/img/salon.png">
    <!-- <link rel="shortcut icon" type="image/png" href="/ruta/al/archivo/favicon.png"> -->
</head>

<body>
    <a href="/logout">
        <h1 class="logo-pagina">Easy-Citas AppSalon</h1>
    </a>
    <div class="contenedor-app">
        <div class="imagen"></div>
            <div class="app">
                <?php echo $contenido; ?>
            </div>
    </div>
    <!-- Esta variable solo esta creada en cita/index.php una vez logeado mi usuario -->
    <?php
    echo $script ?? '';
    ?>
    <footer class="footer">
        <div class="contenedor">

            <nav class="navegacion-footer">
                <a href="/logout">Login</a>
                <a href="/crear-cuenta">Crear Una</a>
                <a href="/olvide">Recuperar</a>
            </nav>
            <p>All Rights ing.Valdivia &copy; 2023</p>
        </div>
    </footer>

</body>

</html>