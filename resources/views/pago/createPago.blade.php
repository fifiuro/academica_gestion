@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    NUEVO TIPO DE PAGO
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

<div class="col-md-3"></div>
<div class="col-md-6 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storePago') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="tipo">Tipo de Pago:</label>
                    <input class="form-control" name="tipo" id="tipo" placeholder="Tipo de Pago" type="text" value="{{ old('numero') }}" required>
                </div>
                <div class="form-group">
                    <label for="des">Descripción:</label>
                    <textarea name="des" id="des" cols="30" rows="5" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findPago') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

@endsection

@section('extra')
$('#form input[type=number]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida.');  
    }
});
@endsection