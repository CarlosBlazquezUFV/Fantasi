<?php
// Tu API Key
$apiKey = "f17wfyMKb9kM1MiJdD0O9I7CBTPVqVqK5mFSbbyaHFAD9ijaCoouuym2qGlz"; // Reemplaza TU_API_KEY por tu token real

// Endpoint para obtener las ligas
$url = "https://api.sportmonks.com/v3/football/standings?api_token=$apiKey";

// Configurar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar errores
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decodificar la respuesta JSON
    $data = json_decode($response, true);
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// Cerrar cURL
curl_close($ch);
?>
