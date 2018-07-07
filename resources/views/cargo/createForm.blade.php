@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  NUEVO CARGO
@endsection

@section('subtituloPag')
  
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('createCargo') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre Cargo</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre Cargo" type="text" required>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findCargo') }}" class="btn btn-danger">CANCELAR</a>
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
@endsection