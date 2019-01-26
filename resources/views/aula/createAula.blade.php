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
</br>
<div class="col-md-3"></div>
<div class="col-md-6 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeCategoria') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre Categoria:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre Categoria" type="text" required>
                </div>
                <div class="form-group">
                    <label for="nivel">Nombre Categoria:</label>
                    <select class="form-control" name="nivel" id="nivel" required>
                        <option value="0">Principal</option>
                        <option value="1">Sub-Categoria</option>
                    </select>
                </div>
                <div class="form-group" id="perte" style="display: none;">
                    <label for="n">Categoria a la que pertenece:</label>
                    <select class="form-control" name="n" id="n">
                        <option value=""></option>
                        @foreach($cate as $key => $c)
                            <option value="{{ $c->id_cat }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
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