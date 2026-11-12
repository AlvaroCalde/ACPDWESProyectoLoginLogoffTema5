<?php
/*
 * @author: Álvaro Calderón Pérez
 * @since: 11/11/2026
 * Página inicioPrivado.php.
 */

    // Comprobamos que el botón login ha sido pulsado.
    if(isset($_REQUEST['cerrar'])){
        // En caso de que haya sido pulsado nos dirigimos a la página del formulario de login.
        header("location: ../indexProyectoLoginLogoffTema5.php");
        exit;
    }
    
    if(isset($_REQUEST['detalles'])){
        // En caso de que haya sido pulsado nos dirigimos a la página del formulario de login.
        header("location: ./detalles.php");
        exit;
    }
?>
<!doctype html>
<html lang="es">
    <head>
        <title>Inicio Privado</title>
        <link rel="stylesheet" href="../webroot/css/estilosPriv.css">
        
    </head>
    <body>
        <nav>
            <h2>UT5: Proyecto Login/Logoff Tema 5</h2>
            <h2>Inicio Privado</h2>
        </nav>
        <main>
            <h1>Bienvenido al Acceso privado</h1>
            <form action="/ACPDWESProyectoLoginLogoffTema5/codigoPHP/inicioPrivado.php" method="post">
              <input type="submit" name="cerrar" id="cerrar" value="Cerrar Sesion"/>
            <input type="submit" name="detalles" id="detalles" value="Detalles"/>  
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

