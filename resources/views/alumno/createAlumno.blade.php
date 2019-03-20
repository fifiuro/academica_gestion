@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    NUEVO ALUMNO
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

<div class="col-md-3"></div>
<div class="col-md-12 col-sm-12 col-12">
    <div class="box">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeAlumno') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <!-- Tabs con informacion de Alumno -->
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#ref-personal" data-toggle="tab"><strong>Referencias Personales</strong></a></li>
                        <li><a href="#info-trabajo" data-toggle="tab"><strong>Información de Trabajo</strong></a></li>
                        <li class="active"><a href="#datos-personales" data-toggle="tab"><strong>Datos Personales</strong></a></li>
        
                        <li class="pull-left header"><i class="fa fa-inbox"></i></li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="chart tab-pane" id="ref-personal" style="position: relative;">
                            <div class="form-group">
                                <label for="nombre_r">Nombre:</label>
                                <input class="form-control" name="nombre_r" id="nombre_r" placeholder="Nombre" type="text" value="{{ old('nombre_r') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos_r">Apellidos:</label>
                                <input class="form-control" name="apellidos_r" id="apellidos_r" placeholder="Apellidos" type="text" value="{{ old('apellidos_r') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono_r">Teléfono:</label>
                                <input class="form-control" name="telefono_r" id="telefono_r" placeholder="Teléfono" type="text" value="{{ old('telefono_r') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="celular_r">Celular:</label>
                                <input class="form-control" name="celular_r" id="celular_r" placeholder="Celular" type="text" value="{{ old('celular_r') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR</button>
                        </div>
                        <div class="chart tab-pane" id="info-trabajo" style="position: relative;">
                            <div class="form-group">
                                <label for="id_em">Empresa:</label>
                                <select name="id_em" id="id_em" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($emp as $key => $e)
                                        <option value="{{ $e->id_em }}">{{ $e->razon_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="direccion_t">Dirección Empresa:</label>
                                <textarea name="direccion_t" id="direccion_t" cols="30" rows="3" class="form-control" required>{{ old('direccion_t') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="telefono_t">Teléfono Empresa:</label>
                                <input class="form-control" name="telefono_t" id="telefono_t" placeholder="Teléfono Empresa" type="text" value="{{ old('telefono_t') }}" required>
                            </div>
                        </div>
                        <div class="chart tab-pane active" id="datos-personales" style="position: relative;">
                            <div class="form-group">
                                <label for="nombre_p">Nombre de Alumno:</label>
                                <input class="form-control" name="nombre_p" id="nombre_p" placeholder="Nombre Alumno" type="text" value="{{ old('nombre_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos_p">Apellidos:</label>
                                <input type="text" name="apellidos_p" id="apellidos_p" placeholder="Apellidos Alumno" class="form-control" value="{{ old('apellidos_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ci_p">Carnet de Identidad:</label>
                                <input type="text" name="ci_p" id="ci_p" placeholder="Carnet de Identidad" class="form-control" value="{{ old('ci_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="expedido_p">Expedido:</label>
                                <select name="expedido_p" id="expedido_p" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($dep as $key => $d)
                                        <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="teldom_p">Teléfono de Domicilio:</label>
                                <input type="text" name="teldom_p" id="teldom_p" placeholder="Teléfono Domicilio" class="form-control" value="{{ old('teldom_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="celular_p">Celular:</label>
                                <input type="text" name="celular_p" id="celular_p" placeholder="Celular" class="form-control" value="{{ old('celular_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email_p">Correo Electrónico:</label>
                                <input type="text" name="email_p" id="email_p" placeholder="Correo Electrónico" class="form-control" value="{{ old('email_p') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dir_dom_p">Dirección de Domicilio:</label>
                                <textarea name="dir_dom_p" id="dir_dom_p" cols="30" rows="2" class="form-control">{{ old('dir_dom_p') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <a href="{{ url('findAlumno') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

@endsection

@section('extra')
$('#form input[type=number]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida, por favor ingrese un número.');  
    }
});

$('#form select').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Seleccione un elemento de la lista.');  
    }
});
@endsection