@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    NUEVA INSCRIPCION
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeAula') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="numero">Número de Aula:</label>
                    <input class="form-control" name="numero" id="numero" placeholder="Número de Aula" type="number" maxlength="2" value="{{ old('numero') }}" required>
                </div>
                <div class="form-group">
                    <label for="num_pc">Capacidad:</label>
                    <input type="number" name="num_pc" id="num_pc" placeholder="Capacidad" class="form-control" maxlength="2" value="{{ old('num_pc') }}" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findAula') }}" class="btn btn-danger">CANCELAR</a>
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
      campotexto.setCustomValidity('Esta información es requerida, por favor ingrese un número.');  
    }
});
@endsection