@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    NUEVO USUARIO
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
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            @foreach($datos as $key => $d)
            <div class="box-body">
                <div class="form-group">
                    <label for="name">ID *:</label>
                    <input class="form-control" name="id_pe" id="id_pe" placeholder="Nombre" type="text" value="{{ $d->id_pe }}">
                </div>
                <div class="form-group">
                    <label for="name">Nombre *:</label>
                    <input class="form-control" name="name" id="name" placeholder="Nombre" type="text" value="{{ $d->nombre }} {{ $d->apellidos }}">
                </div>
                <div class="form-group">
                    <label for="username">Nombre de usuario *:</label>
                    <input class="form-control" name="username" id="username" placeholder="Nombre de Usuario" type="text" required>
                </div>
                <div class="row">
                        <div class="form-group col-md-8">
                            <label for="email">Correo Electrónico:</label>
                            <input class="form-control" name="email" id="email" placeholder="Correo Electrónico" type="text" value="{{ $d->email }}" required>
                        </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña *:</label>
                        <input class="form-control" name="password" id="password" placeholder="Contraseña" type="text" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password-confirm">Confirmar Contraseña *:</label>
                        <input class="form-control" name="password_confirmation" id="password-confirm" placeholder="Confirmar Contraseña" type="text" required>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findPersonal') }}" class="btn btn-danger">CANCELAR</a>
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
@endsection