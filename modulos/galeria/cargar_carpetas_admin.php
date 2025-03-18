<?php
// Ruta base donde se almacenan las carpetas de la galería
$rutaBase = 'Data_Gallery/';

// Verificar si se recibió el parámetro de búsqueda
$carpetaBusqueda = isset($_POST['carpeta']) ? $_POST['carpeta'] : '';

// Obtener las carpetas dentro del directorio base
$carpetas = glob($rutaBase . '*' . $carpetaBusqueda . '*', GLOB_ONLYDIR);

// Si no hay carpetas, mostrar un mensaje
if (empty($carpetas)) {
    echo '<div class="col-12 text-center"><p>No se encontraron carpetas.</p></div>';
    exit;
}

// Mostrar las carpetas en cards de Bootstrap
foreach ($carpetas as $carpeta) {
    // Obtener el nombre de la carpeta
    $nombreCarpeta = basename($carpeta);

    // Obtener la primera imagen de la carpeta para mostrar como miniatura
    $imagenes = glob($carpeta . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    $imagenMiniatura = !empty($imagenes) ? $imagenes[0] : 'ruta/a/imagen/por/defecto.jpg';

    // Leer el archivo JSON para obtener la fecha de la última imagen subida
    $dataFile = $carpeta . '/data.json';
    $imagenesData = [];
    if (file_exists($dataFile)) {
        $imagenesData = json_decode(file_get_contents($dataFile), true);
    }

    // Obtener la fecha de la última imagen subida
    $ultimaFecha = 'Sin imágenes';
    if (!empty($imagenesData)) {
        $ultimaImagen = end($imagenesData);
        $ultimaFecha = $ultimaImagen['fecha'];
    }

    // Mostrar la card
    echo '
    <div class="col-lg-2 col-md-2 col-sm-6 col-12 mb-4">
        <div class="card g-sombra">
            <h5 class="card-title text-center g-sombra bg-principal redondear text-truncate px-2" title="' . $nombreCarpeta . '">
                ' . $nombreCarpeta . '
            </h5>
            <img src="modulos/galeria/' . $imagenMiniatura . '" class="card-img-top" alt="' . $nombreCarpeta . '" style="height: 70px; object-fit: cover;">
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-sm  g-sombra me-1" onclick="modulo_galeria_ver_carpeta(\'' . $nombreCarpeta . '\')">
                    <i class="bi bi-folder2-open"></i> Abrir Carpeta
                </a>
            <button class="btn btn-sm btn-danger me-2 g-sombra " onclick="eliminarCarpeta(\'' . $nombreCarpeta . '\')">
            <i class="bi bi-trash"></i>
        </button>
            </div>
        </div>
    </div>';
}
?>