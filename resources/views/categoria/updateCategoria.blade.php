@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    EDITAR CATEGORIA
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
</br>
<div class="col-md-3"></div>
<div class="col-md-6 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateCategoria') }}">
            {{ csrf_field() }}
            @foreach($categoria as $key => $ca)
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre Categoria:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre Categoria" type="text" value="{{ $ca->nombre }}" required>
                    <input type="hidden" name="id_cat" id="id_cat" value="{{ $ca->id_cat }}">
                </div>
                <div class="form-group">
                    <label for="nivel">Nombre Categoria:</label>
                    <select class="form-control" name="nivel" id="nivel" required>
                        @if($ca->nivel == 0)
                            <option value="0" selected>Principal</option>
                            <option value="1">Sub-Categoria</option>
                        @else
                            <option value="0">Principal</option>
                            <option value="1" selected>Sub-Categoria</option>
                        @endif
                    </select>
                </div>
                <div class="form-group" id="perte" style="display: none;">
                    <label for="n">Categoria a la que pertenece:</label>
                    <select class="form-control" name="n" id="n">
                        <option value=""></option>
                        @foreach($cate as $key => $c)
                            @if($ca->id_cate == $c->id_cat)
                                <option value="{{ $c->id_cat }}" selected>{{ $c->nombre }}</option>
                            @else
                                <option value="{{ $c->id_cat }}">{{ $c->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nivel">Estado:</label>
                    <select class="form-control" name="estado" id="estado" required>
                        @if($ca->estado == 0)
                            <option value="0" selected>Desactivado</option>
                            <option value="1">Activo</option>
                        @else
                            <option value="0">Desactivado</option>
                            <option value="1" selected>Activo</option>
                        @endif
                    </select>
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                <a href="{{ url('findCategoria') }}" class="btn btn-danger">CANCELAR</a>
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
    else{
        $('#guardar').on('click', function(){
            $(this).attr('disabled',true);
        });
    }
});

$("#nivel").on('change', function(){
    if($(this).val() == 0){
        $("#perte").hide();
    }else{
        $("#perte").show(500);
    }
});
@endsection