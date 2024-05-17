<?php
session_start();

$nombre =$_POST['Nombre'];
$apellido =$_POST['Apellido'];
$username =$_POST['Username'];
$contraseña =$_POST['Contraseña'];
$tipoUsuario =$_POST['TipoUsuario'];
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
                <li><a href="#productos">Productos</a></li>
                <li><a href="#proveedores">Proveedores</a></li>
            </ul>
        </div>
        <div class="content">
        <div id="empleados" class="section">
            <h2>Empleados</h2>
            <p>Contenido de Empleados.</p>
            <form action="panelAdmin.php" method="post">
                <input type="text" id="nombre" name="Nombre" placeholder="Nombre" require><br><br>
                <input type="text" id="Apellido" name="Apellido" placeholder="Apellido" require><br><br>
                <input type="text" id="Username" name="Username" placeholder="Username" require><br><br>
                <input type="text" id="contraseña" name="Contraseña" placeholder="Contraseña" require><br><br>
                <input type="text" id="TipoUsuario" name="TipoUsuario" placeholder="Administrador/Usuario" require><br><br>

                <input type="submit" value= "Agregar">
            </form>

            <div>
                <h2>Usuarios Registrados</h2>
                <table >
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
                        <!--<?php while($row = mysqli_fetch_array($query)):?> -->
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
                        <?php endwhile;?>
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


