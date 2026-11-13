<?php
/*
 * @author: Álvaro Calderón Pérez
 * @since: 11/11/2026
 * Página inicial del proyecto login/logoff.
 */
    session_start();
    
    $textoBtnLogin = 'Iniciar Sesión';
    // comprobamos que existe la sesion para este usuario para cambiar el texto del boton de iniciar sesión
    if (isset($_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"])) {
        $textoBtnLogin = 'Hola '.$_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"]['CodUsuario'];
        if (isset($_REQUEST['login'])) {
            header('Location: ./codigoPHP/inicioPrivado.php');
            exit;
        }
    }

    // Comprobamos que el botón login ha sido pulsado.
    if(isset($_REQUEST['login'])){
        // En caso de que haya sido pulsado nos dirigimos a la página del formulario de login.
        header("location: ./codigoPHP/login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Indice general de la asignatura">
    <meta name="author" content="Álvaro Calderón Pérez">
    <title>Tema 5-Login/Logoff Álvaro Calderón Pérez</title>
    <link rel="stylesheet" href="./webroot/css/estilos.css">
</head>
<body>
    <nav>
        <h2>UT5: Proyecto Login/Logoff Tema 5</h2>
        <h2>Inicio público</h2>
    </nav>
    <main>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <button type="submit" name="login" id="login" value="login">Iniciar sesión</button>
        </form>
        <img src="./webroot/images/imagen_app.png" alt="Imagen">
    </main>
    <footer>
        <div>
            <a href="https://github.com/AlvaroCalde/ACPDWESProyectoLoginLogoffTema5" target="blank"><img src="/webroot/images/github.png" alt="enlace a github"></a>
            <a href="/">Álvaro Calderón Pérez</a>
        </div>
    </footer>
</body>
</html>

