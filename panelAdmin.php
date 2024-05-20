<?php
session_start();

//Variables de conexion:
$ubicacionDB = "localhost:3307";
$usuarioDB = "root";
$claveDB = "12345";
$nombreDB = "BaseDatosTransporte";

//Crea la conexion a la BD MySQL dentro de DOcker
$datosConexion = mysqli_connect($ubicacionDB,$usuarioDB, $claveDB, $nombreDB);

//Compureba que si se haya conectado 
if (!$datosConexion){
    die("Conexion a la BD fallida: ".mysqli_connect_error());
}
else{
echo "Conectado a la base de datos de Transcosas <hr>";
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>PANEL ADMIN</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Style.css">
</head>

<body>
    <div class="panel">
        <div>
            <h3>USUARIO</h3>

            <hr>
        </div>
        <ul>
            <li><a href="#empleados">Empleados</a></li>
            <li><a href="#camiones">Camiones</a></li>
            <li><a href="#rutas">Rutas</a></li>

        </ul>
    </div>
    <div class="content">
        <div id="empleados" class="section">
            <h2>Empleados</h2>
            <p>Contenido de Empleados.</p>
            <form action="panelAdmin.php" method="post">
                <input type="text" id="nombre" name="Nombre" placeholder="Nombre" required><br><br>
                <input type="text" id="Apellido" name="Apellido" placeholder="Apellido" required><br><br>
                <input type="text" id="Telefono" name="Telefono" placeholder="Telefono" required><br><br>
                <input type="text" id="TipoUsuario" name="TipoUsuario" placeholder="Administrador/Usuario" required><br><br>

                <input type="submit" value="Agregar">
            </form>

        <?php
        if (isset($_POST["Nombre"]) && isset($_POST["Apellido"]) && isset($_POST["Telefono"]) && && isset($_POST["TipoUsuario"])) {

            $nombreEmpleado = mysqli_real_escape_string($datosConexion, $_POST["Nombre"]);
            $apellidoEmpleado = mysqli_real_escape_string($datosConexion, $_POST["Apellido"]);
            $telefono = 
            $tipoUsuario = mysqli_real_escape_string($datosConexion, $_POST["TipoUsuario"]);

            $sql = "INSERT INTO Empleados (NombreEmpleado, "

        }
        ?>


            <div>
                <h2>Usuarios Registrados</h2>
                <table border="3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Username</th>
                            <th>Contraseña</th>
                            <th>Tipo </th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <!--<?php while ($row = mysqli_fetch_array($query)): ?> -->
                            <tr>
                                <th><?= $row["id"] ?></th>
                                <th><?= $row["nombre"] ?></th>
                                <th><?= $row["apellido"] ?></th>
                                <th><?= $row["username"] ?></th>
                                <th><?= $row["contraseña"] ?></th>
                                <th><?= $row["tipo"] ?></th>


                                <th><a href="">Editar</a></th>
                                <th><a href="">Eliminar</a></th>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="camiones" class="section">
            <h2>Camiones</h2>
            <p>Contenido de Camiones.</p>
        </div>
        <div id="rutas" class="section">
            <h2>Rutas</h2>
            <p>Contenido de Rutas.</p>
        </div>
        <div id="productos" class="section">
            <h2>Productos</h2>
            <p>Contenido de Productos.</p>
        </div>
        <div id="proveedores" class="section">
            <h2>Proveedores</h2>
            <p>Contenido de Proveedores.</p>
        </div>
    </div>


</body>

</html>