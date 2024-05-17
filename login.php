<?php
//Inicia sesion con el mysql
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

//Comprobar que se hayan introducido credenciales:
    if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {

        $usuario = mysqli_real_escape_string($datosConexion, $_POST["usuario"]);
        $contrasena = mysqli_real_escape_string($datosConexion, $_POST["contrasena"]);

        $consultaSql = "SELECT * FROM Usuarios WHERE NombreUsuario = '$usuario' AND Clave = '$contrasena'";
        $resultadoSql = mysqli_query($datosConexion, $consultaSql);

        if($resultadoSql){
            $datosPorFila = mysqli_fetch_assoc($resultadoSql);
          
            //Verifica la contraseña
            if ($datosPorFila) {
                $_SESSION['usuario'] = $datosPorFila['NombreUsuario'];
                
             
                if($datosPorFila['TipoUsuario']=='Administrador'){
                   header("Location: panelAdmin.php");
                }
                else if ($datosPorFila['TipoUsuario'] =='Usuario'){
                    header("Location: panelEmpleado.php");
                }
            
                exit();
            
            } else {
                echo "Usuario o contraseña incorrectos";
            } 
        } else {
            echo "Error en la consulta de la base de datos";
        }
    }
     else {
        echo "Error no se han introducido credenciales";
    }



    mysqli_close($datosConexion);




?>