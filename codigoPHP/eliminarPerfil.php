<?php

require_once '../config/configDBPDO.php';
//reanuda la sesion
session_start();

// Si el usuario no ha iniciado la sesion, lo redirigimos al login
if (!isset($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'])) {
    header("location: ./login.php");
    exit;
}

// comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['cancelar'])) {
    // encaso de que si, vuelve al indice
    header("location: ./editarPerfil.php");
    exit;
}

// Comprueba si el boton eliminar fue pulsado
if (isset($_REQUEST["eliminar"])) {
    
    // elimina el usuario de la bases de datos
    try {
        $miDB = new PDO(DSN, USERNAME, PASSWORD);

        $sqlSelect = <<<sql
        delete FROM T01_Usuario
        WHERE T01_CodUsuario = :codUsuario
        sql;
        $selectUsuario = $miDB->prepare($sqlSelect);
        $selectUsuario->execute([
            ':codUsuario' => $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_CodUsuario']
        ]);

    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
        unset($miDB);
    }
    finally {
        unset($miDB);
    }
    //destruye la sesion y redirige el usuario al inicio publico
    session_destroy();
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit;
}


// Mostrar Login
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Tema 5 · Login Logoff · Álvaro Calderón Pérez </title>
        <link rel="stylesheet" href="../webroot/css/estilosEli.css">

    </head>
    <body>
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Editar usuario</h2>
        </nav>

        <main>
            <div class="container">

                <h3>Confirmación </h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
                    <h4>
                        Estas seguro que quieres eliminar la cuenta 
                        <span><?php echo $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_CodUsuario'].' (' .$_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']['T01_DescUsuario'].') ';?></span>
                        permanentemente?
                    </h4>
                    <br/>
                    <input type="submit" name="cancelar" id="cancelar" value="Cancelar"/>
                    <input type="submit" name="eliminar" id="eliminar" value="Eliminar"/>
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

