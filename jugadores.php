<?php
// Iniciar sesión
session_start();
include("lang/Constant.php");
include("view/vista.php");

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
$vista= new Vista();
$vista->mostrarEncabezado("style.css");
$vista->mostrarHeader($lang,$idiomas,$equipos);
if (isset($_GET['equipo'])&&!empty($_GET['equipo'])) {
   $rutaEquipo= $rutaArchivo.$equipos[$_GET['equipo']];
   datosEquipo($rutaEquipo);
}
// Ruta al archivo JSON
//introduce lo nuevo aqui chat gpt, quiero un menu para desplegar todos los equipos de $equipos de las claves y que cuando se seleccione uno de ellos carge la ruta corresondiente que esta en
//$rutaArchivo = './data/FantasyGuru-db/data/'; y en $equipos en el valor por ejemplo  "ATM" => "2_ATM.json", y para acceder a la ruta seria $rutaArchivo.$equipos[ATM]
function datosEquipo($ruta){
    // Verificar si el archivo existe
    if (file_exists($ruta)) {

    // Leer el contenido del archivo
    $contenidoJson = file_get_contents($ruta);

    // Reemplazar todos los valores "NaN" por "0" en el JSON
    $contenidoJson = preg_replace('/\bNaN\b/', '0', $contenidoJson);

    // Decodificar el JSON a un array asociativo de PHP
    $data = json_decode($contenidoJson, true);
        // Verificar si el JSON es válido
        if (json_last_error() === JSON_ERROR_NONE) {
            // Recorrer el array y mostrar claves y valores
            MostrarJugadores($data);
        } else {
            echo "Error al decodificar el JSON: " . json_last_error_msg();
        }
    } else {
        echo "El archivo JSON no existe en la ruta especificada.";
    }
}
function recorrerArray($array) {
    foreach ($array as $clave => $valor) {
        echo "<li><strong>" . htmlspecialchars($clave) . ":</strong> ";

        // Verificar si el valor es un array
        if (is_array($valor)) {
            echo "<ul>";
            recorrerArray($valor); // Llamada recursiva para arrays anidados
            echo "</ul>";
        } else {
            echo htmlspecialchars($valor);
        }
        echo "</li>";
    }
}
function MostrarJugadores($array){
    // Contenedor extra para las tarjetas
    echo "<div class='jugadores-contenedor'>";
    
    foreach ($array as $clave => $valor) {
        echo "<div class='jugador-tarjeta'>";
        
        // Imagen del jugador (se añadirá más tarde)
        echo "<div class='jugador-imagen'>";
        echo "<img src='path_to_image_placeholder.jpg' alt='Imagen del jugador' class='imagen-jugador' />";
        echo "</div>";

        // Información del jugador
        echo "<div class='jugador-info'>";

        // Mostrar todos los detalles de cada jugador
        foreach($valor as $k=>$v) {
            echo "<p><strong>";
            
            switch ($k) {
                case 'status':
                    echo "Estado:</strong> ";
                    echo $v == 'ok' ? "OK" : "Lesionado";
                    break;
                case 'slug':
                    echo "Nombre:</strong> ".$v;
                    break;
                case 'position':
                    echo "Posición:</strong> ".$v;
                    break;
                case 'points':
                    echo "Puntos:</strong> ".$v;
                    break;
                case 'marketValue':
                    // Asegúrate de tener un array con valores de fechas, de lo contrario, este bloque no funcionará
                    $hoy = "30/01/2025"; // Aquí puedes sustituirlo por la fecha actual
                    $ayer = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -1 days"));
                    $semanaPasada = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -7 days"));                    
                    $dif1 = $v[$hoy] - $v[$ayer];
                    $dif2 = $v[$hoy] - $v[$semanaPasada];

                    echo "<p class='valor'>Valor:</strong> ".$v[$hoy]."</p>";
                    echo "<p class='diffAyer'> Diferencia respecto ayer: ";
                    echo $dif1 >= 0 ? "<span class='positivo'>$dif1</span>" : "<span class='negativo'>$dif1</span>";
                    echo "</p>";
                    echo "<p class='diffSem' >Diferencia respecto a la semana pasada: ";
                    echo $dif2 >= 0 ? "<span class='positivo'>$dif2</span>" : "<span class='negativo'>$dif2</span>";
                    echo "</p>";
                    break;
                case 'playerStats':
                    //echo "Estadísticas del Jugador:</strong> ".json_encode($v); // Si 'playerStats' es un array, muestra su contenido.
                    break;
                default:
                    //echo "Información no disponible.".$k;
                    break;
            }
            
            echo "</p>";
        }

        echo "</div>"; // Cierra la sección de información del jugador
        echo "</div>"; // Cierra la tarjeta del jugador
    }

    echo "</div>"; // Cierra el contenedor de todas las tarjetas
}


?>
</main>
<footer>
        <p>&copy; 2025 Fantasy Football</p>
    </footer>

</body>
</html>