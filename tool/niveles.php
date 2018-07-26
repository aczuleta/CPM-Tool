<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" ng-app="inventarioApp"> <!--<![endif]-->
<head>
	<title>Inventario</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">

	<!-- Web Fonts -->
	<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

	<!-- CSS Footer -->
     <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src ="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-messages.min.js"></script>

     <!-- Angular Material Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.8/angular-material.min.js"></script>

    <!-- librería encargada de la conversión de imagen a base64 -->
    <script type="text/javascript" src="https://cdn.rawgit.com/adonespitogo/angular-base64-upload/master/src/angular-base64-upload.js"></script>
</head>

<!--
The #page-top ID is part of the scrolling feature.
The data-spy and data-target are part of the built-in Bootstrap scrollspy function.
-->
<body id="body" data-spy="scroll" data-target=".one-page-header" class="demo-lightbox-gallery" ng-controller="ControladorCtrl"
ng-init="userInit()">

    
    <nav>
    <div class="nav-wrapper">
      <div class="col s12">
        <a href="#!" class="breadcrumb">Niveles</a>
        <a href="#!" class="breadcrumb">Parámetros</a>
      </div>
    </div>
    </nav>
    
    <div class="col s12" >
        <div class="row">
            <div class="col s6">
                <h3>Premios:</h3>
                <br>
                <div class="card large">
                    <div class="card-content black-text">
                        <div class="col s6">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input  placeholder="Placeholder" ng-model="nombre" id="prize_name" type="text" class="validate">
                                    <label for="price_name" >Nombre</label>
                                </div>
                                <div class="input-field col s6">
                                    <input  ng-model="codigoPremio"  placeholder="Placeholder" id="prize_cod" type="number" min="0" class="validate">
                                    <label for="prize_cod">Código</label>
                                </div>
                                <br>
                                <div class="input-field col s4">
                                    <input ng-model="puntosPremio"   placeholder="Placeholder" id="prize_points" type="number" class="validate">
                                    <label for="prize_points">Puntos</label>
                                </div>
                                <div class="input-field col s4">
                                    <input  ng-model="fechaInicio"  placeholder="Placeholder" id="prize_start" type="text" class="datepicker">
                                    <label for="prize_start">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s4">
                                    <input ng-model="fechaFin"  placeholder="Placeholder" id="prize_end" type="text" class="datepicker">
                                    <label for="prize_end">Fecha Fin</label>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="row">
                                <div class="input-field col s12">
                                  <textarea ng-model="descripcion" id="textarea1" class="materialize-textarea" style="overflow-y: scroll; height: 130px;"></textarea>
                                  <label for="textarea1">Descripción</label>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="row">
                                <div class="col s2">
                                     <p>
                                      <label>
                                        <input ng-model="premioActivado" ng-click="verEstado()" type="checkbox" class="filled-in" checked="checked" />
                                        <span>Estado</span>
                                      </label>
                                    </p>
                                </div>
                                <div class="col s6" style="position: relative; bottom: 25px;">
                                    <div class="file-field input-field">
                                      <div class="btn">
                                        <span>Imagen</span>
                                        <input  ng-model="imagen" name="file" 
                                        base-sixty-four-input required onload="onLoad" maxsize="500" accept="image/*" type="file">
                                      </div>
                                      <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                      </div>
                                    </div>
                                </div>
                                <div class="col s4">
                                    <a class="waves-effect waves-light btn modal-trigger" href="#modalImg" >Ver</a>
                                </div>
                             
                            </div>
                        </div>
                        
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s2">
                                    <input  ng-model="marca" placeholder="Placeholder" id="prize_brand" type="text" class="validate">
                                    <label for="prize_brand">Marca</label>
                                </div>
                                <div class="input-field col s2">
                                    <input  ng-model="tipo"  placeholder="Placeholder" id="prize_type" type="text" class="validate">
                                    <label for="prize_type">Tipo</label>
                                </div>
                                <div class="input-field col s4">
                                    <input   ng-model="categoria" placeholder="Placeholder" id="prize_category" type="text" class="validate">
                                    <label for="prize_category">Categoría</label>
                                </div>
                                <div class="input-field col s2">
                                    <select ng-model="nivel">
                                    <option value="" disabled selected>Nivel</option>
                                    <option value="1">Beauty Junkie</option>
                                    <option value="2">Beauty Expert</option>
                                    <option value="3">Beauty Holic </option>
                                    </select>
                                    <label>Nivel</label>
                                </div>
                                <div class="input-field col s2">
                                    <input  ng-model="cadena"  placeholder="Placeholder" id="prize_chain" type="text" class="validate">
                                    <label for="prize_chain">Cadena</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col s12">
                            <div class="row right-align">
                                <div class="col s12 offset-s6">
                                    <div class="col s3" ng-show="editable" ng-click="enableEdit(-1)" >
                                        <a class="waves-effect waves-light btn">Cancelar</a>
                                    </div>

                                    <div ng-show="!editable" ng-click="agregarPremio()" class="col s3 offset-s3">
                                        <a class="waves-effect waves-light btn">Agregar</a>
                                    </div>

                                    <div ng-show="editable" class="col s3 ">
                                        <a class="waves-effect waves-light btn">Guardar</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <br>
                
                <div class="card large" style="overflow-y: scroll;">
                    <div class="card-content black-text" style="overflow-y: scroll;">
                            <table class="highlight centered" style="overflow-y: scroll;">
                            <thead>
                              <tr>
                                  <th>Nombre</th>
                                  <th>Descripción</th>
                                  <th></th>
                                  <th></th>
                              </tr>
                            </thead>

                            <tbody >
                              <tr  ng-repeat=" nivel in niveles ">
                                <td>{{premio.premio}} </td>
                                <td>{{premio.codigo_premio}}</td>
                                <td><a href="#" ng-click="enableEdit($index)" > <img src="https://admin.puntosleal.com/images/btn_editar.png"> </a></td>
                                <td ng-show="premio.estado =='activo'">
                                    <a class="modal-trigger" ng-click="seleccionarPremio($index)" href="#modal1">
                                    <img class="pointer" data-toggle="tooltip" data-placement="top" title="Activar/Desactivar" data-info="activo" src="https://admin.puntosleal.com/images/disponible_on.png"></a>
                                </td>
                                <td ng-show="premio.estado =='inactivo'">
                                <a class="modal-trigger" ng-click="seleccionarPremio($index)" href="#modal2">
                                    <img class="pointer"  data-toggle="tooltip" data-placement="top" title="Activar/Desactivar" data-info="inactivo" src="https://admin.puntosleal.com/images/disponible.png"></a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                </div>
                
            </div>
            
            <!-- Esta es la parte del Inventario-->
            <div ng-show="inventario" class="col s6">
                <h3>Inventario:</h3>
                <div class="col s12">
                     <p>
                      <label>
                        <input  ng-click="habilitar()" type="checkbox" class="filled-in" checked="inHabilitado" />
                        <span>Habilitado</span>
                      </label>
                    </p>
                </div>
                <div ng-show="inHabilitado"  class="col s12">
                    <div class="card small" ng-hide="agregar">
                        <div class="card-content black-text">
                            <h5>{{nombrePremioInventario}}</h5> 
                            <h5>Existencia total: {{unidadesTotalesInventario}} Unidades</h5>
                            <h5>Última actualización: {{ultimaActualizacionInventario}}</h5>
                        </div>
                    </div>
                    <div class="card small" ng-hide="!agregar">
                    <div class="card-content black-text">
                        <h5 style="display:inline-block; width:90%;">Premio 1</h5>
                        <a href="#" ng-click="enableAdd(-1)"><i class="material-icons right-align" >close</i></a>
                        <h5>Existencia total: 200 Unidades</h5>
                        <div class="row">
                            <div class="col s3">
                                <a class="btn white-text"   ng-click="agregarUnidades()" style="display:inline-block">Agregar</a>
                            </div>
                            <div class="col s3">
                                <input style="display:inline-block"   ng-model="cantidadAgregar" placeholder="Placeholder" id="prize_name" type="number" class="validate">
                            </div>
                            <div class="col s3">
                                <p style="display:inline-block">und</p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <br>
                    <br>
                    <table class="highlight centered">
                    <thead>
                      <tr>
                          <th>Sucursal</th>
                          <th>Cantidad</th>
                          <th>Fecha</th>
                          <th></th>
                          <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr ng-repeat=" inventario in inventarios ">
                        <td>{{inventario.id_sucursal}}</td>
                        <td>{{inventario.cantidad}}</td>
                        <td>{{inventario.fecha}}</td>
                        <td><a href="#" ng-click="enableAdd($index)"><img src="https://admin.puntosleal.com/images/btn_agregar_comercio.png"></a></td>
                        <td><a href="#" ng-click="activarHistorial($index)"><img src="https://admin.puntosleal.com/images/btn_reportes.png" alt="Reportes" title="Reportes" style="width:24px"></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              
                
            </div>
            
            <!--Sección de historial-->
            <div ng-show="isHistorial" class="col s6">
                <div class="row">
                    <div class="col s12">
                        <div class="col s12">
                            <h3 class="left-align" style="width: 90%; display: inline-block;">Historial</h3>
                            <a href="#" ng-click="activarHistorial(-1)"><i class="material-icons right-align" >close</i></a>
                        </div>
                       
                        <table class="highlight centered">
                    <thead>
                      <tr>
                          <th>Sucursal</th>
                          <th>Cantidad</th>
                          <th>Fecha</th>
                      
                      </tr>
                    </thead>

                    <tbody>
                      <tr ng-repeat=" move in movimientos ">
                        <td>{{nombreSucursalHistorial}}</td>
                        <td>{{move.cantidad}}</td>
                        <td>{{move.fecha}}</td>
                      </tr>

                    </tbody>
                  </table>
                        
                    </div>
                </div>
                
            </div>
            
            <div id="modalImg" class="modal">
                <div class="modal-content">
                    <img src="{{rutaImagen}}" style="width: 400px; heigh: 400px;">
                </div>
            </div>

            <div id="modal1" class="modal">
                <div class="modal-content">
                  <h4>¿Está seguro que desea desactivar el premio?</h4>
                </div>
                <div class="modal-footer">
                    
                  <a href="#!" ng-click="cambiarEstadoPremio()" class="modal-close waves-effect waves-red btn-flat">Aceptar</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                </div>
            </div>

            <div id="modal2" class="modal">
                <div class="modal-content">
                  <h4>¿Está seguro que desea activar el premio?</h4>
                </div>
                <div class="modal-footer">
                    
                  <a href="#!" ng-click="cambiarEstadoPremio()" class="modal-close waves-effect waves-red btn-flat">Aceptar</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                </div>
            </div>


        </div>
    </div>
    
    
	<!-- JS Page Level-->
    
    <script>
          M.AutoInit();
    </script>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var options = {
        format: 'yyyy-mm-dd',
        i18n: {
            cancel: 'Cancelar',
            clear: 'Limpiar',
            done: 'Aceptar',
            months: [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthsShort: [
                'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
            ],
            weekdays: [
                'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' 
            ],
            weekdaysShort: [
                'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'
            ],
            weekdaysAbbrev:  [
                'D', 'L', 'M', 'M', 'J', 'V', 'S'
            ]
        }
    };
    var instances = M.Datepicker.init(elems, options);
    });

</script>

<script>
 $(document).ready(function(){
    $('input.autocomplete').autocomplete({
      data: marcas});
  });

</script>

    <script src="<?= base_url();?>js/scripts/inventarios.js"></script>
    <!--<script src="scripts/controlador.js"></script>-->
	
</body>
</html>