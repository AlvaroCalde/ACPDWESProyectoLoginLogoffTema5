<?php
session_start();

// comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['cancelar'])) {
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit;
}
require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

$entradaOK = true; 
$usuarioEncontrado = true; 

$aError = [
    'usuario' => "",
    'contrasena' => ""
];

if (isset($_REQUEST["login"])) {
    $aError["usuario"] = validacionFormularios::comprobarAlfabetico($_REQUEST["usuario"], 1000, 1, 1);
    $aError["contrasena"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["contrasena"], 1000, 1, 1);
    
    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false;
}

if ($entradaOK) {
    try {
        $miDB = new PDO(DSN, USERNAME, PASSWORD);

        $sqlSelect = "SELECT * FROM T01_Usuario 
                      WHERE T01_CodUsuario = :codUsuario 
                      AND T01_Password = SHA2(CONCAT(:codUsuario, :password), 256)";
        
        $selectUsuarioContrasena = $miDB->prepare($sqlSelect);
        
        $selectUsuarioContrasena->execute([
            ':codUsuario' => trim($_REQUEST["usuario"]),
            ':password' => trim($_REQUEST["contrasena"])
        ]);

        $aUsuario = $selectUsuarioContrasena->fetch(PDO::FETCH_ASSOC);

        if (!$aUsuario) {
            $usuarioEncontrado = false;
        } else {
            $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'] = $aUsuario;

            $actualizarUsuario = $miDB->prepare(
                "UPDATE T01_Usuario 
                 SET T01_NumConexiones = T01_NumConexiones + 1, 
                     T01_FechaHoraUltimaConexion = NOW() 
                 WHERE T01_CodUsuario = :usuarioUpdate"
            );
            
            $actualizarUsuario->execute([':usuarioUpdate' => $aUsuario['T01_CodUsuario']]);
            
            session_write_close();
            
            header("Location: ./inicioPrivado.php");
            exit;           
        }

    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
    } finally {
        if (isset($miDB)) {
            unset($miDB);
        }
    }
} 
?>
<!doctype html>
<html lang="es">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../webroot/css/estilosLog.css">
    </head>
    <body>
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Login</h2>
        </nav>
        <main>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
                
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo !empty($_REQUEST["usuario"]) ? htmlspecialchars($_REQUEST["usuario"]): '' ?>"/>
                <?php echo !empty($aError["usuario"]) ? "<span style='color:red;'>" . $aError['usuario'] . "</span>": '' ?>
                <br/><br/>
                
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" value="<?php echo !empty($_REQUEST["contrasena"]) ? htmlspecialchars($_REQUEST["contrasena"]): '' ?>"/>
                <?php echo !empty($aError["contrasena"]) ? "<span style='color:red;'>" . $aError['contrasena'] . "</span>": '' ?>
                <br/>
                <input type="submit" name="login" id="login" value="Log in"/>
                <input type="submit" name="cancelar" id="cancelar" value="Cancelar"/>
                
                <?php echo !$usuarioEncontrado ? "<br><span style='color:red;'>Usuario no encontrado, nombre de usuario o contrasena incorrecta</span>": '' ?>
            </form> 
            
        </main>
        <footer>
            <div>
                <a href="../../ACPDWESProyectoDWES/indexProyectoDWES.php" color="white">Álvaro Calderón Pérez</a>
                <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casa_blanca.png" alt="home"></a>
            </div>
        </footer>
    </body>
</html>