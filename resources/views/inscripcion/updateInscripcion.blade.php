@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    MODIFICACION DE INSCRIPCION
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateInscripcion') }}">
            {{ csrf_field() }}
            @foreach ($cronograma as $key => $c)
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

                <!-- MUESTRA EL PARTICIPANTE SELECCIONADO  -->
                @foreach($persona as $key => $p)
                <div class="row" id="seleccionIns">
                    <div class="form-group col-md-6">
                        <label for="ins">Partipante:</label>
                        <input type="text" name="nomAlu" id="nomAlu" class="form-control" value="{{ $p->nombre }} {{ $p->apellidos }}" disabled>
                    </div>
                </div>
                @endforeach
                <!-- FIN MUESTRA EL ALUMNO SELECCIONADO -->

                <div class="row">
                    <div class="form-group">
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="precio">Precio:</label>
                            <input type="text" name="precio" id="precio" value="{{ $inscripcion->precio }}" class="form-control">
                            <input type="hidden" name="id_insc" value="{{ $inscripcion->id_insc }}">
                        </div>
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="pago">Tipo de Pago:</label>
                            <select name="pago" id="pago" class="form-control" required>
                                <option value=""></option>
                                @if($inscripcion->tipo_pago == 1)
                                    <option value="1" selected>Contado</option>
                                @else
                                    <option value="1">Contado</option>
                                @endif

                                @if($inscripcion->tipo_pago == 2)
                                    <option value="2" selected>En cuotas</option>
                                @else
                                    <option value="2">En cuotas</option>
                                @endif
                                
                                @if($inscripcion->tipo_pago == 3)
                                    <option value="3" selected>Empresa paga el total</option>
                                @else
                                    <option value="3">Empresa paga el total</option>
                                @endif

                                @if($inscripcion->tipo_pago == 4)
                                    <option value="4" selected>Empresa pago parcial</option>
                                @else
                                    <option value="4">Empresa pago parcial</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group  col-md-4 col-sm-4">
                            <label for="cuota" id="cuotaLabel">Número de cuotas:</label>
                            <input type="text" name="cuota" id="cuota" class="form-control" value="{{ $inscripcion->num_cuota }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea name="obs" id="obs" cols="30" rows="5" class="form-control">{{ $inscripcion->obs }}</textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">
                    MODIFICAR INSCRIPCION
                </button>
                <a href="{{ url('findInscripcion') }}" class="btn btn-danger">
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