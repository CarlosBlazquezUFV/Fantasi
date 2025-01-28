<?php
// Tu API Key
$apiKey = "f17wfyMKb9kM1MiJdD0O9I7CBTPVqVqK5mFSbbyaHFAD9ijaCoouuym2qGlz"; // Reemplaza TU_API_KEY por tu token real

// Endpoint para obtener las ligas
$url = "https://api.sportmonks.com/v3/football/leagues?api_token=$apiKey";

// Configurar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar errores en la solicitud cURL
if (curl_errno($ch)) {
    echo "Error en cURL: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Decodificar la respuesta JSON a un array asociativo
$data = json_decode($response, true);

// Incluir el archivo CSS
echo '<link rel="stylesheet" href="css/test.css">';

echo "<h1>Ligas Disponibles</h1>";

// Verificar si la respuesta es válida
if (isset($data['data'])) {
    // Contenedor principal
    echo "<div class='container'>";
    foreach ($data['data'] as $league) {
        echo "<div class='card'>";
        echo "<img src='{$league['image_path']}' alt='{$league['name']} logo'>";
        echo "<div class='card-content'>";
        echo "<h2>{$league['name']} ({$league['short_code']})</h2>";
        echo "<p>Último partido: " . date("d-m-Y H:i", strtotime($league['last_played_at'])) . "</p>";
        echo "<p>Tipo: {$league['type']} | Subtipo: {$league['sub_type']}</p>";
        echo "<p class='status " . ($league['active'] ? "active" : "inactive") . "'>";
        echo $league['active'] ? "Activa" : "Inactiva";
        echo "</p>";
        echo "</div>"; // Fin de .card-content
        echo "</div>"; // Fin de .card
    }
    echo "</div>"; // Fin de .container
} else {
    echo "<p>Error: No se pudieron obtener datos de las ligas.</p>";
}

// Cerrar cURL
curl_close($ch);
?>
