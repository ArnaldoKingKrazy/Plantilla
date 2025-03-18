<?php
date_default_timezone_set('America/Caracas');

$response = ['status' => 'error', 'message' => 'Error desconocido', 'type' => 'general'];

if (isset($_POST['nombre_carpeta'])) {
    $carpeta = $_POST['nombre_carpeta'];
    $directoriox = 'Data_Gallery/' . $carpeta;

    if (!file_exists($directoriox)) {
        // Crear la carpeta si no existe
        mkdir($directoriox, 0777, true);
        $directoriox = $directoriox . "/";

        // Crear un archivo JSON para almacenar los datos de las imágenes
        $dataFile = $directoriox . 'data.json';
        file_put_contents($dataFile, json_encode([])); // Inicializar con un array vacío

        if (isset($_FILES['imagen'])) {
            $cantidad = count($_FILES["imagen"]["tmp_name"]);
            $imagenes = json_decode(file_get_contents($dataFile), true);

            for ($i = 0; $i < $cantidad; $i++) {
                if ($_FILES['imagen']['type'][$i] == 'image/png' || $_FILES['imagen']['type'][$i] == 'image/jpeg' || $_FILES['imagen']['type'][$i] == 'image/jpg') {
                    // Mover la imagen a la carpeta
                    $subir_archivo = $directoriox . basename($_FILES['imagen']['name'][$i]);
                    move_uploaded_file($_FILES['imagen']['tmp_name'][$i], $subir_archivo);

                    // Agregar la información de la imagen al array
                    $imagenes[] = [
                        'nombre' => $_FILES['imagen']['name'][$i],
                        'fecha' => date('Y-m-d H:i:s') // Fecha actual
                    ];

                    // Guardar el array actualizado en el archivo JSON
                    file_put_contents($dataFile, json_encode($imagenes));

                    $response = ['status' => 'success', 'message' => 'Imagen(es) subida(s) con éxito'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Tipo de archivo no válido', 'type' => 'general'];
                }
            }

            if ($i >= $cantidad) {
                $response = ['status' => 'success', 'message' => 'Proceso terminado'];
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Ya existe una carpeta con ese nombre', 'type' => 'existe'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>