<?php
/*
 * @author: Álvaro Calderón Pérez
 * @since: 11/11/2026
 * Página inicioPrivado.php.
 */
    session_start();
    
    if (!isset($_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"])) {
        header("location: ./login.php"); 
        exit;
    }

    // Comprobamos que el botón login ha sido pulsado.
    if(isset($_REQUEST['cerrar'])){
        // CORRECCIÓN 1: Un logoff real debe borrar y destruir la sesión antes de redirigir.
        session_unset();
        session_destroy();
        // En caso de que haya sido pulsado nos dirigimos a la página publica.
        header("location: ../indexProyectoLoginLogoffTema5.php");
        exit;
    }
    
    if(isset($_REQUEST['detalles'])){
        // En caso de que haya sido pulsado nos dirigimos a la página de detalles.
        header("location: ./detalles.php");
        exit;
    }

    // CORRECCIÓN 2: Recuperamos de la sesion los datos que guardamos en el login (como hace Moisés)
    $descUsuario = $_SESSION['descUsuario'];
    $numConexiones = $_SESSION['numConexiones'];

    // CORRECCIÓN 3: Formateamos la fecha de la ultima conexion anterior
    $fechaUltimaConexion = null;
    if (!empty($_SESSION['fechaHoraUltimaConexionAnterior'])) {
        $oFechaUltimaConexion = new DateTime($_SESSION['fechaHoraUltimaConexionAnterior']);
        $fechaUltimaConexion = $oFechaUltimaConexion->format('d/m/Y H:i:s');
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
            <!-- CORRECCIÓN 4: Se añade el "echo", se escapa el HTML por seguridad, y se usa la variable correcta -->
            <h1>Bienvenido al Acceso privado, <?php echo htmlspecialchars($descUsuario); ?></h1>
            
            <!-- CORRECCIÓN 5: Se añade la información de conexiones (Requisito del ejercicio DWES) -->
            <?php
            if ($numConexiones == 1) {
                echo "<p style='font-size: 1.2em;'>Esta es la primera vez que te conectas.</p>";
            } else {
                echo "<p style='font-size: 1.2em;'>Esta es la <strong>" . $numConexiones . "ª</strong> vez que te conectas.</p>";
                echo "<p>Tu última conexión anterior fue el <strong>" . $fechaUltimaConexion . "</strong>.</p>";
            }
            ?>
            <br>
            
            <!-- CORRECCIÓN 6: Se cambia la ruta absoluta por $_SERVER['PHP_SELF'] -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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

