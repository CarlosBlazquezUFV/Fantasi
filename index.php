<?php
// Iniciar sesión
session_start();

$idiomas = array(
    'es' => 'Español',
    'en' => 'English',
);

// Verificar si hay un idioma en la URL y establecerlo en la sesión
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Si no hay idioma en la sesión, poner un idioma por defecto (por ejemplo, español)
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es'; // Idioma por defecto
}

// Cargar los archivos de idioma
$lang = $_SESSION['lang'];
include("lang/$lang.php"); // Incluir el archivo de traducción correspondiente
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="container">
            <?php echo "<h1>".$lang['title']."</h1>"; ?>
            <nav>
                <ul class="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="equipos.php">Equipos</a></li>
                    <li><a href="jugadores.php">Jugadores</a></li>
                    <li><a href="estadisticas.php">Estadísticas</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                </ul>
            </nav>
            <div class="language-selector">
                <?php
                echo "<p>".$lang['lenguage']."</p>";
                foreach ($idiomas as $codigo => $nombre) {
                    $class = ($codigo === $lang) ? 'class="selected"' : 'class="unselected"';
                    echo "<a href='?lang=$codigo' $class>$nombre</a> ";
                }
                ?>
            </div>
        </div>
    </header>

    <main>
        <section class="content">
            <p>Bienvenido a la Liga Fantasy. Selecciona un equipo para ver sus jugadores y estadísticas.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Fantasy Football</p>
    </footer>

</body>
</html>
