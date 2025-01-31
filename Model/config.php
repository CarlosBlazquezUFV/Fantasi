<?php
// config.php

$servidor = "localhost";         // Dirección del servidor de base de datos
$usuario = "root";               // Usuario de la base de datos
$contraseña = "";                // Contraseña del usuario
$base_de_datos = "fantasy"; // Nombre de la base de datos

// Crear la conexión
$db = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

// Verificar si hubo un error en la conexión
if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}
?>
