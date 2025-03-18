<?php
$carpeta = isset($_POST['carpeta']) ? $_POST['carpeta'] : '';
$rutaBase = 'Data_Gallery/' . $carpeta . '/';

if (is_dir($rutaBase)) {
    // Eliminar la carpeta y su contenido
    array_map('unlink', glob($rutaBase . '*'));
    rmdir($rutaBase);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Carpeta no encontrada']);
}
?>