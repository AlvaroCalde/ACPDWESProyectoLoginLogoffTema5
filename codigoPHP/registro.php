<?php
if (isset($_REQUEST['cancelar'])) {
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit;
}
require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

$entradaOK = true; 
$aError = [
    'usuario' => "",
    'contrasena' => "",
    'descripcion' => ""
];

if (isset($_REQUEST["crearUsuario"])) {

    $aError["usuario"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["usuario"], 8, 4, 1);
    $aError["contrasena"] = validacionFormularios::validarPassword($_REQUEST["contrasena"], 32, 4, 2, 1);
    $aError["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 100, 1, 1);

    $aError["contrasena"] = $_REQUEST["contrasena"] === $_REQUEST["segundaContrasena"] ? $aError["contrasena"] : "Error al crear la cuenta, las contrasenas no son iguales";

    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }

    try {
        $miDB = new PDO(DSN, USERNAME, PASSWORD);

        $sqlSelect = <<<sql
        SELECT * FROM T01_Usuario
        WHERE T01_CodUsuario = :codUsuario
        sql;
        $selectUsuario = $miDB->prepare($sqlSelect);
        $selectUsuario->execute([
            ':codUsuario' => trim($_REQUEST["usuario"])
        ]);

        if ($selectUsuario->rowCount() != 0) {
            $entradaOK = false;
            $aError['usuario'] = "Error al crear la cuenta, ya existe un usuario con el mismo nombre";
        }
    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
        unset($miDB);
    }
} else {
    $entradaOK = false;
}

if ($entradaOK) {
    session_start();

    $insertarUsuario = $miDB->prepare(
        "INSERT INTO T01_Usuario VALUES (:usuario, SHA2(:contrasena, 256), :descripcion, 1, now(), 'usuario', null)"
    );
    $insertarUsuario->execute([
        ':usuario' => trim($_REQUEST["usuario"]),
        ':contrasena' => trim($_REQUEST["usuario"]) . trim($_REQUEST["contrasena"]),
        ':descripcion' => trim($_REQUEST["descripcion"])
    ]);

    $selectUsuario->execute([
        ':codUsuario' => trim($_REQUEST["usuario"])
    ]);

    $aUsuario = $selectUsuario->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'] = $aUsuario;

    unset($miDB);
    header("Location: ./inicioPrivado.php");
    exit;
}
if (isset($miDB)) {
    unset($miDB);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tema 5 · Login Logoff · Álvaro Calderón Pérez </title>
    <link rel="stylesheet" href="../webroot/css/estilosReg.css">

</head>

<body>
    <header>
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Inicio Privado</h2>
        </nav>

    </header>

    <main>
        <div class="container">

            <h3>Registrate </h3>
            <!-- Seguridad XSS añadida -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
                <table class="formularioUsuario">
                    <tr>
                        <td><label for="usuario">Usuario:</label></td>
                        <td><input type="text" name="usuario" id="usuario" value="<?php echo !empty($_REQUEST["usuario"]) && empty($aError["usuario"]) ? htmlspecialchars($_REQUEST["usuario"]) : '' ?>" /></td>
                        <?php echo !empty($aError["usuario"]) ? "<td><span style='color:red;'>" . $aError['usuario'] . "</span></td>" : '<td></td>' ?>
                    </tr>
                    <tr>
                        <td><label for="contrasena">Contraseña:</label></td>
                        <td><input type="password" name="contrasena" id="contrasena" value="<?php echo !empty($_REQUEST["contrasena"]) && empty($aError["contrasena"]) ? htmlspecialchars($_REQUEST["contrasena"]) : '' ?>" /></td>
                        <?php echo !empty($aError["contrasena"]) ? "<td><span style='color:red;'>" . $aError['contrasena'] . "</span></td>" : '' ?>
                    </tr>
                    <tr>
                        <td><label for="segundaContrasena">Vuelve a introducir la contraseña:</label></td>
                        <td><input type="password" name="segundaContrasena" id="segundaContrasena" value="<?php echo !empty($_REQUEST["segundaContrasena"]) && empty($aError["contrasena"]) ? htmlspecialchars($_REQUEST["segundaContrasena"]) : '' ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="contrasena">Descripcion:</label></td>
                        <td><input type="text" name="descripcion" id="descripcion" value="<?php echo !empty($_REQUEST["descripcion"]) ? htmlspecialchars($_REQUEST["descripcion"]) : '' ?>" /></td>
                        <?php echo !empty($aError["descripcion"]) ? "<td><span style='color:red;'>" . $aError['descripcion'] . "</span></td>" : '' ?>
                    </tr>
                </table>
                <br />
                <input type="submit" name="cancelar" id="cancelar" value="Cancelar" />
                <input type="submit" name="crearUsuario" id="crearUsuario" value="Crear Usuario" />
                <br />
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