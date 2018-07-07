@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    NUEVO INSTRUCTOR
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInstructor') }}" enctype="multipart/form-data"
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre *:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" required>
                </div>
                <div class="form-group">
                    <label for="ape">Apellidos *:</label>
                    <input class="form-control" name="ape" id="ape" placeholder="Apellidos" type="text" required>
                </div>
                <div class="form-group">
                    <label for="ci">Carnet de Identidad:</label>
                    <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text">
                </div>
                <div class="form-group">
                    <label for="dep">Exsperido en:</label>
                    <select class="form-control" name="dep" id="dep">
                        @foreach ($depto as $ke => $d)
                            <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="td">Teléfono de Domicilio:</label>
                    <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text">
                </div>
                <div class="form-group">
                        <label for="to">Teléfono de Oficina:</label>
                        <input class="form-control" name="to" id="to" placeholder="Teléfono" type="text">
                    </div>
                <div class="form-group">
                    <label for="cel">Número de Celular *:</label>
                    <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *:</label>
                    <input class="form-control" name="email" id="email" placeholder="Email" type="text" required>
                </div>
                <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea class="form-control" name="obs" id="obs" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="obs">Hoja de Vida Original:</label>
                    <input class="form-control" type="file" name="cvc" id="cvc">
                </div>
                <div class="form-group">
                    <label for="obs">Hoja de Vida Modificado:</label>
                    <input class="form-control" type="file" name="cvm" id="cvm">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                <a href="{{ url('findInstructor') }}" class="btn btn-danger">CANCELAR</a>
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