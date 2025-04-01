<?php
// Iniciar sesión
session_start();
include("view/vista.php");
$rutaArchivo = "./data/";
$rutaImg="./image/";

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
//llamar al encabezado de la pagina
$vista = new Vista();
$vista->mostrarEncabezado('style.css');
$vista->mostrarHeader($lang);

//si es la primera vez
if (empty($_GET) && empty($_POST) || isset($_GET['inicio'])) {
    $vista->inicio($rutaImg);
}

//al seleccionar equipo muestra por pantalla los datos de cada jugador de dicho equipo
if (isset($_GET['equipo']) && !empty($_GET['equipo'])) {
    $rutaEquipo = $rutaArchivo . $equipos[$_GET['equipo']]["json"];
    $vista->datosEquipo($rutaEquipo);
}
//hay un equipo seleccionado, enseña los jugadores de dicho equipo
if (isset($_GET['equipos'])) {
    $vista->mostrarEquipos();
}

//al selecciona quienes somos muestra datos sobre nosotros
if (isset($_GET['WhoIAm'])) {

    $vista->quienesSomos();
}
if (isset($_GET['Proyect'])) {

    $vista->objetivoProyecto();
}
//genera el footer
$vista->mostrarFooter();
