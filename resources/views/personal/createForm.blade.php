@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    NUEVO PERSONAL
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storePersonal') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre *:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellidos *:</label>
                    <input class="form-control" name="ape" id="ape" placeholder="Apellidos" type="text" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Carnet de Identidad:</label>
                    <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Exsperido en:</label>
                    <select class="form-control" name="dep" id="dep">
                        @foreach ($depto as $ke => $d)
                            <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Teléfono de Domicilio:</label>
                    <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text">
                </div>
                <div class="form-group">
                        <label for="exampleInputEmail1">Teléfono de Oficina:</label>
                        <input class="form-control" name="to" id="to" placeholder="Teléfono" type="text">
                    </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Número de Celular *:</label>
                    <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email *:</label>
                    <input class="form-control" name="email" id="email" placeholder="Email" type="text" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Cargo *:</label>
                    <select class="form-control" name="car" id="car" required>
                        @foreach ($cargo as $ke => $c)
                            <option value="{{ $c->id_ca }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
    else{
        $('#guardar').on('click', function(){
            $(this).attr('disabled',true);
        });
    }
});
@endsection