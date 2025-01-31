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

// Función para listar los equipos dinámicamente
function listarEquipos($directorio) {
    $archivos = array_diff(scandir($directorio), array('..', '.'));
    $equipos = [];

    foreach ($archivos as $archivo) {
        if (pathinfo($archivo, PATHINFO_EXTENSION) === 'json') {
            $equipos[] = [
                'nombre' => pathinfo($archivo, PATHINFO_FILENAME),
                'ruta' => $directorio . '/' . $archivo
            ];
        }
    }

    return $equipos;
}

// Obtener lista de equipos
$equipos = listarEquipos('data');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <header>
        <div class="container">
            <?php echo "<h1>".$lang['title']."</h1>"; ?>
            <nav>
                <ul class="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="#equipos">Equipos</a></li>
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
            <h2 id="equipos">Equipos</h2>
            <ul class="teams">
                <?php foreach ($equipos as $equipo): ?>
                    <li>
                        <a href="equipo.php?file=<?= urlencode($equipo['ruta']) ?>">
                            <?= htmlspecialchars($equipo['nombre']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Fantasy Football</p>
    </footer>

</body>
</html>
