<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bcb64c38d6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/EstiloPanel.css">

</head>
<header>
    <nav>
        <ul>
            <li><a href="#panelEmpleado.php">INICIO</a></li>
            <li><a href="#ruta">RUTAS</a></li>
            <li><a href="#vehiculos">VEHICULOS</a></li>
            <li><a href="#cargas">CARGAS</a></li>
            <li class="posicionLogin"><a href="/logout">Cerrar sesión</a></li>


        </ul>
    </nav>

</header>

<?php ?>
/* quitar este (?>) */
<!--
// Conexión a la base de datos y consulta para obtener la información del empleado
//$conexion = mysqli_connect("localhost", "usuario", "contraseña", "nombre_basedatos");
/*if ($conexion === false) {
    die("Error: No se pudo conectar. " . mysqli_connect_error());
}

$id_empleado = $_GET['id']; // Suponiendo que recibes el ID del empleado por algún medio

$query_empleado = "SELECT nombre, apellido, usuario, foto FROM empleados WHERE id = $id_empleado";
$resultado_empleado = mysqli_query($conexion, $query_empleado);
if ($resultado_empleado) {
    $empleado = mysqli_fetch_assoc($resultado_empleado);
    ?>
-->

*/

<body>
    <div id="panelEmpleado" class="content-section">

        <h1>Información del Empleado</h1>

        <p><b>Nombre:</b> </p>
        <p><b>Apellido:</b> </p>
        <p><b>Usuario:</b> </p>
    </div>

    <div class="ImagenEmpleado">
        <img src="imagenesTranscosas/Logo.png" alt="Foto de perfil">
    </div>





    <div id="ruta" class="content-section">
        <?php
        //} else {
//    echo "Error al obtener la información del empleado.";
//}
        

        // Consulta para obtener las rutas del día
        $query_rutas = "SELECT * FROM rutas WHERE fecha = CURDATE()";
        //$resultado_rutas = mysqli_query($conexion, $query_rutas);
        //if ($resultado_rutas) {
        ?>

        <h2>Rutas del Día</h2>
        <ul>
            <?php //while ($ruta = mysqli_fetch_assoc($resultado_rutas)) { ?>
            <li><?php //echo $ruta['nombre_ruta']; ?></li>
            <?php //} ?>
        </ul>

        <?php
        //} else {
        //    echo "Error al obtener las rutas del día.";
        //}
        
        //mysqli_close($conexion);
        ?>



    </div>

    <div id="vehiculos" class="content-section">
        <!-- Contenido de vehículos -->
    </div>

    <div id="cargas" class="content-section">
        <!-- Contenido de cargas -->
    </div>


</body>

</html>