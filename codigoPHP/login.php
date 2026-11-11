<?php
/*
 * @author: Álvaro Calderón Pérez
 * @since: 11/11/2026
 * Página login.php.
 */

    // Comprobamos que el botón login ha sido pulsado.
    if(isset($_REQUEST['cancelar'])){
        // En caso de que haya sido pulsado nos dirigimos a la página del formulario de login.
        header("location: ../indexProyectoLoginLogoffTema5.php");
        exit;
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
            <h2>UT5: Proyecto Login/Logoff Tema 5</h2>
            <h2>Login</h2>
        </nav>
        <main>
            <form action="" method="post">
            <button type="submit" name="cancelar" id="cancelar">Cancelar</button>
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

