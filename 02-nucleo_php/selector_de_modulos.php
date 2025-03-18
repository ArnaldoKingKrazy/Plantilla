<?php
$version = "?v" . rand(time(), 10000000);
// selector_de_modulos.php

$modulosDir = 'modulos'; // Ruta de la carpeta de módulos
$modulos = scandir($modulosDir); // Obtener todas las carpetas y archivos dentro de modulos

foreach ($modulos as $modulo) {
    // Ignorar las entradas "." y ".."
    if ($modulo !== '.' && $modulo !== '..' && is_dir($modulosDir . '/' . $modulo)) {
        // Ruta del archivo CSS
        $cssFile = $modulosDir . '/' . $modulo . '/' . $modulo . '.css';
        // Ruta del archivo JS
        $jsFile = $modulosDir . '/' . $modulo . '/' . $modulo . '.js';

        // Si existe el archivo CSS, lo enlaza
        if (file_exists($cssFile)) {
            echo '<link rel="stylesheet" href="' . $cssFile . $version . '">' . "\n";
        }

        // Si existe el archivo JS, lo enlaza
        if (file_exists($jsFile)) {
            echo '<script src="' . $jsFile . $version . '"></script>' . "\n";
        }
    }
}
?>