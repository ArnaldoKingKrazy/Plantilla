<?php
// Obtener el nombre de la carpeta desde la solicitud POST
if (!isset($_POST['carpeta'])) {
    die(json_encode(['status' => 'error', 'message' => 'Parámetro "carpeta" no recibido.']));
}

$carpeta = $_POST['carpeta'];
$namezip = $carpeta;

// Función para agregar archivos al ZIP
function agregar_zip($dir, $zip, $carpeta) {
    // Verificamos si $dir es un directorio
    if (is_dir($dir)) {
        // Abrimos el directorio y lo asignamos a $da
        if ($da = opendir($dir)) {
            // Leemos del directorio hasta que termine
            while (($archivo = readdir($da)) !== false) {
                // Si es un directorio, llamamos recursivamente esta función
                if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    agregar_zip($dir . $archivo . "/", $zip, $carpeta);
                } 
                // Si es un archivo, lo agregamos al ZIP
                elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    $zip->addFile($dir . $archivo, $dir . $archivo);
                }
            }
            // Cerramos el directorio abierto
            closedir($da);
        }
    }
}

// Función para crear el archivo ZIP
function crear_Backup($namezip) {
    // Creamos una instancia de ZipArchive
    $zip = new ZipArchive();

    // Directorio a comprimir (ruta relativa)
    $dir = 'modulos/galeria/Data_Gallery/' . $namezip . '/';

    // Ruta donde guardar los archivos ZIP (debe existir)
    $rutaFinal = "modulos/galeria/Downloads_admin";

    // Si la carpeta de descargas no existe, la creamos
    if (!file_exists($rutaFinal)) {
        mkdir($rutaFinal, 0777, true);
    }

    // Nombre del archivo ZIP
    $archivoZip = $namezip . '.zip';

    // Si el archivo ZIP ya existe, lo eliminamos
    if (file_exists($rutaFinal . "/" . $archivoZip)) {
        unlink($rutaFinal . "/" . $archivoZip);
    }

    // Abrimos el archivo ZIP para agregar archivos
    if ($zip->open($rutaFinal . "/" . $archivoZip, ZipArchive::CREATE) === true) {
        agregar_zip($dir, $zip, $namezip);
        $zip->close();

        // Forzar la descarga del archivo ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $archivoZip . '"');
        header('Content-Length: ' . filesize($rutaFinal . "/" . $archivoZip));
        readfile($rutaFinal . "/" . $archivoZip);

        // Eliminar el archivo ZIP después de la descarga (opcional)
        unlink($rutaFinal . "/" . $archivoZip);
        exit; // Terminar la ejecución del script
    } else {
        die(json_encode(['status' => 'error', 'message' => 'No se pudo crear el archivo ZIP.']));
    }
}

// Llamar a la función para crear el backup
crear_Backup($namezip);
?>