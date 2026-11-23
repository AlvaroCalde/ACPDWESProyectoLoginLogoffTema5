<?php
/*
- @author: Álvaro Calderón Pérez
- @since: 11/11/2026
- Página inicial del proyecto login/logoff.
 */
    session_start();
    
    $sesionIniciada = isset($_SESSION['usuarioACPDWESProyectoLoginLogoffTema5']);
    

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
    
    // Idiomas que se pueden elegir con las banderas
    $aIdiomas = ['ES', 'EN', 'PT'];

    // Si el usuario pulsa una bandera, guardamos el idioma en la cookie durante una semana.
    if (isset($_REQUEST['lenguaje']) && in_array($_REQUEST['lenguaje'], $aIdiomas)) {
        // 60 segundos * 60 minutos * 24 horas * 7 dias = una semana en segundos
        setcookie('idioma', $_REQUEST['lenguaje'], time() + 60 * 60 * 24 * 7,'/');

        // Recargamos la pagina para que $_COOKIE ya tenga el idioma nuevo y se marque su bandera
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if (!isset($_COOKIE['idioma']) || !in_array($_COOKIE['idioma'], $aIdiomas)) {
        setcookie('idioma', 'ES', time() + 60 * 60 * 24 * 7, '/');
        $idiomaSeleccionado = 'ES';
    } else {
        $idiomaSeleccionado = $_COOKIE['idioma'];
    }

    // Idioma guardado en la cookie. Si no hay cookie, por defecto español
    $idiomaSeleccionado = (isset($_COOKIE['idioma']) && in_array($_COOKIE['idioma'], $aIdiomas)) ? $_COOKIE['idioma'] : 'ES';
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
        <!-- Selector de idioma: cada bandera es un boton submit con name="idioma" y su value.
             Al pulsarlo se envia el formulario con ese idioma y se guarda la cookie. -->
        <form class="lenguaje" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <button type="submit" name="lenguaje" value="ES" title="Español" class="bandera <?php echo ($idiomaSeleccionado == 'ES') ? 'bandera--activa' : ''; ?>">
                <img src="webroot/images/ES.png" alt="Español">
            </button>

            <button type="submit" name="lenguaje" value="EN" title="English" class="bandera <?php echo ($idiomaSeleccionado == 'EN') ? 'bandera--activa' : ''; ?>">
                <img src="webroot/images/UK.png" alt="English">
            </button>

            <button type="submit" name="lenguaje" value="PT" title="Português" class="bandera <?php echo ($idiomaSeleccionado == 'PT') ? 'bandera--activa' : ''; ?>">
                <img src="webroot/images/PT.webp" alt="Portugues">
            </button>
        </form>
    </nav>
    <main>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">           
            <button type="submit" name="login" id="login" value="login">Iniciar Sesión</button>
            <button type="submit" name="registro" id="registro" value="registro">Registro</button>
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

