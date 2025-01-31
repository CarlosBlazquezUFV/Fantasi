<?php
// Incluir los archivos necesarios
include_once __DIR__.'\Model\config.php';   // Archivo de conexión
include_once __DIR__.'\Model\model.php';    // Archivo del modelo

// Crear la instancia del modelo pasando la conexión
$model = new Models($db);

// Llamar a la función para obtener los jugadores
$jugadores = $model->obtenerJugadores();

// Mostrar los jugadores en pantalla
echo "<h1>Lista de Jugadores</h1>";
if (count($jugadores) > 0) {
    foreach ($jugadores as $jugador) {
        echo "<p>ID: " . $jugador['id'] . " - Nombre: " . $jugador['nombre'] . "</p>";
    }
} else {
    echo "<p>No hay jugadores registrados.</p>";
}
?>
