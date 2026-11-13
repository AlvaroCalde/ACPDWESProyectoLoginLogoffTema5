<?php
session_start();

// comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['cancelar'])) {
    // encaso de que si, vuelve al indice
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit;
}
require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

//Inicializacion de variables
$entradaOK = true; // Variable que nos indica que todo va bien
$usuarioEncontrado = true; //Variable que nos indica si el usuario del login existe

//Array donde recogemos los mensajes de error
$aError = [
    'usuario' => "",
    'contrasena' => ""
];

// Comprueba si el boton login fue pulsado
if (isset($_REQUEST["login"])) {
    // Validar Entrada
    $aError["usuario"] = validacionFormularios::comprobarAlfabetico($_REQUEST["usuario"], 1000, 1, 1);
    
    // CORRECCIÓN 1: Cambiamos validarPassword por comprobarAlfaNumerico para evitar que rechace contraseñas simples.
    $aError["contrasena"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["contrasena"], 1000, 1, 1);
    
    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }
}
// El formulario no se ha enviado nunca
else {
    $entradaOK = false;
}

// si los datos estan bien,
// comprueba si el usuario existe en la base de datos
if ($entradaOK) {
    try {
        $miDB = new PDO(DSN, USERNAME, PASSWORD);

        $sqlSelect = "SELECT * FROM T01_Usuario 
                      WHERE T01_CodUsuario = :codUsuario 
                      AND T01_Password = SHA2(CONCAT(:codUsuario, :password), 256)";
        
        $selectUsuarioContrasena = $miDB->prepare($sqlSelect);
        
        // trim elimina espacios antes y despues del texto
        $selectUsuarioContrasena->execute([
            ':codUsuario' => trim($_REQUEST["usuario"]),
            ':password' => trim($_REQUEST["contrasena"])
        ]);

        // 1. Extraemos el objeto usuario ANTES de hacer el UPDATE
        $oUsuario = $selectUsuarioContrasena->fetchObject();

        // 2. Comprobamos si el usuario existe y la contraseña es correcta
        if (!$oUsuario) {
            $usuarioEncontrado = false;
        } else {
            // 3. Guardar los datos ANTES de hacer el UPDATE (la sesión ya se inició arriba)
            $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'] = $oUsuario->T01_CodUsuario;
            $_SESSION['descUsuario'] = $oUsuario->T01_DescUsuario;
            $_SESSION['numConexiones'] = $oUsuario->T01_NumConexiones + 1;
            $_SESSION['fechaHoraUltimaConexionAnterior'] = $oUsuario->T01_FechaHoraUltimaConexion;

            // 4. Actualizamos el numero de conexiones del usuario
            $actualizarUsuario = $miDB->prepare(
                "UPDATE T01_Usuario 
                 SET T01_NumConexiones = T01_NumConexiones + 1, 
                     T01_FechaHoraUltimaConexion = NOW() 
                 WHERE T01_CodUsuario = :usuarioUpdate"
            );
            

            $actualizarUsuario->execute([':usuarioUpdate' => $oUsuario->T01_CodUsuario]);
            
            session_write_close();
            
            // 5. Redirigimos a la página privada
            header("Location: ./inicioPrivado.php");
            exit;           
        }

    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
    } finally {
        unset($miDB);
    }
} 
// Mostrar Login
?>
<!doctype html>
<html lang="es">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../webroot/css/estilosLog.css">
    </head>
    <body>
        <nav>
            <h2>UT5: Proyecto Login/Logoff Tema 5</h2>
            <h2>Login</h2>
        </nav>
        <main>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
                
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