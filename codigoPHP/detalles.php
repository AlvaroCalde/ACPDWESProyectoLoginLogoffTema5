<?php
// 1. Iniciar la sesión
session_start();

// 2. Comprobar si el usuario está logueado. Si no, lo expulsamos al login.
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
            <h2>UT5: Proyecto Login/Logoff Tema 5</h2>
            <h2>Detalles</h2>
        </nav>
        <main>
            <div class="ejercicio">
                <!-- Botón opcional para volver atrás fácilmente -->
                <div style="margin-bottom: 20px;">
                    <a href="inicioPrivado.php" style="padding: 10px; background-color: #333; color: white; text-decoration: none; border-radius: 5px;">Volver a Inicio Privado</a>
                </div>

                <?php
                    /**
                     * @author Álvaro Calderón Pérez
                     * @since 12-11-2026
                     */

                    // 1. Mostrar $_SESSION
                    echo "<h3>Contenido de \$_SESSION:</h3>";
                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";

                    // 2. Mostrar $_COOKIE
                    echo "<h3>Contenido de \$_COOKIE:</h3>";
                    echo "<pre>";
                    print_r($_COOKIE);
                    echo "</pre>";

                    // 3. Mostrar $_SERVER
                    echo "<h3>Contenido de \$_SERVER:</h3>";
                    echo "<pre>";
                    print_r($_SERVER);
                    echo "</pre>";

                    // 4. Mostrar el resto de $GLOBALS
                    echo "<h3>Resto de variables globales:</h3>";
                    echo "<pre>";
                    // Hacemos una copia de $GLOBALS para no alterar el array original del sistema
                    $resto_globals = $GLOBALS;

                    // Eliminamos las variables que ya hemos mostrado
                    unset($resto_globals['_SESSION']);
                    unset($resto_globals['_COOKIE']);
                    unset($resto_globals['_SERVER']);
                    // También puedes ocultar $_GLOBALS para que no haga una recursión infinita visualmente
                    unset($resto_globals['GLOBALS']); 

                    // Imprimimos lo que queda
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
                <a href="../indexProyectoLoginLogoffTema5.php" color="white">
               Álvaro Calderón Pérez
                </a>
                <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casa_blanca.png" alt="home"></a>
            </div>
        </footer>
    </body>
</html>

