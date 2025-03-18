<script type="text/javascript">
        (function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, true)
    })
})()
</script>

<div class="row">
	
    <div class="col-12">
        <div class="row bg-principal  mt-1 g-bordes g-radius g-sombra mx-auto">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-1 mt-1  mx-auto ">
                <div class="input-group input-group-sm mx-auto" style="width: 250px;">
                  <span class="input-group-text sombra-b"><b>Buscar:</b></span>
                  <input type="text" name="busqueda" placeholder="Buscar Carpeta..." class="form-control form-control-sm" autocomplete="off" id="searchText">
              </div>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-12 col-12 mb-1 mt-1 mx-auto ">
              <div id="pruebas_id"></div>
               <strong class="mx-auto">Administrador de Galería</strong>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-1 mt-1  ">
                <a href="#" class="btn btn-sm btn-primary me-2 g-sombra mx-auto" data-bs-toggle='modal' data-bs-target='#nuevacarpeta'><i class="bi bi-folder-plus me-1 text-md"></i>Nueva Carpeta</a>   
          </div>
        </div>

        <div class="row  mt-3 carga_galeria"></div> 

        </div>
</div>


  <script>
  $(document).ready(function(){
    load();
  });

$(document).on('keyup','#searchText',function(){
    var valor= $(this).val();
    if (valor!="") {
        load(valor);
    }else{
        load();
    }
});




  function load(carpeta){

    var parametros = {"action":"ajax","carpeta":carpeta};
    $.ajax({
      url:'modulos/galeria/cargar_carpetas_admin.php',
      data: parametros,
      success:function(data){
        $(".carga_galeria").html(data);
      }
    })
  }

  </script>




 <div class='modal fade text-center' id='nuevacarpeta' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-lg'>
    <div class='modal-content'>
      <div class='modal-header bg-principal text-center g-sombra'>
        <h5 class='modal-title titulo_modal' id='EditModalLabel text-center'><center id="nuevacarpeta_titulo_modal" class="text-center texto-blanco">Crear Nueva Carpeta En la Galeria</center></h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
     <div class='container-fluid'>
      <div class='row'>
        <div class="col" id="nuevacarpeta_contenido_de_modal text-center">
            
<form class="needs-validation" enctype="multipart/form-data"  onsubmit="administradorGaleria_crear_carpeta('addimgs'); return false" id="addimgs" novalidate>

      <div class="input-group input-group-sm mb-3">
            <span class="input-group-text g-sombra"><b>Nombre de La Carpeta:</b></span>
          <input class="form-control form-control-sm form-control-danger g-sombra" placeholder="Ingresa Un Nombre Para la Carpeta"  type="text" name="nombre_carpeta" autocomplete=false required>
      </div>
      <div class="input-group input-group-sm mb-3">
 <span class="input-group-text g-sombra"><b>Imagen(es):</b></span>
 <input class="form-control form-control-sm form-control-danger g-sombra" id="formFileSm" type="file" name="imagen[]" value=""  multiple required>


      </div>
        <button class="btn btn-primary btn-sm g-sombra" type="submit" id="button-addon2"><i class="bi bi-upload me-1 text-md"></i>Crear Carpeta y Subir Imagen(es)</button>
</form>


        </div>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>