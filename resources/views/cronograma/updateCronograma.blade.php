@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    MODIFICANDO CRONOGRAMA MENSUAL
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
</br>
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateCronograma') }}">
            {{ csrf_field() }}
            @foreach($cronograma as $key => $c)
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="mes">Mes de Cronograma *:</label>
                        <select name="mes" id="mes" class="form-control">
                            @foreach($mes as $key => $m)
                                @if($key == $c->mes)
                                    <option value="{{ $key }}" selected>{{ $m }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $m }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="gestion">Gestión de Cronograma *:</label>
                        <select name="gestion" id="gestion" class="form-control">
                            @foreach($anio as $key => $a)
                                @if($a == $c->gestion)
                                    <option value="{{ $a }}" selected>{{ $a }}</option>
                                @else
                                    <option value="{{ $a }}">{{ $a }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="seleccionCursoN" name="seleccionCursoN">
                    <div class="form-group col-md-12">
                        <label for="nom">Nombre de curso:</label>
                        <input type="hidden" name="id_cr" id="id_cr" value="{{ $c->id_cr }}" required>
                        <input class="form-control" name="nom" id="nom" placeholder="Precio" type="text" value="{{ $c->codigo }}: {{ $c->nombre }}" disabled>
                    </div>
                </div>
                <div class="row" id="seleccionCursoD" name="seleccionCursoD">
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="dur">Duración *:</label>
                        <input class="form-control" name="dur" id="dur" placeholder="Duración" type="text" value="{{ $c->duracion }}" disabled>
                        <input type="hidden" name="id_ho" id="id_ho" value="{{ $c->id_ho }}">
                        <input type="hidden" name="duracion" id="duracion" value="{{ $c->duracion }}">
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="pre">Precio:</label>
                        <input class="form-control" name="pre" id="pre" placeholder="Precio" type="text" value="{{ $c->precio }}" disabled>
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="fecha_inicio">Fecha de Inicio *:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control pull-right" id="datepicker" type="text" name="fechaInicio" value="{{ formatoFechaReporte($c->f_inicio) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row" id="ventanaHora" name="ventanaHora">
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="horaInicio">Hora Inicio *:</label>
                        <div class="input-group">
                            <?php $h = explode('-',$c->horarios); ?>
                            <input type="text" class="form-control timepicker" name="horaInicio" id="horaInicio" autocomplete="off" value="<?php echo $h[0] ?>">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bootstrap-timepicker col-md-6 col-sm-6">
                        <label for="horaFin">Hora Fin *:</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="horaFin" id="horaFin" autocomplete="off" value="<?php echo $h[1] ?>">
        
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="ventanaDias" name="ventanDias">
                    <label for="dias">Días *:</label>
                    <select name="dias[]" id="dias" class="form-control select2" multiple data-placeholder="Seleccione Días" style="width:100%" required>
                        @if(strpos($c->dias,'1') !== false)
                            <option value="1" selected>Lunes</option>
                        @else
                            <option value="1">Lunes</option>
                        @endif
                        @if(strpos($c->dias,'2')  !== false)
                            <option value="2" selected>Martes</option>
                        @else
                            <option value="2">Martes</option>
                        @endif
                        @if(strpos($c->dias,'3')  !== false)
                            <option value="3" selected>Miércoles</option>
                        @else
                            <option value="3">Miércoles</option>
                        @endif
                        @if(strpos($c->dias,'4')  !== false)
                            <option value="4" selected>Jueves</option>
                        @else
                            <option value="4">Jueves</option>
                        @endif
                        @if(strpos($c->dias,'5')  !== false)
                            <option value="5" selected>Viernes</option>
                        @else
                            <option value="5">Viernes</option>
                        @endif
                        @if(strpos($c->dias,'6')  !== false)
                            <option value="6" selected>Sábado</option>
                        @else
                            <option value="6">Sábado</option>
                        @endif
                        @if(strpos($c->dias,'7') !== false)
                            <option value="7" selected>Domingo</option>
                        @else
                            <option value="7">Domingo</option>
                        @endif
                    </select>
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
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">CANCELAR</a>
            </div>
            @endforeach
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

$('#datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});

$(".timepicker").timepicker({
    timeFormat: 'HH:mm',
    showMeridian: false,
    showInputs: false
});

$(".select2").select2();
@endsection