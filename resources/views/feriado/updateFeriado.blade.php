@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  EDITAR FERIADO
@endsection

@section('subtituloPag')
  
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
<div class="col-md-3"></div>
<div class="col-md-6 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateFeriado') }}">
            {{ csrf_field() }}
            @foreach($feriado as $key => $f)
                <div class="box-body">
                    <div class="form-group">
                        <label for="nom">Nombre:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" value="{{ $f->nombre }}" required>
                        <input type="hidden" id="id_fer" name="id_fer" value="{{ $f->id_fer }}">
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control pull-right" id="datepicker" type="text" name="fecha" value="{{ formatoFechaReporte($f->fecha) }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado">Nombre:</label>
                        <select class="form-control" name="estado" id="estado">
                            @if($f->estado)
                                <option value="1" selected>Activo</option>
                                <option value="0">Desactivado</option>
                            @else
                                <option value="1">Activo</option>
                                <option value="0" selected>Desactivado</option>
                            @endif
                        </select>
                    </div>
                </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">EDITAR</button>
                <a href="{{ url('findFeriado') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

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

@endsection