<?php
session_start();

if (!isset($_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"])) {
    header("location: ./login.php"); 
    exit;
}
?>
<!doctype html>
<html lang="es">
    <head>
        <title>Detalles</title>
        <link rel="stylesheet" href="../webroot/css/estilosDet.css">    
    </head>
    <body>
        <nav>
            <img src="../webroot/images/logo.png" alt="logo">
            <h2>Detalles</h2>
        </nav>
        <main>
            <div class="ejercicio">
                <div style="margin-bottom: 20px;">
                    <a href="inicioPrivado.php" style="padding: 10px; background-color: #333; color: white; text-decoration: none; border-radius: 5px;">Volver a Inicio Privado</a>
                </div>

                <?php
                    echo "<h3>Contenido de \$_SESSION:</h3>";
                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";

                    echo "<h3>Contenido de \$_COOKIE:</h3>";
                    echo "<pre>";
                    print_r($_COOKIE);
                    echo "</pre>";

                    echo "<h3>Contenido de \$_SERVER:</h3>";
                    echo "<pre>";
                    print_r($_SERVER);
                    echo "</pre>";

                    echo "<h3>Resto de variables globales:</h3>";
                    echo "<pre>";
                    $resto_globals = $GLOBALS;

                    unset($resto_globals['_SESSION']);
                    unset($resto_globals['_COOKIE']);
                    unset($resto_globals['_SERVER']);
                    unset($resto_globals['GLOBALS']); 

                    print_r($resto_globals);
                    echo "</pre>";
                    
                    echo "<br>";
                    echo "<br>";
                    
                    phpinfo(); 
                ?>
        </div>
        </main>
        <footer>
            <div>
                <a href="../indexProyectoLoginLogoffTema5.php" color="white">Álvaro Calderón Pérez</a>
                <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casa_blanca.png" alt="home"></a>
            </div>
        </footer>
    </body>
</html>

