<?php
/*
 * @author: Álvaro Calderón Pérez
 * @since: 18/11/2026
 * Página inicioPrivado.php.
 */
    session_start();
    
    if (!isset($_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"])) {
        header("location: ./login.php"); 
        exit;
    }
    
    if(isset($_REQUEST['inicio'])){
        header("location: ../indexProyectoLoginLogoffTema5.php");
        exit;
    }

    // Comprobamos que el botón login ha sido pulsado.
    if(isset($_REQUEST['cerrar'])){
        session_unset();
        session_destroy();
        // En caso de que haya sido pulsado nos dirigimos a la página publica.
        header("location: ../indexProyectoLoginLogoffTema5.php");
        exit;
    }
    
    if(isset($_REQUEST['detalles'])){
        header("location: ./detalles.php");
        exit;
    }
    
    if(isset($_REQUEST['editar'])){
        header("location: ./editarPerfil.php");
        exit;
    }

    $usuario = $_SESSION['usuarioACPDWESProyectoLoginLogoffTema5'];
    
    $descUsuario = $usuario->T01_DescUsuario;
    $numConexiones = $usuario->T01_NumConexiones;

    $fechaUltimaConexion = null;
    if (!empty($usuario->T01_FechaHoraUltimaConexion)) {
        $oFechaUltimaConexion = new DateTime($usuario->T01_FechaHoraUltimaConexion);
        $fechaUltimaConexion = $oFechaUltimaConexion->format('d/m/Y H:i:s');
    }
?>
<!doctype html>
<html lang="es">
    <head>
        
        <link rel="stylesheet" href="../webroot/css/estilosPriv.css">
        
    </head>
    <body>
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Inicio Privado</h2>
        </nav>
        <main>
            
            <h1>Bienvenido al Acceso privado, <?php echo htmlspecialchars($descUsuario); ?></h1>
            
            <?php
            if ($numConexiones == 1) {
                echo "<p style='font-size: 1.2em;'>Esta es la primera vez que te conectas.</p>";
            } else {
                echo "<p style='font-size: 1.2em;'>Esta es la <strong>" . $numConexiones . "ª</strong> vez que te conectas.</p>";
                echo "<p>Tu última conexión anterior fue el <strong>" . $fechaUltimaConexion . "</strong>.</p>";
            }
            ?>
            <br>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="submit" name="detalles" id="detalles" value="Detalles"/>  
                <input type="submit" name="editar" id="editar" value="Editar perfil"/>
                <input type="submit" name="inicio" id="inicio" value="Salir"/>
                <input type="submit" name="cerrar" id="cerrar" value="Cerrar Sesion"/>
                
                
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

