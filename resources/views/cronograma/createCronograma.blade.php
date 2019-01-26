@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    CRONOGRAMA MENSUAL
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')
@if($errors->all())
    <div class="alert alert-warning" role="alert">
        <h4>Errores del llenado del formulario</h4>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        Por favor corrija los errores vuelva enviar los datos.
    </div>
@endif
<br>
<div class="col-md-1"></div>
<div class="col-md-10 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeCronograma') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="mes">Mes de Cronograma *:</label>
                        <select name="mes" id="mes" class="form-control" required>
                           @for ($i=0; $i<13; $i++)
                            @if (array_key_exists($i,$mes))
                                @if(date("m") == $i)
                                    <option value="{{ $i }}" selected>{{ $mes[$i] }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $mes[$i] }}</option>
                                @endif
                            @endif
                           @endfor
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="gestion">Gestión de Cronograma *:</label>
                        <select name="gestion" id="gestion" class="form-control" required>
                            @foreach($anio as $key => $a)
                                @if(date("Y") == $a)
                                    <option value="{{ $a }}" selected>{{ $a }}</option>
                                @else
                                    <option value="{{ $a }}">{{ $a }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- BUSQUEDA DE CURSOS -->
                <div class="row" id="ventanaBuscar" name="ventanaBuscar">
                    <div class="form-group col-md-10 col-sm-10">
                        <label for="nombre">Nombre Curso *:</label>
                        <input class="form-control" name="nombre" id="nombre" placeholder="Nombre" type="text" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2 col-sm-2">
                        <a href="#" name="myajax" id="myajax" class="btn btn-danger"><i class="glyphicon glyphicon-search"></i></a>
                    </div>
                </div>
                <div class="row" id="ventanaResul" name="ventanaResul" style="display:none">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td><strong>Código</strong></td>
                                    <td><strong>Nombre</strong></td>
                                    <td><strong>Duración</strong></td>
                                    <td><strong>Precio</strong></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="resul" nom="resul">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- FIN DE BUSQUEDA -->

                <div class="row" id="seleccionCursoN" name="seleccionCursoN" style="display:none">
                    <div class="form-group col-md-12">
                        <label for="nom">Nombre de curso:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Precio" type="text" disabled>
                        <input type="hidden" id="id" name="id_cur">
                    </div>
                </div>
                <div class="row" id="seleccionCursoD" name="seleccionCursoD" style="display:none">
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="dur">Duración *:</label>
                        <input class="form-control" name="dur" id="dur" placeholder="Duración" type="text" disabled>
                        <input type="hidden" name="duracion" id="duracion">
                    </div>
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="pre">Precio:</label>
                        <input class="form-control" name="pre" id="pre" placeholder="Precio" type="text" disabled>
                    </div>
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="fechaInicio">Fecha Inicio</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control pull-right" id="datepicker" type="text" name="fechaInicio" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            HORARIOS
                        </button>
                        <button type="button" class="btn btn-success" id="cambio">
                            HABILITAR
                        </button>
                    </div>
                </div>
                <div class="row" id="ventanaDias" name="ventanaDias" style="display: none;">
                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td><strong>Días</strong></td>
                                    <td><strong>Horario</strong></td>
                                    <td><strong>Acciones</strong></td>
                                </tr>
                            </thead>
                            <tbody id="horario">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group" id="ventanaDis" name="ventanaDis" style="display: none;">
                    <label for="dis">Disponibilidad:</label>
                    <input class="form-control" name="dis" id="dis" placeholder="Disponibilidad" type="text" autocomplete="off">
                </div>
                <div class="form-group" id="ventanaObs" name="ventanaObs" style="display:none;">
                    <label for="obs">Observaciones:</label>
                    <textarea name="obs" id="obs" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar" style="display: none;">
                    GUARDAR
                </button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-1"></div>

<!-- VENTANA DE MODAL -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Asignar Horario</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="dias">Dias</label>
                        <select name="dias[]" id="dias" class="form-control select2" multiple data-placeholder="Seleccione Días" style="width:100%" required>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miércoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sábado</option>
                            <option value="7">Domingo</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="horaInicio">Hora Inicio *:</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="horaInicio" id="horaInicio" autocomplete="off">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="horaFin">Hora Fin *:</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="horaFin" id="horaFin" autocomplete="off">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="asignacion">Asignación Horario</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN DEL MODAL -->

@endsection

@section('extra')
/* MENSAJE DE VALIDACION DE FORMULARIO */
$('#form input[type=text]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida');  
    }
});

$('#form select').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Por favor seleccione un item de la lista.');  
    }
});
/* FIN DE LA VALIDACION */

/* PARA BUSCAR CURSOS */
$('#myajax').click(function(){
    var nombre = $("#nombre").val();
    if(nombre != ''){
        $.ajax({
            url:'{{ url("findCurso") }}',
            data:"nom="+nombre+"&_token={{ csrf_token() }}",
            type:'post',
            success: function(response){
                $("#ventanaResul").show(1000);
                $("#resul").html(response);
            },
            statusCode:{
                404: function(){
                    alert('web not found');
                }
            },
            error: function(x,xs,xt){
                //window.open(JSON.stringify(x));
                //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
            }
        });
    }else{
        alert("Ingrese el Código o nombre del curso.");
    }
});

$("#ventanaResul").on("click",".accion",function(){
    $("#ventanaResul").hide(1000);
    $("#ventanaBuscar").hide(1000);

    $("#seleccionCursoN").show(1000);
    $("#seleccionCursoD").show(1000);

    var row = $(this).parents('tr');
    var id = row.data('id');
    var cod = row.data('c');
    var nom = row.data('n');
    var dur = row.data('d');
    var pre = row.data('p');

    $("#id").val(id);
    $("#nom").val(cod + " " + nom);
    $("#dur").val(dur);
    $("#pre").val(pre);
    $("#duracion").val(dur);

});
/* FIN DE BUSQUEDA */

$('#fInicio').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});

$('#fFin').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});

$(".timepicker").timepicker({
    timeFormat: 'HH:mm',
    showMeridian: false,
    showInputs: false
});

$('#datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});

$(".select2").select2();
/* LLENADO DE DIAS Y HORAS */
$("#asignacion").on("click", function(){
    var ndias = [ '','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo' ];
    var dia = $("#dias").val();
    var d = "";
    var nd = "";
    var hd = "";
    var coin = 0;
    for(var i=1; i<ndias.length; i++){
        if(dia.includes(i.toString())){
            if(coin == 0){
                nd = nd + i;
                hd = hd + $("#horaInicio").val() + "-" + $("#horaFin").val();
                d = d + ndias[i];
                coin = coin + 1;
            }else{
                nd = nd + "," + i;
                d = d + ", " + ndias[i];
                hd = hd + "," + $("#horaInicio").val() + "-" + $("#horaFin").val();
            }
        }
    }
    $("#horario").append('<tr><td>' + d + '<input type="hidden" name="d[]" value="' + nd + '"></td><td>' + $("#horaInicio").val() + ' - ' + $("#horaFin").val() + '<input type="hidden" name="h[]" value="' + hd + '"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');

    $("#myModal").modal('hide');
    
    $("#ventanaDias").show(1000);
    $("#ventanaDis").show(1000);
    $("#ventanaObs").show(1000);
});
/* FIN DEL LLENADO DIAS Y HORAS */

/* ELIMINA UNA FILA DE LA TABLA */
$(document).on('click', '#eliminar', function(){
    $(this).closest('tr').remove();
});
/* FIN ELIMINAR */

/* CAMBIO DE ESTADO DE DISPONIBILIDAD */
$("#dis").on('keyup', function(){
    if($("#dis").val() > 0){
        $("#guardar").css('display','inline');
    }else{
        $("#guardar").css('display','none');
    }
});
/* FIN DE LA DISPONIBILIDAD */

/* HABILITAR LOS CAMBIOS DE DURACION Y PRECIO DEL CURSO */
$("#cambio").on("click", function(){
    if($("#dur").attr('disabled') == 'disabled')
    {
        $("#dur").attr('disabled',false);
        $("#pre").attr('disabled',false);
        $("#cambio").text("BLOQUEAR");
    }else{
        $("#dur").attr('disabled',true);
        $("#pre").attr('disabled',true);
        $("#cambio").text("HABILITAR");
    }
});
/* FIN DE HABILITAR LOS CAMBIOS */

/* Asignar acciones a todos los elementos interactivos */
$(document).on('click', '#dias', function(){
    $('tbody tr input[id=fechaInicio]').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy"
    });

    $('tbody tr input[id=fechaFin]').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy"
    });

    $('tbody tr input[id=horaInicio].timepicker').timepicker({
        timeFormat: 'HH:mm',
        showMeridian: false,
        showInputs: false
    });

    $('tbody tr input[id=horaFin].timepicker').timepicker({
        timeFormat: 'HH:mm',
        showMeridian: false,
        showInputs: false
    });
});

@endsection