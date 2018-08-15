@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  EDITAR EMPRESA
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateEmpresa') }}">
            {{ csrf_field() }}
            @foreach($empresa as $key => $e)
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Razon Social *:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Razon Social" type="text" value="{{ $e->razon_social }}" required>
                    <input type="hidden" name="id_em" id="id_em" value="{{ $e->id_em }}">
                </div>
                <div class="form-group">
                    <label for="sig">Sigla *:</label>
                    <input class="form-control" name="sig" id="sig" placeholder="Sigla" type="text" value="{{ $e->sigla }}" required>
                </div>
                <div class="form-group">
                    <label for="nit">NIT:</label>
                    <input class="form-control" name="nit" id="nit" placeholder="NIT" value="{{ $e->nit }}" type="text">
                </div>
                <div class="form-group">
                    <label for="dir">Dirección:</label>
                    <textarea class="form-control" name="dir" id="dir" cols="30" rows="5">{{ $e->direccion }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tel">Teléfono:</label>
                    <input class="form-control" name="tel" id="tel" placeholder="Teléfono" type="text" value="{{ $e->tel }}">
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="editar" id="editar">EDITAR</button>
                <a href="{{ url('findEmpresa') }}" class="btn btn-danger">CANCELAR</a>
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

@endsection