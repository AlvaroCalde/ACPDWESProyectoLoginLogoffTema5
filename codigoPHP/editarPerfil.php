<?php
require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

session_start();

if (!isset($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'])) {
    header("Location: ./login.php");
    exit;
}

if (isset($_REQUEST['cancelar'])) {
    header("Location: ./inicioPrivado.php");
    exit;
}

$aError = ['descripcion' => ""];

// CAMBIO A ARRAY
$sDescripcionMostrar = empty($_REQUEST["descripcion"]) ? $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_DescUsuario'] : $_REQUEST["descripcion"];    

if (isset($_REQUEST['eliminarCuenta'])) {
    header("Location: ./eliminarPerfil.php");
    exit;
}

if (isset($_REQUEST["aplicarCambios"])) {
    $entradaOK = true; 
    
    $aError["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 100, 1,1);

    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }
    
    if ($entradaOK) {
        try {
            $miDB = new PDO(DSN, USERNAME, PASSWORD);

            $sqlUpdate = <<<sql
                UPDATE T01_Usuario 
                SET T01_DescUsuario = :descripcionNuevo
                WHERE T01_CodUsuario = :usuario
                sql;

            $actualizarUsuario = $miDB->prepare($sqlUpdate);
            
            $actualizarUsuario->execute([
                ':descripcionNuevo' => $_REQUEST["descripcion"],
                ':usuario' => $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_CodUsuario']
            ]);

            $sqlSelect = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";
            $selectUsuario = $miDB->prepare($sqlSelect);
            
            $selectUsuario->execute([
                ':codUsuario' => $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_CodUsuario']
            ]);

            $aUsuario = $selectUsuario->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'] = $aUsuario;
            
        } catch (PDOException $miExceptionPDO) {
            echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
            echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
            echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
            
        } finally {
            if (isset($miDB)) {
                unset($miDB);
            }
        }

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
                            <td><input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_CodUsuario']); ?>" readonly/></td>
                            <?php echo !empty($aError["usuario"]) ? "<td><span style='color:red;'>" . $aError['usuario'] . "</span></td>" : '<td></td>' ?>
                        </tr>
                        <tr>
                            <td><label for="descripcion" >Descripcion:</label></td>
                            <td><input type="text" name="descripcion" id="descripcion" value="<?php echo empty($aError["descripcion"]) ? htmlspecialchars($sDescripcionMostrar) : ''; ?>"/></td>
                            <?php echo !empty($aError["descripcion"]) ? "<td><span style='color:red;'>" . $aError['descripcion'] . "</span></td>" : '' ?>
                        </tr>
                    </table>
                    <br/>
                    <input type="submit" name="aplicarCambios" id="aplicarCambios" class="aplicarCambios" value="Aplicar Cambios"/>
                    <input type="submit" name="cambiarPassword" id="cambiarPassword" class="cambiarPassword" value="Cambiar Contraseña"/>
                    <br>
                    <input type="submit" name="cancelar" id="cancelar" value="Cancelar"/>              
                    <input type="submit" name="eliminarCuenta" id="eliminarCuenta" class="eliminarCuenta" value="Eliminar Cuenta"/>
                    <br/>
                </form> 
            </div>
        </main>

        <footer>
        <div>
            <a href="https://github.com/AlvaroCalde/ACPDWESProyectoLoginLogoffTema5" target="blank"><img src="../webroot/images/github.png" alt="enlace a github"></a>
            <a href="/">Álvaro Calderón Pérez</a>
        </div>
    </footer>

    </body>
</html>

