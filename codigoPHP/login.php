<?php
// comprueba si el boton cancelar fue pulsado

session_start();

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
    'contrasena' => ""];
//Array donde recogemos la respuestas correctas
$aRespuesta = [
    'usuario' => "",
    'contrasena' => ""];

// Comprueba si el boton login fue pulsado
if (isset($_REQUEST["login"])) {
    // Validar Entrada
    $aError["usuario"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["usuario"],1000,1,1);
    // utilizar para la creacion de la contrasena, no la validacion
    //$aError["contrasena"] = validacionFormularios::validarPassword($passwd, $maximo, $minimo, $tipo, $obligatorio);
    $aError["contrasena"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["contrasena"],1000,1,1);
    
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
    try{
                
        $miDB = new PDO(DSN, USERNAME, PASSWORD);

        $sqlSelect = <<<sql
        SELECT * FROM T01_Usuario
        WHERE T01_CodUsuario = :codUsuario and T01_Password = SHA2(:password,256)
        sql;
        $selectUsuarioContrasena = $miDB->prepare($sqlSelect);
        // trim elimina espacios antes y despues del texto
        $selectUsuarioContrasena->execute([
            ':codUsuario' => trim($_REQUEST["usuario"]),
            ':password' => trim($_REQUEST["usuario"]).trim($_REQUEST["contrasena"])
        ]);

        if($selectUsuarioContrasena->rowCount()==1){
            $_SESSION['usuarioLogueado'] = trim($_REQUEST["usuario"]);
            header("Location: ./inicioPrivado.php");
            exit;
        }else{
            $usuarioEncontrado=false;
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
                
                <label for="usuario" >Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo !empty($_REQUEST["usuario"]) ? htmlspecialchars($_REQUEST["usuario"]): '' ?>"/>
                <?php echo !empty($aError["usuario"]) ? "<span style='color:red;'>" . $aError['usuario'] . "</span>": '' ?>
                <br/><br/>
                
                <label for="contrasena" >Contrasena:</label>
                <input type="password" name="contrasena" id="contrasena" value="<?php echo !empty($_REQUEST["contrasena"]) ? htmlspecialchars($_REQUEST["contrasena"]): '' ?>"/>
                <?php echo !empty($aError["contrasena"]) ? "<span style='color:red;'>" . $aError['contrasena'] . "</span>": '' ?>
                <br/>
                <input type="submit" name="login" id="login" value="Log in"/>
                <input type="submit" name="cancelar" id="cancelar" value="Cancelar"/>
                
                
                <?php echo !$usuarioEncontrado ? "<span style='color:red;'>Usuario no encontrado, nombre de usuario o contrasena incorrecta</span>": '' ?>
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
