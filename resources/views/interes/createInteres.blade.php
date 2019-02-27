@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    NUEVO INTERES
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInteres') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre(s):</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre(s)" type="text" required>
                </div>
                <div class="form-group">
                    <label for="ape">Apellido(s):</label>
                    <input class="form-control" name="ape" id="ape" placeholder="Apellido(s)" type="text" required>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="email">E-mail:</label>
                        <input type="text" name="email" id="email" placeholder="E-mail" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="cel">Celular:</label>
                        <input type="text" name="cel" id="cel" class="form-control" placeholder="Celular" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Listado de Cursos:</label>
                    <select class="form-control select2" multiple="multiple" data-placeholder="Seleccione un Curso" style="width: 100%;" name="id_cu[]" id="id_cu" required>
                        @foreach($curso as $key => $cu)
                            <option value="{{ $cu->id_cu }}">{{ $cu->codigo }} {{ $cu->nombre }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="guardar">GUARDAR</button>
                <a href="{{ url('findInteres') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

@endsection

@section('extra')
/* Da funcionalidad a un select a buscar dentro de sus elementos */
$(".select2").select2();

/* Valida campos vacios de campos de tipo texto */
$('#form input[type=text]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida.');  
    }
});
/* Valida lista sin ninguna seleccion, elemento de tipo select */
$('#form select[name=curso]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Seleccione un curso de la lista.');  
    }
});
@endsection