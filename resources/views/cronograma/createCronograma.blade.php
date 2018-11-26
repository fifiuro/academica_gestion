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
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
</br>
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeCronograma') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="mes">Mes de Cronograma *:</label>
                        <select name="mes" id="mes" class="form-control">
                            @foreach($mes as $key => $m)
                                <option value="{{ $m["id"] }}">{{ $m["mes"] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="gestion">Gestión de Cronograma *:</label>
                        <select name="gestion" id="gestion" class="form-control">
                            @foreach($anio as $key => $a)
                                <option value="{{ $a }}">{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="ventanaBuscar" name="ventanaBuscar">
                    <div class="form-group col-md-10 col-sm-10">
                        <label for="nombre">Nombre Curso *:</label>
                        <input class="form-control" name="nombre" id="nombre" placeholder="Nombre" type="text" required>
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
                <div class="row" id="seleccionCursoN" name="seleccionCursoN" style="display:none">
                    <div class="form-group col-md-12">
                        <label for="nom">Nombre de curso:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Precio" type="text" disabled>
                        <input type="hidden" id="id" name="id">
                    </div>
                </div>
                <div class="row" id="seleccionCursoD" name="seleccionCursoD" style="display:none">
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="dur">Duración *:</label>
                        <input class="form-control" name="dur" id="dur" placeholder="Duración" type="text" disabled>
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="pre">Precio:</label>
                        <input class="form-control" name="pre" id="pre" placeholder="Precio" type="text" disabled>
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="fecha_inicio">Fecha de Inicio *:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control pull-right" id="datepicker" type="text" name="fechaInicio" required>
                        </div>
                    </div>
                </div>
                <div class="row" id="ventanaHora" name="ventanaHora" style="display:none">
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="hora_inicio">Hora Inicio *:</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="hora_inicio">Hora Fin *:</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="ventanaDias" name="ventanDias" style="display:none">
                    <label for="dias">Días *:</label>
                    <select name="dias" id="dias" class="form-control select2" multiple="multiple" data-placeholder="Seleccione Días" style="width:100%" required>
                        <option value="2">Lunes</option>
                        <option value="3">Martes</option>
                        <option value="4">Miércoles</option>
                        <option value="5">Jueves</option>
                        <option value="6">Viernes</option>
                        <option value="7">Sábado</option>
                        <option value="1">Domingo</option>
                    </select>
                </div>
                <div class="form-group" id="ventanaDis" name="ventanaDis" style="display:none">
                    <label for="dis">Disponibilidad:</label>
                    <input class="form-control" name="dis" id="dis" placeholder="Disponibilidad" type="text">
                </div>
                <div class="form-group" id="ventanaObs" name="ventanaObs" style="display:none">
                    <label for="obs">Observaciones:</label>
                    <textarea name="obs" id="obs" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-2"></div>

@endsection

@section('extra')
$('#form input[type=text]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida');  
    }
});

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
    //$("#ventanaResul").css("display","none");
    //$("#ventanaBuscar").css("display","none");
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

});

$('#datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});

$(".timepicker").timepicker({
    timeFormat: 'HH:mm',
    showMeridian: false,
    showInputs: false
});

$("#datepicker").on("change",function(){
    if($(this).val() != ''){
        $("#ventanaHora").show(1000);
        $("#ventanaDias").show(1000);
        $("#ventanaDis").show(1000);
        $("#ventanaObs").show(1000);
    }else{
        $("#ventanaHora").hide(1000);
        $("#ventanaDias").hide(1000);
        $("#ventanaDis").hide(1000);
        $("#ventanaObs").hide(1000);
    }
});

$(".select2").select2();
@endsection