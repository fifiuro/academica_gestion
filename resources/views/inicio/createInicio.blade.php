@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    INICIO DE CURSO MENSUAL
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInicio') }}">
            {{ csrf_field() }}
            @foreach ($cronograma as $key => $c)
            <input type="hidden" name="id_cr" id="id_cr" value="{{ $c->id_cr }}">
            <input type="hidden" name="id_ho" id="id_ho" value="{{ $c->id_ho }}">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="mes">Mes de Cronograma:</label>
                        <input class="form-control" type="text" name="mes" id="mes" value="{{ $mes[$c->mes] }}" disabled>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="gestion">Gestión de Cronograma *:</label>
                        <input class="form-control" type="text" name="gestion" id="gestion" value="{{ $c->gestion }}" disabled>
                    </div>
                </div>

                <div class="row" id="seleccionCursoN" name="seleccionCursoN">
                    <div class="form-group col-md-12">
                        <label for="nom">Nombre de curso:</label> 
                        <input class="form-control" name="nom" id="nom" placeholder="Precio" type="text" value="{{ $c->codigo }} {{ $c->nombre }}" disabled>
                        <input type="hidden" id="id" name="id_cur" value="{{ $c->id_cu }}">
                    </div>
                </div>
                <div class="row" id="seleccionCursoD" name="seleccionCursoD">
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="dur">Duración *:</label>
                        <input class="form-control" name="dur" id="dur" placeholder="Duración" type="text" value="{{ $c->duracion }}" disabled>
                        <input type="hidden" name="duracion" id="duracion" value="{{ $c->duracion }}">
                    </div>
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="pre">Precio:</label>
                        @if($c->p == 0)
                            <input class="form-control" name="pre" id="pre" placeholder="Precio" type="text" value="{{ $c->precio }}" disabled>
                        @else
                            <input class="form-control" name="pre" id="pre" placeholder="Precio" type="text" value="{{ $c->p }}" disabled>
                        @endif
                    </div>
                    <div class="form-group col-md-3 col-sm-3">
                        <label for="fechaInicio">Fecha Inicio</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        <input class="form-control pull-right" id="datepicker" type="text" name="fechaInicio" autocomplete="off" value="{{ formatoFechaReporte($c->f_inicio) }}" required>
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
                <div class="row" id="ventanaDias" name="ventanaDias">
                    <div class="col-xs-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td><strong>Fecha</strong></td>
                                    <td><strong>Días</strong></td>
                                    <td><strong>Horario</strong></td>
                                    <td><strong>Acciones</strong></td>
                                </tr>
                            </thead>
                            <tbody id="horario">
                                @foreach (diasMod($c->dias,$c->horarios,'i') as $key => $dm)
                                    {!! $dm !!}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group" id="ventanaDis" name="ventanaDis">
                    <label for="dis">Disponibilidad:</label>
                <input class="form-control" name="dis" id="dis" placeholder="Disponibilidad" type="text" autocomplete="off" value="{{ $c->disponibilidad }}">
                </div>
                <div class="form-group" id="ventanaObs" name="ventanaObs">
                    <label for="obs">Observaciones:</label>
                <textarea name="obs" id="obs" cols="30" rows="5" class="form-control">{{ $c->obs }}</textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">
                    INICIAR
                </button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
        @endforeach
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
                    <div class="form-group col-xs-6">
                        <label for="fechaInicio">Fecha Inicio</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        <input class="form-control pull-right" id="fInicio" type="text" name="fechaInicio" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                            <label for="fechaInicio">Fecha Fin</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            <input class="form-control pull-right" id="fFin" type="text" name="fechaInicio" autocomplete="off" required>
                            </div>
                        </div>
                </div>
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
/* LLENADO DE FECHAS, DIAS Y HORAS */
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
    $("#horario").append('<tr><td><input type="hidden" name="f[]" value="' + $("#fInicio").val() + ' - ' + $("#fFin").val() + '">' + $("#fInicio").val() + ' - ' + $("#fFin").val() + '</td><td>' + d + '<input type="hidden" name="d[]" value="' + nd + '"></td><td>' + $("#horaInicio").val() + ' - ' + $("#horaFin").val() + '<input type="hidden" name="h[]" value="' + hd + '"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');

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