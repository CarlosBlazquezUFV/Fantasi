<?php
include("lang/Constant.php");
class Vista {
    private $idiomas;
    private $equipos;
    public function __construct() {
        global $idiomas, $equipos;
        $this->idiomas = $idiomas;
        $this->equipos = $equipos;
    }

public function mostrarHeader($lang) {
    echo ' 
    <header>
        <link rel="stylesheet" href="css/header.css">
        <div class="container">
            <h1>'.$lang['title'].'</h1>
            <nav>
                <ul class="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <a href="#">Jugadores ▼</a>
                        <ul class="submenu">';
                        foreach ($this->equipos as $clave => $archivo) {
                            echo '<li><a href="jugadores.php?equipo='.$clave.'">'.$clave.'</a></li>';
                        }
                        echo '</ul>
                    </li>
                    <li><a href="jugadores.php">Equipos</a></li>
                    <li><a href="estadisticas.php">Estadísticas</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                </ul>
            </nav>
            <div class="language-selector">
                <p>'.$lang['lenguage'].'</p>';
                foreach ($this->idiomas as $codigo => $nombre) {
                    $class = ($codigo === $lang) ? 'class="selected"' : '';
                    echo '<a href="?lang='.$codigo.'" '.$class.'>'.$nombre.'</a> ';
                }
            echo '</div>
        </div>
    </header>';
}
public function mostrarFooter(){
    echo '
    <footer>
        <p>&copy; 2025 Fantasy Football</p>
    </footer>

    </body></html>';
}
public function mostrarEncabezado($style){
    echo'<!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football</title>
    <link rel="stylesheet" href="css/'.$style.'">
    </head><body>';
}
}
