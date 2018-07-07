@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  MODIFICAR DEPARTAMENTO
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateDepartamento') }}">
            {{ csrf_field() }}
            @foreach ($depto as $key => $d)
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre departamento:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre Departamento" type="text" value="{{ $d->nombre }}" required>
                    <input type="hidden" name="id" id="id" value="{{ $d->id_dep }}">
                </div>
                <div class="form-group">
                    <label for="sig">Sigla:</label>
                    <input class="form-control" name="sig" id="sig" placeholder="sigla" type="text" value="{{ $d->sigla }}" required>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                <a href="{{ url('findDepartamento') }}" class="btn btn-danger">CANCELAR</a>
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
    else
    {
        $('#guardar').on('click', function(){
            $(this).attr('disabled',true);
        });
    }
});
@endsection