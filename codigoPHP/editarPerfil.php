<?php

require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';
//reanuda la sesion
session_start();

// Si el usuario no ha iniciado la sesion, lo redirigimos al login
if (!isset($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'])) {
    header("Location: ./login.php");
    exit;
}
// comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['cancelar'])) {
    // encaso de que si, vuelve al indice
    header("Location: ./inicioPrivado.php");
    exit;
}

//Inicializacion de variables
//Array donde recogemos los mensajes de error
$aError = [
    'descripcion' => ""];

$sDescripcionMostrar = empty($_REQUEST["descripcion"]) ? $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']->T01_DescUsuario : $_REQUEST["descripcion"];    

// comprueba si el boton eliminar fue pulsado
if (isset($_REQUEST['eliminarCuenta'])) {
    //mover usuario a otra pantalla
    header("Location: ./eliminarPerfil.php");
    exit;
}

// comprueba si el boton eliminar fue pulsado
if (isset($_REQUEST['cambiarPassword'])) {
    //mover usuario a otra pantalla
    header("Location: ./cambiarPassword.php");
    exit;
}

// Comprueba si el boton aplicar cambios fue pulsado
if (isset($_REQUEST["aplicarCambios"])) {
    $entradaOK = true; // Variable que nos indica que todo va bien
    // Validacion de entrada Entrada
    $aError["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 100, 1,1);

    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }
    
    // si los datos estan bien,
    if ($entradaOK) {
        
        try {
            $miDB = new PDO(DSN, USER, PASS);

            $sqlUpdate = <<<sql
                UPDATE T01_Usuario 
                SET T01_DescUsuario = :descripcionNuevo
                WHERE T01_CodUsuario = :usuario
                sql;


            $actualizarUsuario = $miDB->prepare($sqlUpdate);
            $actualizarUsuario->execute([
                ':descripcionNuevo' => $_REQUEST["descripcion"],
                ':usuario' => $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']->T01_CodUsuario]);

            //ejecutamos un select del usuario para recoger sus datos y anadirlos a la sesion
            $sqlSelect = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";
            $selectUsuario = $miDB->prepare($sqlSelect);
            
            // (CAMBIADO A OBJETO)
            $selectUsuario->execute([
                ':codUsuario' => $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']->T01_CodUsuario
            ]);

            $oUsuario = $selectUsuario->fetchObject();
            
            // Guardamos en la sesion el objeto
            $_SESSION['usuarioJDPDWESLoginLogoffTema5'] = $oUsuario;
            
        } catch (PDOException $miExceptionPDO) {
            echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
            echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
            echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
            
        } finally {
            //cerramos la conexion
            if (isset($miDB)) {
                unset($miDB);
            }
        }

        //redirigimos al area privada
        header("Location: ./inicioPrivado.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Tema 5 · Login Logoff · Álvaro Calderón Pérez </title>
        <link rel="stylesheet" href="../webroot/css/estilosEdi.css">
    </head>
    <body>
        
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Editar usuario</h2>
        </nav>
        <main>
           
            <div class="container">
                <br>
                <h3>Datos del Usuario </h3>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
                    <table class="formularioUsuario">
                        <tr>
                            <td><label for="usuario" >Usuario:</label></td>
                            <td><input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']->T01_CodUsuario); ?>" readonly/></td>
                            <?php echo !empty($aError["usuario"]) ? "<td><span style='color:red;'>" . $aError['usuario'] . "</span></td>" : '<td></td>' ?>
                        </tr>
                        <tr>
                            <td><label for="descripcion" >Descripcion:</label></td>
                            <td><input type="text" name="descripcion" id="descripcion" value="<?php echo empty($aError["descripcion"]) ? htmlspecialchars($sDescripcionMostrar) : ''; ?>"/></td>
                            <?php echo !empty($aError["descripcion"]) ? "<td><span style='color:red;'>" . $aError['descripcion'] . "</span></td>" : '' ?>
                        </tr>
                    </table>
                    <br/>
                    <input type="submit" name="aplicarCambios" id="aplicarCambios" class="botonLargo" value="Aplicar Cambios"/>
                    <input type="submit" name="cancelar" id="cancelar" value="Cancelar"/>
                    <input type="submit" name="cambiarPassword" id="cambiarPassword" class="botonLargo" value="Cambiar Contraseña"/>
                    <input type="submit" name="eliminarCuenta" id="eliminarCuenta" class="botonLargo" value="Eliminar Cuenta"/>
                    
                    
                    <br/>
                </form> 
            </div>
        </main>

        <footer>
            <div>
                <a href="../../ACPDWESProyectoDWES/indexProyectoDWES.php" color="white">Álvaro Calderón Pérez</a>
                <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casa_blanca.png" alt="home"></a>
            </div>
        </footer>

    </body>
</html>

