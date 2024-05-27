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
    #echo "Conectado a la base de datos de Transcosas <hr>";
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>PANEL ADMIN</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/StyleAdmin.css">
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

            <hr id="lineagruesa">

            <li id="agregar"><a href="#generarOrden">Generar Orden</a></li>

        </ul>
    </div>

    <div class="content">

        <div id="empleados" class="section">
            <form class="form-empleados" action="panelAdmin.php" method="post">
                <input type="number" id="cedula" name="Cedula" placeholder="Cedula" required>
                <input type="text" id="nombre" name="Nombre" placeholder="Nombre" minlength="3" maxlength="40" required>
                <input type="text" id="Apellido" name="Apellido" placeholder="Apellido" minlength="3" maxlength="40"
                    required><br><br>
                <input type="text" id="Usuario" name="Usuario" placeholder="Usuario" minlength="3" maxlength="40"
                    required><br><br>
                <input type="text" id="Clave" name="Clave" placeholder="Clave" minlength="3" maxlength="40"
                    required><br><br>
                <input type="text" id="Telefono" name="Telefono" placeholder="Telefono" minlength="10" maxlength="10"
                    required><br><br>
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
                <hr>
                <h2>Usuarios Registrados</h2>
                <table class="styled-table">
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
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='id' value=<?= $row["IDUsuarios"] ?>>
                                    <button type='submit' name='editar'>Editar</button>

                                </form>
                            </td>
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

        if (isset($_POST['editar'])) {
            $id = $_POST['id'];
            $sql = "SELECT * FROM Usuarios WHERE IDUsuarios = $id";
            $query = mysqli_query($datosConexion, $sql);
            $row = mysqli_fetch_array($query);

            $idEmpleado = $row['idEmpleados'];
            $sqlEmpleado = "SELECT * FROM Empleados WHERE IDEmpleado = $idEmpleado";
            $queryEmpleado = mysqli_query($datosConexion, $sqlEmpleado);
            $rowEmpleado = mysqli_fetch_array($queryEmpleado);

            echo "<div id='editarFormulario'>
                    <h2>Editar Usuario</h2>
                    <form action='panelAdmin.php' method='post'>
                        <input type='hidden' name='id' value='{$row['IDUsuarios']}'>
                        <input type='text' name='Nombre' value='{$rowEmpleado['NombreEmpleado']}' required><br><br>
                        <input type='text' name='Apellido' value='{$rowEmpleado['ApellidoEmpleado']}' required><br><br>
                        <input type='number' name='Telefono' value='{$rowEmpleado['Telefono']}' required><br><br>
                        <input type='text' name='Usuario' value='{$row['NombreUsuario']}' required><br><br>
                        <input type='text' name='Clave' value='{$row['Clave']}' required><br><br>
                        <input type='text' name='TipoUsuario' value='{$row['TipoUsuario']}' required><br><br>
                        <input type='submit' name='update' value='Actualizar'>
                    </form>
                </div>";
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $nombre = mysqli_real_escape_string($datosConexion, $_POST['Nombre']);
            $apellido = mysqli_real_escape_string($datosConexion, $_POST['Apellido']);
            $telefono = mysqli_real_escape_string($datosConexion, $_POST['Telefono']);
            $usuario = mysqli_real_escape_string($datosConexion, $_POST['Usuario']);
            $clave = mysqli_real_escape_string($datosConexion, $_POST['Clave']);
            $tipoUsuario = mysqli_real_escape_string($datosConexion, $_POST['TipoUsuario']);

            $sqlUpdateEmpleado = "UPDATE Empleados SET NombreEmpleado='$nombre', ApellidoEmpleado='$apellido', Telefono='$telefono' WHERE IDEmpleado=(SELECT idEmpleados FROM Usuarios WHERE IDUsuarios=$id)";
            $sqlUpdateUsuario = "UPDATE Usuarios SET NombreUsuario='$usuario', Clave='$clave', TipoUsuario='$tipoUsuario' WHERE IDUsuarios=$id";

            mysqli_query($datosConexion, $sqlUpdateEmpleado);
            mysqli_query($datosConexion, $sqlUpdateUsuario);

            echo "<meta http-equiv='refresh' content='0'>";

        }


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
            <form class="form-empleados" action="panelAdmin.php" method="post">
                <input type="text" id="Placa" name="Placa" placeholder="Placa" required><br><br>
                <input type="text" id="Modelo" name="Modelo" placeholder="Modelo" required><br><br>
                <input type="text" id="Capacidad" name="Capacidad" placeholder="Capacidad" required><br><br>
                <input type="number" id="IDEmpleado" name="IDEmpleado" placeholder="Empleado a asignar (ID)"
                    required><br><br>
                <input type="submit" value="Agregar Nuevo Camion">
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
                <table class="styled-table">
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
                        <!--- MUESTRA LA TABLA DE CAMIONES CON INNER JOIN -->
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

                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='Placa' value=<?= $rowCamiones["Placa"] ?>>
                                    <button type='submit' name='editarCamiones'>Editar</button>


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

            <!--BOTON EDITAR-->

            <?php

        if (isset($_POST['editarCamiones'])) {
            $Placa = $_POST['Placa'];
            $sql = "SELECT * FROM Camiones WHERE Placa = '$Placa'";
            $query = mysqli_query($datosConexion, $sql);
            $rowCamionEditar = mysqli_fetch_array($query);

           
            echo "<div id='editarFormulario'>
                    <h2>Editar Camion</h2>
                    <form action='panelAdmin.php' method='post'>
                        <input type='text' name='Placa' disabled value='{$rowCamionEditar['Placa']} '>
                        <input type='text' name='Modelo' value='{$rowCamionEditar['Modelo']}' required><br><br>
                        <input type='text' name='Capacidad' value='{$rowCamionEditar['Capacidad']}' required><br><br>
                        <input type='number' name='IDEmpleado' value='{$rowCamionEditar['IDEmpleado']}' required><br><br>
                     
                        <input type='submit' name='updateCamiones' value='Actualizar'>
                    </form>
                </div>";
        }

        if (isset($_POST['updateCamiones'])) {
            $Placa = $_POST['Placa'];
            $Modelo = mysqli_real_escape_string($datosConexion, $_POST['Modelo']);
            $Capacidad = mysqli_real_escape_string($datosConexion, $_POST['Capacidad']);
            $IDEmpleado = mysqli_real_escape_string($datosConexion, $_POST['IDEmpleado']);
            

            $sqlUpdateCamion = "UPDATE Camiones SET Modelo='$Modelo', Capacidad='$Capacidad', IDEmpleado='$IDEmpleado' WHERE Placa='$Placa'";
            

            mysqli_query($datosConexion, $sqlUpdateCamion);
           

            echo "<meta http-equiv='refresh' content='0'>";

        }


        ?>


            <!---BOTON ELIMINAR EL -->
            <?php

            if (isset($_POST['deleteCamiones'])) {
                $Placa = $_POST['Placa'];

                $sqlEliminar = "DELETE FROM Camiones WHERE Placa = '$Placa'";
                $queryEliminar = mysqli_query($datosConexion, $sqlEliminar);
                echo "<meta http-equiv='refresh' content='0'>";

            } else {

            }


            ?>


        </div>
        <div id="rutas" class="section">
            <h2>Rutas</h2>
            <p>Contenido de Rutas.</p>
            <form class="form-empleados" action="panelAdmin.php" method="post">
                <input type="text" id="RutaID" name="RutaID" placeholder="Identificador de Ruta" required><br><br>
                <input type="text" id="Origen" name="Origen" placeholder="Origen" required><br><br>
                <input type="text" id="Destino" name="Destino" placeholder="Destino" required><br><br>
                <input type="number" id="DistanciaKM" name="DistanciaKM" placeholder="DistanciaKM" required><br><br>
                <input type="text" id="PlacaCamiones" name="PlacaCamiones" placeholder="CamionAsignado"
                    required><br><br>
                <input type="submit" value="Agregar Nueva Ruta">
            </form>

            <!--INSERTAR LAS RUTAS DEL FORMULARIO -->
            <?php
            if (isset($_POST["RutaID"]) && isset($_POST["Origen"]) && isset($_POST["Destino"]) && isset($_POST["DistanciaKM"]) && isset($_POST["PlacaCamiones"])) {
                $RutaID = mysqli_real_escape_string($datosConexion, $_POST["RutaID"]);
                $Origen = mysqli_real_escape_string($datosConexion, $_POST["Origen"]);
                $Destino = mysqli_real_escape_string($datosConexion, $_POST["Destino"]);
                $DistanciaKM = mysqli_real_escape_string($datosConexion, $_POST["DistanciaKM"]);
                $PlacaCamiones = mysqli_real_escape_string($datosConexion, $_POST["PlacaCamiones"]);

                $insertarUsuariosSQL = "INSERT INTO Rutas (RutaID, Origen, Destino, DistanciaKM, PlacaCamiones) VALUES ('$RutaID', '$Origen', '$Destino', $DistanciaKM, '$PlacaCamiones')";
                mysqli_query($datosConexion, $insertarUsuariosSQL);
            }
            ?>

            <table class="styled-table">
                <thead>
                    <tr>

                        <th>RUTA ID</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Distancia (KM)</th>
                        <th>Camion Asignado</th>
                        <th>Modelo Camion</th>
                        <th>ID Empleado</th>
                        <th>Nombre Empleado</th>
                        <th>Apellido Empleado</th>
                        <th></th>
                        <th></th>
                    </tr>

                </thead>
                <tbody>
                    <!---MUESTRA LAS RUTAS EN UNA TABLA -->
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

                        <th><?= $rowRutas["RutaID"] ?></th>
                        <th><?= $rowRutas["Origen"] ?></th>
                        <th><?= $rowRutas["Destino"] ?></th>
                        <th><?= $rowRutas["DistanciaKM"] ?></th>
                        <th><?= $rowRutas["PlacaCamiones"] ?> </th>
                        <th><?= $rowRutas["Modelo"] ?></th>
                        <th><?= $rowRutas["IDEmpleado"] ?></th>
                        <th><?= $rowRutas["NombreEmpleado"] ?></th>
                        <th><?= $rowRutas["ApellidoEmpleado"] ?></th>



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
        </div>



        <div id=generarOrden class="section">
            <h2>GENERAR ORDEN:</h2>
            <p>Pasos para generar ordenes:</p>
            <form method="post" action="panelAdmin.php">

                <label for="opcionCamiones"> SELECCIONA QUE CAMION :</label>
                <select name="opcionCamiones" id="opcionCamiones"><br>

                    <option value="">Camion:</option>
                    <?php
                    $listarCamionesSQL = "SELECT * FROM Camiones";
                    $queryLeerCamiones = mysqli_query($datosConexion, $listarCamionesSQL);

                    if ($queryLeerCamiones > 0) {
                        while ($listaCamiones = mysqli_fetch_array($queryLeerCamiones)) {
                            echo "<option value=''>" . $listaCamiones["Placa"] . " - " . $listaCamiones["Modelo"] . "</option>";
                        }
                    } else {
                        echo "no hay datos";
                    }
                    ?>

                </select>
                <br><br>
                <label for="opcionNombre"> SELECCIONA CONDUCTOR:</label>
                <select name="opcionNombre" id="desplegableNombres">
                    <option value="">Empleado:</option>
                    <?php
                    $listarUsuariosSQL = "SELECT * FROM Empleados";
                    $queryLeerUsuarios = mysqli_query($datosConexion, $listarUsuariosSQL);

                    if ($queryLeerUsuarios > 0) {
                        while ($listaEmpleados = mysqli_fetch_array($queryLeerUsuarios)) {
                            echo "<option value=''>" . $listaEmpleados["NombreEmpleado"] . " " . $listaEmpleados["ApellidoEmpleado"] . "</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>
                <label for="opcionRuta">SELECCIONA RUTA:</label>
                <select name="opcionRuta" id="opcionRuta">
                    <option value="">Ruta:</option>
                    <?php
                    $listarRutasSQL = "SELECT * FROM Rutas";
                    $queryLeerRutas = mysqli_query($datosConexion, $listarRutasSQL);

                    if ($queryLeerRutas > 0) {
                        while ($listaRutas = mysqli_fetch_array($queryLeerRutas)) {
                            echo "<option value=''>" . $listaRutas["Origen"] . " - " . $listaRutas["Destino"] . "</option>";
                        }

                    }

                    ?>




        </div>
    </div>


</body>

</html>