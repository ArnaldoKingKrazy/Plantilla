<?php
// Obtener el nombre de la carpeta desde la solicitud POST
if (!isset($_POST['carpeta'])) {
    die(json_encode(['status' => 'error', 'message' => 'Parámetro "carpeta" no recibido.']));
}

$carpeta = $_POST['carpeta'];
$rutaBase = __DIR__ . '/Data_Gallery/' . $carpeta . '/'; // Ruta absoluta en el servidor

// Verificar si la carpeta existe
if (!is_dir($rutaBase)) {
    die(json_encode(['status' => 'error', 'message' => 'La carpeta no existe en la ruta: ' . $rutaBase]));
}

// Obtener las imágenes de la carpeta
$imagenes = glob($rutaBase . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if (empty($imagenes)) {
    die(json_encode(['status' => 'error', 'message' => 'No se encontraron imágenes en esta carpeta.']));
}

// Generar el HTML de la galería
$html = '
<div class="row bg-principal mt-1 g-bordes g-radius g-sombra mx-auto align-items-center py-2">
    <!-- Botón de regresar -->
    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-1 mt-1 text-start">
        <button class="btn btn-sm btn-secondary w-100 g-sombra" onclick="administradorGaleria()">
            <i class="bi bi-arrow-left"></i> Regresar
        </button>
    </div>

    <!-- Título de la carpeta -->
    <div class="col-lg-6 col-md-5 col-sm-8 col-12 mb-1 mt-1 text-center">
        <strong class="mx-auto">Carpeta: ' . $carpeta . '</strong>
    </div>

    <!-- Botones de acciones (Eliminar y Descargar) -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-1 mt-1 text-end">
        <button class="btn btn-sm btn-danger me-2 g-sombra" onclick="eliminarCarpeta(\'' . $carpeta . '\')">
            <i class="bi bi-trash"></i> Eliminar
        </button>
        <button class="btn btn-sm btn-success g-sombra" onclick="descargarCarpeta(\'' . $carpeta . '\')">
            <i class="bi bi-download"></i> Descargar
        </button>
    </div>
</div>
<div class="row mt-3">';

foreach ($imagenes as $imagen) {
    $nombreImagen = basename($imagen);
    $rutaImagen = 'modulos/galeria/Data_Gallery/' . $carpeta . '/' . $nombreImagen; // Ruta relativa desde la raíz del proyecto

    // Verificar si la imagen existe antes de mostrarla
    if (file_exists($rutaBase . $nombreImagen)) {
        $html .= '
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
            <a href="' . $rutaImagen . '" data-fancybox="gallery" data-caption="' . $nombreImagen . '">
                <img src="' . $rutaImagen . '" class="img-fluid img-thumbnail g-sombra" alt="' . $nombreImagen . '">
            </a>
        </div>';
    } else {
        $html .= '
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
            <p>Imagen no encontrada: ' . $nombreImagen . '</p>
        </div>';
    }
}

$html .= '</div>';

echo $html;
?>