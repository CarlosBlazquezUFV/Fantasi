<?php
// Iniciar sesión
session_start();
include("view/vista.php");
$rutaArchivo="./data/";

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

$vista=new Vista();
$vista->mostrarEncabezado('style.css');
$vista->mostrarHeader($lang);
if (empty($_GET) && empty($_POST)||isset($_GET['inicio'])) {
    $vista->inicio();
}
//al seleccionar equipo muestra por pantalla los datos de cada jugador de dicho equipo
if (isset($_GET['equipo'])&&!empty($_GET['equipo'])) {
    $rutaEquipo= $rutaArchivo.$equipos[$_GET['equipo']];
    $vista->datosEquipo($rutaEquipo);
 }
$vista->mostrarFooter();

?>

