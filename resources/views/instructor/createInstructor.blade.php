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
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInstructor') }}" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="ci">Carnet de Identidad:</label>
                        <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="dep">Exspedido en:</label>
                        <select class="form-control" name="dep" id="dep">
                            @foreach ($depto as $ke => $d)
                                <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="td">Teléfono de Domicilio:</label>
                        <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text">
                    </div>
                    <div class="form-group col-md-6">
                            <label for="to">Teléfono de Oficina:</label>
                            <input class="form-control" name="to" id="to" placeholder="Teléfono" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cel">Número de Celular *:</label>
                        <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email *:</label>
                        <input class="form-control" name="email" id="email" placeholder="Email" type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cat">Especialidad *:</label>
                    <select class="form-control select2" multiple="multiple" data-placeholder="Seleccione Curso" style="width: 100%;">
                        <option></option>
                        @foreach($curso as $key => $cu)
                            <option value="{{ $cu->id_cu }}">{{ $cu->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea class="form-control" name="obs" id="obs" cols="30" rows="5"></textarea>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cvc">CV Original:</label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="cv[]" id="cvc">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cvm">CV Modificado:</label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="cv[]" id="cvm">
                    </div>
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

$(".select2").select2();
@endsection