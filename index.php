<?php $version = "?v" . rand(time(), 10000000); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png" />  
    <title>Título de la Página</title>

    <link rel="stylesheet" href="00-nucleo_css/bootstrap.css<?php echo $version;?>">
    <link rel="stylesheet" href="00-nucleo_css/bootstrap-icons.css<?php echo $version;?>">
    <link rel="stylesheet" href="00-nucleo_css/sweetalert2.min.css<?php echo $version;?>">
    <link rel="stylesheet" href="00-nucleo_css/fancybox.css<?php echo $version;?>">
    <link rel="stylesheet" href="03-nucleo_edit/nucleo.css<?php echo $version;?>">
    
    <!-- Incluir selector_de_modulos.php para cargar estilos de módulos -->
    <?php include '02-nucleo_php/selector_de_modulos.php'; ?>
</head>
<body>
<div id="cargando" style="display: none;" class="text-center">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
    <p>Cargando...</p>
</div>
<div class="container-fluid" id="contenedor_principal"> <button class="btn btn-primary" onclick="administradorGaleria();">asdasdasd</button></div>


<script src="01-nucleo_js/jquery-3.7.1.min.js<?php echo $version;?>"></script>
<script src="01-nucleo_js/bootstrap.bundle.js<?php echo $version;?>"></script>
<script src="01-nucleo_js/sweetalert2.all.min.js<?php echo $version;?>"></script>
<script src="01-nucleo_js/fancybox.umd.js<?php echo $version;?>"></script>
<script src="03-nucleo_edit/nucleo.js<?php echo $version;?>"></script>
<script src="03-nucleo_edit/nucleo_alertas.js<?php echo $version;?>"></script>

<footer id="contenedor_alertas"></footer>
</body>
</html>