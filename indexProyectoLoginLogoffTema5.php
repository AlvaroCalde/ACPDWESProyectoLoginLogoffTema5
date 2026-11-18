<?php
/*
- @author: Álvaro Calderón Pérez
- @since: 11/11/2026
- Página inicial del proyecto login/logoff.
 */
    session_start();
    
    $sesionIniciada = isset($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']);
    
    $textoBtnLogin = 'Iniciar Sesión';
    // comprobamos que existe la sesion para este usuario para cambiar el texto del boton de iniciar sesión

    if (isset($_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"])) {
        // CAMBIO A ARRAY: ['T01_DescUsuario']
        $textoBtnLogin = 'Hola '.$_SESSION["usuarioACPDWESProyectoLoginLogoffTema5"]['T01_DescUsuario'];
        
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
    
    if (isset($_REQUEST['registro'])) {
        header("location: ./codigoPHP/registro.php");
        exit;
    }
    
    // comprueba si existe una cookie de idioma y si no existe la crea en español
    if (!isset($_COOKIE['idioma'])) {
        setcookie("idioma", "ES", time()+604800); // caducidad 1 semana
        header('Location: ./indexProyectoLoginLogoffTema5.php');
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
        <img src="./webroot/images/logo.png" alt="logo">
        <h2>Inicio público</h2>
    </nav>
    <main>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">           
            <button type="submit" name="login" id="login" value="login"><span><?php echo $textoBtnLogin; ?></span></button>
            <button type="submit" name="registro" id="registro" value="registro" <?php echo $sesionIniciada ? 'disabled' : ''; ?>>
                Registro
            </button>
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

