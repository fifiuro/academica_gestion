@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    MODIFICAR INSTRUCTOR
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateInstructor') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            @foreach ($ins as $key => $i)
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="nom">Nombre *:</label>
                        <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" value="{{ $i->nombre }}" required>
                        <input name="id_pe" id="id_pe" value="{{ $i->id_pe }}" type="hidden">
                        <input name="id_ins" id="id_ins" value="{{ $i->id_ins }}" type="hidden">
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="ape">Apellidos *:</label>
                        <input class="form-control" name="ape" id="ape" placeholder="Apellidos" type="text" value="{{ $i->apellidos }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8 col-sm-8">
                        <label for="ci">Carnet de Identidad:</label>
                        <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text" value="{{ $i->ci }}">
                    </div>
                    <div class="form-group col-md-4 col-sm-4">
                        <label for="dep">Exsperido en:</label>
                        <select class="form-control" name="dep" id="dep">
                            @foreach ($depto as $ke => $d)
                                @if ($i->expedido == $d->id_dep)
                                    <option value="{{ $d->id_dep }}" selected>{{ $d->nombre }}</option>
                                @else
                                    <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="td">Teléfono de Domicilio:</label>
                        <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text" value="{{ $i->tel_dom }}">
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                            <label for="to">Teléfono de Oficina:</label>
                            <input class="form-control" name="to" id="to" placeholder="Teléfono" type="text" value="{{ $i->tel_of }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="cel">Número de Celular *:</label>
                        <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" required value="{{ $i->celular }}">
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="email">Email *:</label>
                        <input class="form-control" name="email" id="email" placeholder="Email" type="text" value="{{ $i->email }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="espe">Especialidad *:</label>
                    <select multiple name="espe[]" id="espe" class="form-control select2" data-placeholder="Seleccione Curso">
                        <option></option>
                        @foreach($espe as $key => $cu)
                            @if($cu->id_ins != null)
                                <option value="{{ $cu->id_cu }}" selected>{{ $cu->nombre }}</option>
                            @else
                                <option value="{{ $cu->id_cu }}">{{ $cu->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="obs">Observaciones:</label>
                    <textarea class="form-control" name="obs" id="obs" cols="30" rows="2">{{ $i->obs }}</textarea>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>CV Original Actual:</label> {{ $i->cvc }}
                        <input type="hidden" name="cvc" value="{{ $i->cvc }}">
                    </div>
                    <div class="col-md-6">
                        <label>Reemplazar por:</label>
                        <input type="file" name="cv[]">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>CV Modificado Actual:</label> {{ $i->cvm }}
                        <input type="hidden" name="cvm" value="{{ $i->cvm }}">
                    </div>
                    <div class="col-md-6">
                        <label>Reemplazar por:</label>
                        <input type="file" name="cv[]">
                    </div>
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
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