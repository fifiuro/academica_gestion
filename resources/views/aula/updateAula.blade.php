@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    NUEVO AULA
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateAula') }}">
            {{ csrf_field() }}
            @foreach($aula as $key => $a)
                <div class="box-body">
                    <div class="form-group">
                        <label for="numero">Número de Aula:</label>
                        <input class="form-control" name="numero" id="numero" placeholder="Número de Aula" type="text" value="{{ $a->numero }}" required>
                        <input type="hidden" name="id" id="id" value="{{ $a->id_aul }}">
                    </div>
                    <div class="form-group">
                        <label for="num_pc">Capacidad:</label>
                        <input type="text" name="num_pc" id="num_pc" placeholder="Capacidad" class="form-control" value="{{ $a->num_pc }}" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control">{{ $a->descripcion }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            @if($a->estado)
                                <option value="1" selected>Habilitado</option>
                                <option value="0">Deshabilitado</option>
                            @else
                                <option value="1">Habilitado</option>
                                <option value="0" selected>Deshabilitado</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="modificar" id="modificar">MODIFICAR</button>
                    <a href="{{ url('findAula') }}" class="btn btn-danger">CANCELAR</a>
                </div>
            @endforeach
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
@endsection