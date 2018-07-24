@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    EDITAR CURSO
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
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateCurso') }}">
            {{ csrf_field() }}
            @foreach($curso as $key => $c)
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cod">Código Curso *:</label>
                        <input class="form-control" name="cod" id="cod" placeholder="Código" type="text" value="{{ $c->codigo }}" required>
                        <input type="hidden" id="id_cu" name="id_cu" value="{{ $c->id_cu }}" required>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nom">Nombre Curso *:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" value="{{ $c->nombre }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nom_corto">Nombre Corto Cursos *:</label>
                        <input class="form-control" name="nom_corto" id="nom_corto" placeholder="Nombre corto" type="text" value="{{ $c->nom_corto }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dur">Duración *:</label>
                        <div class="input-group">
                            <input class="form-control focus.inputmask" name="dur" id="dur" placeholder="Duración" type="text" data-inputmask="'mask' : ['999']" data-mask="" value="{{ $c->duracion }}" required>
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="pre">Precio *:</label>
                        <div class="input-group">
                            <input class="form-control focus.inputmask" name="pre" id="pre" placeholder="Precio" type="text" data-inputmask="'mask' : ['99999']" data-mask="" value="{{ $c->precio }}" required>
                            <div class="input-group-addon">
                                <strong>Bs.</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cat">Categoria *:</label>
                        <select class="form-control" name="cat" id="cat" required>
                            <option></option>
                            @foreach($cate as $key => $ca)
                                @if($ca->id_cat == $c->categoria)
                                    <option value="{{ $ca->id_cat }}" selected>{{ $ca->nombre }}</option>
                                @else
                                    <option value="{{ $ca->id_cat }}">{{ $ca->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="estado">Estado *:</label>
                    <select class="form-control" name="estado" id="estado">
                        @if($c->estado == 1)
                            <option value="1" selected>Activo</option>
                            <option value="2">Desactivado</option>
                        @elseif($c->estado == 2)
                            <option value="1">Activo</option>
                            <option value="2" selected>Desactivado</option>
                        @endif
                    </select>
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                <a href="{{ url('findCurso') }}" class="btn btn-danger">CANCELAR</a>
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

$("[data-mask]").inputmask();
@endsection