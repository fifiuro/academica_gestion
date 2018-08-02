@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    NUEVO CURSO
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeCurso') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cod">Código Curso *:</label>
                        <input class="form-control" name="cod" id="cod" placeholder="Código" type="text" required>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nom">Nombre Curso *:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="nom_corto">Nombre Corto Cursos *:</label>
                        <input class="form-control" name="nom_corto" id="nom_corto" placeholder="Nombre corto" type="text" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="dur">Duración *:</label>
                        <div class="input-group">
                            <input class="form-control focus.inputmask" name="dur" id="dur" placeholder="Duración" type="text" data-inputmask="'mask' : ['999']" data-mask="" required>
                            <div class="input-group-addon">
                                <strong>Hrs.</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pre">Precio *:</label>
                        <div class="input-group">
                            <input class="form-control focus.inputmask" name="pre" id="pre" placeholder="Precio" type="text" data-inputmask="'mask' : ['99999']" data-mask="" value="0">
                            <div class="input-group-addon">
                                <strong>Bs.</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="cat">Categoria *:</label>
                        <select class="form-control" name="cat" id="cat" required>
                            <option selected></option>
                            @foreach($cate as $key => $ca)
                                <option value="{{ $ca->id_cat }}">{{ $ca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
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