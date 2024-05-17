<?php
//Inicia sesion con el mysql
session_start();
    $ubicacionDB = "localhost:3307";
    $usuarioDB = "root";
    $claveDB = "1234";
    $nombreDB = "Transcosas";

    //Crea la conexion a la BD MySQL dentro de DOcker
    $datosConexion = mysqli_connect($ubicacionDB,$usuarioDB, $claveDB, $nombreDB);

    //Compureba que si se haya conectado 
    if (!$datosConexion){
        die("Conexion a la BD fallida: ".mysqli_connect_error());
    }
    echo "Conectado a la base de datos de Transcosas";

    if (isset($_POST["usuario"] && $_POST["contrasena"])){

        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $tipoUsuario;

        $consultaSql = "SELECT * FROM Usuarios WHERE NombreUsuario = '$usuario' AND Clave = '$constrasena'";
        $resultadoSql = mysqli_query($datosConexion, $consultaSql);
        $datosporfila = mysqli_fecth_assoc($resultadoSql);

        if($datosporfila){
            $_SESSION["usuario"] = $datosporfila["NombreUsuario"];
            $_SESSION["constrasena"] = $datosporfila["Clave"];
      

            if ($resultadoSql = true){
              if ($tipoUsuario == 1){
                 header("location: panelAdmin.php");
              }else if($tipoUsuario == 2){
                
                header("location: panelEmpleado.php");
              }
            }       
        }else{
            echo "Usuario Incorrecto";
        }


    } else{
        echo "Error no se han introducido credenciales";
    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina de ingreso administrativo</title>
    <link rel="stylesheet" href="css/Style.css"> 
    
</head>
<body>
    <header>
      <nav>
        <ul class="MenuLista">
            <li><a href="index.html">INICIO</a></li>
            <li><a href="acercaDeNosotros.html">ACERCA DE NOSOTROS</a></li>
            <li><a href="servicios.html">SERVICIOS</a></li>
            <li><a href="rutas.html">RUTAS</a></li>
            <li class="posicionLogin">
                <div class="contenedorLogin">
                    <span class="MenuLogin">LOGIN</span>
                    <ul class="contenidoMenu   ">
                        <li><a class="admin" href="ingresoAdmin.html">ADMINISTRADOR</a></li><br>
                        <li><a class="admin" href="ingresoEmpleado.html">EMPLEADO</a></li>
                </div>

                </div>
            </li>
        </ul>
    </nav>      
      </header>

    <CENTER><img src ="imagenesTranscosas/otrocamion.jpg" alt="imagen" title="etiqueta de la imagen" width="600" height="200" /></CENTER>
     
    <CENTER><h1>Bienvenido transportes CO S.A.S</h1></CENTER>
    <CENTER><h3>ingreso administrativo</h3></CENTER>
    <CENTER><h4>ingreso por correo electronico</h4></CENTER>
    

    <CENTER><form action="login.php" method="post">

  <p><div>
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario">
  </div></p>
  <p><div>
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena">
  </div></p>
<p><div>
    <input type="submit" value="Ingresar a plataforma web">
  </div>
</form></CENTER></p>



    
</body>
</html>