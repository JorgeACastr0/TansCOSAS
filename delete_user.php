<?php
session_start();

//Variables de conexion:
$ubicacionDB = "localhost:3307";
$usuarioDB = "root";
$claveDB = "12345";
$nombreDB = "BaseDatosTransporte";

//Crea la conexion a la BD MySQL dentro de DOcker
$datosConexion = mysqli_connect($ubicacionDB, $usuarioDB, $claveDB, $nombreDB);

//Compureba que si se haya conectado 
if (!$datosConexion) {
    die("Conexion a la BD fallida: " . mysqli_connect_error());
} else {
    echo "Conectado a la base de datos de Transcosas <hr>";
}


$id = $_POST["IDEmpleado"];

$sqlEliminar = "DELETE FROM Usuarios WHERE id='$id'";
$query = mysqli_query($datosConexion, $sqlEliminar);

if ($query) {
    Header("Location: panelAdmin.php");
} else {

}

?>