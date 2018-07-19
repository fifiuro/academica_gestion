@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  NUEVO FERIADO
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeFeriado') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control pull-right" id="datepicker" type="text" name="fecha" required>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
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