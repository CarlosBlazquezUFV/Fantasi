<?php
// Model/models.php

class Models {
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todos los jugadores (por ejemplo)
    public function obtenerJugadores() {
        // Consulta SQL
        $query = "SELECT * FROM jugadores";

        // Ejecutar la consulta
        $result = $this->conn->query($query);

        // Si se obtienen resultados, se devuelven en formato de array asociativo
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Puedes agregar más métodos aquí, como agregarJugador(), actualizarJugador(), eliminarJugador(), etc.
}
?>
