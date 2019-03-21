@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    INSCRIPCION A CURSO
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInscripcion') }}">
            {{ csrf_field() }}
            @foreach ($cronograma as $key => $c)
            <input type="hidden" name="id_cr" id="id_cr" value="{{ $c->id_cr }}">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="mes">Mes / Gestión: </label> {{ $mes[$c->mes] }} / {{ $c->gestion }}
                    </div>
                </div>

                <div class="row" id="seleccionCursoN" name="seleccionCursoN">
                    <div class="form-group col-md-12">
                        <label for="nom">Nombre de curso:</label> {{ $c->codigo }} {{ $c->nombre }}
                    </div>
                </div>
                <div class="row" id="seleccionCursoD" name="seleccionCursoD">
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="dur">Duración:</label> 
                         @if ($c->d == 0)
                            {{ $c->duracion }}
                         @else
                            {{ $c->duracion }}
                         @endif
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="pre">Precio:</label>
                        @if($c->p == 0)
                            {{ $c->precio }}
                        @else
                            {{ $c->p }}
                        @endif
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="fechaInicio">Fecha Inicio</label> {{ formatoFechaReporte($c->f_inicio) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group  col-md-4 col-sm-4">
                        <label for="dis">Disponibilidad:</label> {{ $c->disponibilidad }}
                    </div>
                    <div class="form-group  col-md-4 col-sm-4">
                        <label for="aula">Aula:</label>
                        @foreach ($aula as $key => $a)
                            Aula: {{ $a->numero }} - Cap.: {{ $a->num_pc }}
                        @endforeach
                    </div>
                    <div class="form-group  col-md-4 col-sm-4">
                        <label for="dis">insctructor:</label> 
                        @foreach ($ins as $key => $i)
                            {{ $i->nombre }} {{ $i->apellidos }}
                        @endforeach
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
                                </tr>
                            </thead>
                            <tbody id="horario">
                                @foreach ($horario as $key => $h)
                                    <tr>
                                        <td>{{ formatoFechaReporte($h->f_inicio) }} - {{ formatoFechaReporte($h->f_fin) }}</td>
                                        <td>{{ dias($h->dias) }}</td>
                                        <td>{{ horarios($h->horarios) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BUSQUEDA DE ALUMNO EXISTENTE -->
                <div class="row" id="ventanaBuscar" name="ventanaBuscar">
                    <div class="form-group col-md-10 col-sm-10">
                        <label for="nombre">Nombre Alumno *:</label>
                        <input class="form-control" name="nombre" id="nombre" placeholder="Nombre" type="text" autocomplete="off">
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
                                    <td><strong>Nombre</strong></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="resul" nom="resul">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- FIN DE BUSQUEDA DE ALUMNO EXISTENTE -->

                <!-- MUESTRA EL ALUMNO SELECCIONADO  -->
                <div class="row" id="seleccionIns" style="display:none">
                    <div class="form-group col-md-12">
                        <label for="ins">Alumno:</label>
                        <input type="text" name="nomAlu" id="nomAlu" class="form-control" disabled>
                        <input type="hidden" name="idAlu" id="idAlu">
                    </div>
                </div>
                <!-- FIN MUESTRA EL ALUMNO SELECCIONADO -->

                <div class="row">
                    <div class="form-group">
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="precio">Precio:</label>
                            <input type="text" name="precio" id="precio" value="0" class="form-control">
                        </div>
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="pago">Tipo de Pago:</label>
                            <select name="pago" id="pago" class="form-control" required>
                                <option value=""></option>
                                <option value="1">Contado</option>
                                <option value="2">En cuotas</option>
                                <option value="3">Empresa paga el total</option>
                                <option value="4">Empresa pago parcial</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="cuota" id="cuotaLabel">Número de cuotas:</label>
                            <input type="text" name="cuota" id="cuota" class="form-control" value="1" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea name="obs" id="obs" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">
                    INSCRIBIR
                </button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">
                    CANCELAR
                </a>
            </div>
        </form>
        @endforeach
    </div>
</div>
<div class=" col-md-1"></div>

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
    $("#horario").append('<tr><td><input type="hidden" name="f[]" value="' + $("#fInicio").val() + '-' + $("#fFin").val() + '">' + $("#fInicio").val() + ' - ' + $("#fFin").val() + '</td><td>' + d + '<input type="hidden" name="d[]" value="' + nd + '"></td><td>' + $("#horaInicio").val() + ' - ' + $("#horaFin").val() + '<input type="hidden" name="h[]" value="' + hd + '"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');

    $("#myModal").modal('hide');
    
    $("#ventanaDias").show(1000);
    $("#ventanaDis").show(1000);
    $("#ventanaObs").show(1000);
});
/* FIN DEL LLENADO DIAS Y HORAS */

/* PARA BUSCAR ALUMNO */
$('#myajax').click(function(){
    var nombre = $("#nombre").val();
    if(nombre != ''){
        $.ajax({
            url:'{{ url("findAluInt") }}',
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
        alert("Ingrese el Nombre a buscar.");
    }
});

$("#ventanaResul").on("click",".accion",function(){
    $("#ventanaResul").hide(1000);
    $("#ventanaBuscar").hide(1000);

    $("#seleccionIns").show(1000);
    $("#seleccionCursoD").show(1000);

    var row = $(this).parents('tr');
    var id = row.data('id');
    var nom = row.data('nombre');
    var ape = row.data('apellidos');

    $("#idAlu").val(id);
    $("#nomAlu").val(nom + " " + ape);

});
/* FIN DE BUSQUEDA */

/* PARA EL COMBO DE PAGO */
$("#pago").on("change",function(){
    if($(this).val() == 1){
        $("#cuota").css('visibility','hidden');
        $("#cuotaLabel").css('visibility','hidden');
    }else if($(this).val() == 2){
        $("#cuota").css('visibility','visible');
        $("#cuotaLabel").html("Número de cuotas");
        $("#cuotaLabel").css('visibility','visible');
    }else if($(this).val() == 3){
        $("#cuota").css('visibility','hidden');
        $("#cuotaLabel").css('visibility','hidden');
    }else if($(this).val() == 4){
        $("#cuota").css('visibility','visible');
        $("#cuotaLabel").css('visibility','visible');
        $("#cuotaLabel").html("Porcentaje");
        $("#cuota").val("0");
    }else{
        $("#cuota").css('visibility','hidden');
        $("#cuotaLabel").css('visibility','hidden');
    }
});
/* FIN PARA EL COMBO DE PAGO */
@endsection