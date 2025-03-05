<?php
include("lang/Constant.php");
class Vista
{
    private $idiomas;
    private $equipos;
    public function __construct()
    {
        global $idiomas, $equipos;
        $this->idiomas = $idiomas;
        $this->equipos = $equipos;
    }

    public function mostrarHeader($lang)
    {
        echo ' 
    <header>
        <link rel="stylesheet" href="css/header.css">
        <div class="container">
            <h1>' . $lang['title'] . '</h1>
            <nav>
                <ul class="menu">
                    <li><a href="index.php?inicio">Inicio</a></li>
                    <li>
                        <a href="#">Jugadores ▼</a>
                        <ul class="submenu">';
        foreach ($this->equipos as $clave => $datos) {
            echo '<li><a href="index.php?equipo=' . $clave . '">' . $datos["name"] . '</a></li>';
        }
        echo '</ul>
                    </li>
                    <li><a href="?equipos">Equipos</a></li>
                    <li><a href="?estadistica">Estadísticas</a></li>
                    <li><a href="?WhoIAm">Contacto</a></li>
                </ul>
            </nav>
            <div class="language-selector">
                <p>' . $lang['lenguage'] . '</p>';
        foreach ($this->idiomas as $codigo => $nombre) {
            $class = ($codigo === $lang) ? 'class="selected"' : '';
            echo '<a href="?lang=' . $codigo . '" ' . $class . '>' . $nombre . '</a> ';
        }
        echo '</div>
        </div>
    </header><main>';
    }
    public function mostrarFooter()
    {
        echo '
            </main>
            <footer>
                <form method="GET" action="">
                    <button type="submit" name="WhoIAm">¿Quiénes Somos?</button>
                    <button type="submit" name="Proyect">Objetivo del Proyecto</button>
                </form>
    
                <p>&copy; 2025 Fantasy Football</p>
            </footer>
        </body></html>';
    }
    
    public function mostrarEncabezado($style)
    {
        echo '<!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football</title>
    <link rel="icon" href="Image/icono_F.png" type="image/png">
    <link rel="stylesheet" href="css/' . $style . '">
    </head><body>';
    }
    private function MostrarJugadores($array)
    {
        echo "<div class='dia'>";

        echo "<form method='GET' action='index.php'>";
        echo "<label for='fecha'>Selecciona una fecha:</label>";
        echo "<input type='hidden' name='equipo' value='" . (isset($_GET['equipo']) ? $_GET['equipo'] : 'ATM') . "'>";
        echo "<input type='date' name='fecha' id='fecha' value='" . (isset($_GET['fecha']) ? $_GET['fecha'] : date("Y-m-d")) . "'>";
        echo "<button type='submit'>Filtrar</button>";
        echo "</form>";
        echo "</div>";

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
            foreach ($valor as $k => $v) {
                echo "<p><strong>";

                switch ($k) {
                    case 'status':
                        echo "Estado:</strong> ";
                        echo $v == 'ok' ? "OK" : "Lesionado";
                        break;
                    case 'slug':
                        echo "Nombre:</strong> " . $v;
                        break;
                    case 'position':
                        echo "Posición:</strong> " . $v;
                        break;
                    case 'points':
                        echo "Puntos:</strong> " . $v;
                        break;
                    case 'marketValue':
                        $hoy = $_GET['fecha'];
                        // Aquí puedes sustituirlo por la fecha actual
                        $ayer = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -1 days"));
                        $semanaPasada = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -7 days"));
                        if (array_key_exists($hoy, $v) && array_key_exists($ayer, $v) && array_key_exists($semanaPasada, $v)) {
                            echo "<p>Las claves existen en el array.</p>";
                        } else {
                            $hoy = "30/01/2025";
                            // Aquí puedes sustituirlo por la fecha actual
                            $ayer = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -1 days"));
                            $semanaPasada = date("d/m/Y", strtotime(str_replace('/', '-', $hoy) . " -7 days"));
                        }
                        $dif1 = $v[$hoy] - $v[$ayer];
                        $dif2 = $v[$hoy] - $v[$semanaPasada];

                        echo "<p class='valor'>Valor:</strong> " . $v[$hoy] . "</p>";
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
    public function datosEquipo($ruta)
    {
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
                $this->MostrarJugadores($data);
            } else {
                echo "Error al decodificar el JSON: " . json_last_error_msg();
                echo "<br>" . $ruta;
            }
        } else {
            echo "El archivo JSON no existe en la ruta especificada.";
        }
    }
    public function inicio()
    {
        echo "
        <div class='inicio'>
            <h1>Bienvenido a la Web App de Liga Fantasy</h1>
            <p>Esta aplicación web te permite visualizar los datos actualizados de los jugadores y equipos de la liga fantasy. Usamos una API para traer información en tiempo real sobre puntos, valor de mercado y rendimiento de cada jugador.</p>
            
            <h2>¿Qué encontrarás aquí?</h2>
            <ul>
                <li>Clasificación y estadísticas de cada equipo.</li>
                <li>Puntos y rendimiento diario de los jugadores.</li>
                <li>Evolución del valor de mercado en tiempo real.</li>
            </ul>
    
            <p>Explora la información y toma mejores decisiones para tu equipo fantasy.</p>
    
            <a href='equipos.php' class='btn-inicio'>Ver Equipos</a>
            <a href='jugadores.php' class='btn-inicio'>Ver Jugadores</a>
        </div>";
    }
    public function quienesSomos()
    {
        echo "
        <div class='quienes-somos'>
            <h2>¿Quiénes Somos?</h2>
            <p>Somos un equipo apasionado por el análisis de datos deportivos y la optimización de estrategias en ligas fantasy. Nuestra web app utiliza datos en tiempo real para ofrecer información precisa y actualizada sobre equipos y jugadores.</p>

            <h3>Nuestra Misión</h3>
            <p>Brindar a los usuarios estadísticas detalladas y herramientas para mejorar su rendimiento en la liga fantasy.</p>

            <h3>Nuestro Compromiso</h3>
            <p>Nos aseguramos de que los datos sean actualizados diariamente para ofrecer información confiable y relevante.</p>

            <p>¡Gracias por confiar en nosotros!</p>
        </div>";
    }

    public function mostrarEquipos()
    {
        echo "<div class='containerEquipos'>";
        foreach ($this->equipos as $c => $v) {
            echo "<div class='card' onclick=\"window.location.href='index.php?equipo=$c'\">";
            echo "<img src='" . $v['escudo'] . "' alt='" . $v['name'] . "' class='escudo'>";
            echo "<h3>" . $v["name"] . "</h3>";
            echo "</div>";
        }
        echo "</div>";
    }
    public function objetivoProyecto()
    {
        echo "
        <div class='objetivo-proyecto'>
            <h2>Objetivo del Proyecto</h2>
            <p>Este proyecto tiene como objetivo proporcionar a los usuarios una plataforma web donde puedan consultar estadísticas actualizadas de jugadores y equipos en la liga fantasy. Utilizando datos de una API en tiempo real, buscamos mejorar la experiencia de los jugadores ofreciendo información detallada para optimizar sus estrategias.</p>

            <h3>¿Qué buscamos lograr?</h3>
            <ul>
                <li>Brindar información confiable y actualizada sobre la liga fantasy.</li>
                <li>Facilitar la toma de decisiones en la selección de jugadores y equipos.</li>
                <li>Ofrecer una interfaz intuitiva para acceder a estadísticas clave.</li>
            </ul>
        </div>";
    }
}
