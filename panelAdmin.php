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
            <li><a href="#cargas">Cargas</a></li>
            <hr id="lineagruesa">

            <li id="agregar"><a href="#generarOrden">Generar Orden</a></li>

        </ul>
    </div>
    <div class="content">
        <div id="empleados" class="section">
            <h2>Empleados</h2>
            <p>Contenido de Empleados.</p>
            <form action="panelAdmin.php" method="post">
                <input type="number" id="cedula" name="Cedula" placeholder="Cedula" required><br><br>
                <input type="text" id="nombre" name="Nombre" placeholder="Nombre" required><br><br>
                <input type="text" id="Apellido" name="Apellido" placeholder="Apellido" required><br><br>
                <input type="text" id="Usuario" name="Usuario" placeholder="Usuario" required><br><br>
                <input type="text" id="Clave" name="Clave" placeholder="Clave" required><br><br>
                <input type="number" id="Telefono" name="Telefono" placeholder="Telefono" required><br><br>
                <input type="text" id="TipoUsuario" name="TipoUsuario" placeholder="Administrador/Usuario"
                    required><br><br>

                <input type="submit" value="Agregar">
            </form>

            <?php
            if (isset($_POST["Nombre"]) && isset($_POST["Cedula"]) && isset($_POST["Apellido"]) && isset($_POST["Telefono"])) {

                $nombreEmpleado = mysqli_real_escape_string($datosConexion, $_POST["Nombre"]);
                $apellidoEmpleado = mysqli_real_escape_string($datosConexion, $_POST["Apellido"]);
                $telefono = $_POST["Telefono"];
                $ID = $_POST["Cedula"];


                $insertarEmpleadosSQL = "INSERT INTO Empleados (IDEmpleado, NombreEmpleado, Telefono, ApellidoEmpleado) VALUES ($ID,'$nombreEmpleado', $telefono, '$apellidoEmpleado');";
                mysqli_query($datosConexion, $insertarEmpleadosSQL);
                echo "Se han introducidos los siguientes datos:" . $nombreEmpleado . $apellidoEmpleado . $telefono . " Satisfactoriamente";
                echo "<meta http-equiv='refresh' content='0; url=#empleados'>";
            }

            if (isset($_POST["Cedula"]) && isset($_POST["Usuario"]) && isset($_POST["Clave"]) && isset($_POST["TipoUsuario"])) {
                $ID = $_POST["Cedula"];
                $Usuario = mysqli_real_escape_string($datosConexion, $_POST["Usuario"]);
                $Clave = mysqli_real_escape_string($datosConexion, $_POST["Clave"]);
                $tipoUsuario = mysqli_real_escape_string($datosConexion, $_POST["TipoUsuario"]);


                $insertarUsuariosSQL = "INSERT INTO Usuarios (IDUsuarios, NombreUsuario, Clave, TipoUsuario, idEmpleados) VALUES ($ID, '$Usuario', '$Clave', '$tipoUsuario', $ID)";

                mysqli_query($datosConexion, $insertarUsuariosSQL);
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
                            <th>Telefono</th>
                            <th>Username</th>
                            <th>Contraseña</th>
                            <th>Tipo </th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $leerUsuariosSQL = "SELECT 
                        Empleados.*, 
                        Usuarios.*
                    FROM 
                        Empleados
                    INNER JOIN 
                        Usuarios 
                    ON 
                        Empleados.IDEmpleado =  Usuarios.idEmpleados
                    ORDER BY 
                        Empleados.IDEmpleado";


                        $query = mysqli_query($datosConexion, $leerUsuariosSQL);



                        while ($row = mysqli_fetch_array($query)): ?>


                            <tr>
                                <th><?= $row["IDUsuarios"] ?></th>
                                <th><?= $row["NombreEmpleado"] ?></th>
                                <th><?= $row["ApellidoEmpleado"] ?></th>
                                <th><?= $row["Telefono"] ?></th>
                                <th><?= $row["NombreUsuario"]; ?></th>
                                <th><?= $row["Clave"] ?></th>
                                <th><?= $row["TipoUsuario"] ?></th>


                                <th><a href="">Editar</a></th>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='id' value=<?= $row["IDUsuarios"] ?>>
                                        <button type='submit' name='delete'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            $sqlEliminar = "DELETE FROM Usuarios WHERE IDUsuarios = $id";
            $queryEliminar = mysqli_query($datosConexion, $sqlEliminar);
            echo "<meta http-equiv='refresh' content='0'>";

        } else {

        }


        ?>

        <div id="camiones" class="section">
            <h2>Camiones</h2>
            <p>Contenido de Camiones.</p>
            <form action="panelAdmin.php" method="post">
                <input type="text" id="Placa" name="Placa" placeholder="Placa" required><br><br>
                <input type="text" id="Modelo" name="Modelo" placeholder="Modelo" required><br><br>
                <input type="text" id="Capacidad" name="Capacidad" placeholder="Capacidad" required><br><br>
                <input type="number" id="IDEmpleado" name="IDEmpleado" placeholder="IDEmpleado" required><br><br>
                <input type="submit" value="Agregar">
            </form>
            <?php

            if (isset($_POST["Placa"]) && isset($_POST["Modelo"]) && isset($_POST["Capacidad"]) && isset($_POST["IDEmpleado"])) {
                $Placa = mysqli_real_escape_string($datosConexion, $_POST["Placa"]);
                $Modelo = mysqli_real_escape_string($datosConexion, $_POST["Modelo"]);
                $Capacidad = mysqli_real_escape_string($datosConexion, $_POST["Capacidad"]);
                $IDEmpleado = mysqli_real_escape_string($datosConexion, $_POST["IDEmpleado"]);

                $insertarUsuariosSQL = "INSERT INTO Camiones (Placa, Modelo, Capacidad, IDEmpleado) VALUES ('$Placa', '$Modelo', '$Capacidad', $IDEmpleado)";
                mysqli_query($datosConexion, $insertarUsuariosSQL);
            }


            ?>

            <div>
                <h2>CAMIONES REGISTRADOS</h2>
                <table border="3">
                    <thead>
                        <tr>

                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Capacidad </th>
                            <th>IDEmpleado</th>
                            <th>Nombre Empleado</th>
                            <th>Apellido Empleado</th>
                            <th>Telefono</th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $leerCamionesSQL = "SELECT 
                            Empleados.*,
                            Camiones.*
                        FROM 
                            Empleados
                        INNER JOIN 
                            Camiones 
                        ON 
                            Empleados.IDEmpleado = Camiones.IDEmpleado
						ORDER BY 
							Empleados.IDEmpleado";


                        $queryCamiones = mysqli_query($datosConexion, $leerCamionesSQL);


                        while ($rowCamiones = mysqli_fetch_array($queryCamiones)): ?>

                            <tr>

                                <th><?= $rowCamiones["Placa"] ?></th>
                                <th><?= $rowCamiones["Modelo"] ?></th>
                                <th><?= $rowCamiones["Capacidad"] ?></th>
                                <th><?= $rowCamiones["IDEmpleado"] ?></th>
                                <th><?= $rowCamiones["NombreEmpleado"] ?> </th>
                                <th><?= $rowCamiones["ApellidoEmpleado"] ?></th>
                                <th><?= $rowCamiones["Telefono"] ?></th>


                                <th><a href="">Editar</a></th>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='Placa' value=<?= $rowCamiones["Placa"] ?>>
                                        <button type='submit' name='deleteCamiones'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php

            if (isset($_POST['deleteCamiones'])) {
                $Placa = $_POST['Placa'];

                $sqlEliminar = "DELETE FROM Camiones WHERE Placa = $Placa";
                $queryEliminar = mysqli_query($datosConexion, $sqlEliminar);
                echo "<meta http-equiv='refresh' content='0'>";

            } else {

            }


            ?>


        </div>
        <div id="rutas" class="section">
            <h2>Rutas</h2>
            <p>Contenido de Rutas.</p>
            <form action="panelAdmin.php" method="post">
                <input type="text" id="RutaID" name="RutaID" placeholder="Identificador de Ruta" required><br><br>
                <input type="text" id="Origen" name="Origen" placeholder="Origen" required><br><br>
                <input type="text" id="Destino" name="Destino" placeholder="Destino" required><br><br>
                <input type="number" id="DistanciaKM" name="DistanciaKM" placeholder="DistanciaKM" required><br><br>
                <input type="submit" value="Agregar">
            </form>

            <table border="3">
                    <thead>
                        <tr>

                            <th>RUTA ID</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Distancia (KM)</th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $leerRutasSQL = "SELECT 
                        Camiones.*, 
                        Empleados.*,
                        Rutas.*
                        FROM Camiones
                        JOIN Rutas ON Camiones.Placa = Rutas.PlacaCamiones
                        JOIN Empleados ON Camiones.IDEmpleado = Empleados.IDEmpleado;";


                        $queryRutas = mysqli_query($datosConexion, $leerRutasSQL);


                        while ($rowRutas = mysqli_fetch_array($queryRutas)): ?>

                            <tr>

                                <th><?= $rowRutas["Placa"] ?></th>
                                <th><?= $rowRutas["Modelo"] ?></th>
                                <th><?= $rowRutas["Capacidad"] ?></th>
                                <th><?= $rowRutas["IDEmpleado"] ?></th>
                                <th><?= $rowRutas["NombreEmpleado"] ?> </th>
                                <th><?= $rowRutas["ApellidoEmpleado"] ?></th>
                                <th><?= $rowRutas["Telefono"] ?></th>


                                <th><a href="">Editar</a></th>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='Placa' value=<?= $rowRutas["Placa"] ?>>
                                        <button type='submit' name='deleteCamiones'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>



             <div id=generarOrden  class="section">
                <h2>GENERAR ORDEN:</h2>
                <p>Pasos para generar ordenes:</p>
             
            </div>
        </div>

        
    </div>


</body>

</html>