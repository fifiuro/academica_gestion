@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    MODIFICAR ALUMNO
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
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updateAlumno') }}">
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
                            @foreach ($referencia as $key => $r)
                                <div class="form-group">
                                    <label for="nombre_r">Nombre:</label>
                                    <input class="form-control" name="nombre_r" id="nombre_r" placeholder="Nombre" type="text" value="{{ $r->nombre }}" required>
                                    <input type="hidden" name="id_ref" value="{{ $r->id_ref }}">
                                </div>
                                <div class="form-group">
                                    <label for="apellidos_r">Apellidos:</label>
                                    <input class="form-control" name="apellidos_r" id="apellidos_r" placeholder="Apellidos" type="text" value="{{ $r->apellidos }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono_r">Teléfono:</label>
                                    <input class="form-control" name="telefono_r" id="telefono_r" placeholder="Teléfono" type="text" value="{{ $r->telefono }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="celular_r">Celular:</label>
                                    <input class="form-control" name="celular_r" id="celular_r" placeholder="Celular" type="text" value="{{ $r->celular }}" required>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                        </div>
                        <div class="chart tab-pane" id="info-trabajo" style="position: relative;">
                            @foreach ($trabajo as $key => $t)
                                <div class="form-group">
                                    <label for="id_em">Empresa:</label>
                                    <select name="id_em" id="id_em" class="form-control" required>
                                        <option value=""></option>
                                        @foreach ($emp as $key => $e)
                                            @if($t->id_em == $e->id_em)
                                                <option value="{{ $e->id_em }}" selected>{{ $e->razon_social }}</option>
                                            @else
                                                <option value="{{ $e->id_em }}">{{ $e->razon_social }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id_tra" value="{{ $t->id_tra }}">
                                </div>
                                <div class="form-group">
                                    <label for="direccion_t">Dirección Empresa:</label>
                                    <input class="form-control" name="direccion_t" id="direccion_t" placeholder="Dirección Empresa" type="text" value="{{ $t->direccion }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono_t">Teléfono Empresa:</label>
                                    <input class="form-control" name="telefono_t" id="telefono_t" placeholder="Teléfono Empresa" type="text" value="{{ $t->telefono }}" required>
                                </div>
                            @endforeach
                        </div>
                        <div class="chart tab-pane active" id="datos-personales" style="position: relative;">
                            <div class="form-group">
                                <label for="nombre_p">Nombre de Alumno:</label>
                                <input class="form-control" name="nombre_p" id="nombre_p" placeholder="Nombre Alumno" type="text" value="{{ $persona->nombre }}" required>
                                <input type="hidden" name="id_pe" value="{{ $persona->id_pe }}">
                            </div>
                            <div class="form-group">
                                <label for="apellidos_p">Apellidos:</label>
                                <input type="text" name="apellidos_p" id="apellidos_p" placeholder="Apellidos Alumno" class="form-control" value="{{ $persona->apellidos }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ci_p">Carnet de Identidad:</label>
                                <input type="text" name="ci_p" id="ci_p" placeholder="Carnet de Identidad" class="form-control" value="{{ $persona->ci }}" required>
                            </div>
                            <div class="form-group">
                                <label for="expedido_p">Expedido:</label>
                                <select name="expedido_p" id="expedido_p" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($dep as $key => $d)
                                        @if($persona->expedido == $d->id_dep)
                                            <option value="{{ $d->id_dep }}" selected>{{ $d->nombre }}</option>
                                        @else
                                            <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="teldom_p">Teléfono de Domicilio:</label>
                                <input type="text" name="teldom_p" id="teldom_p" placeholder="Teléfono Domicilio" class="form-control" value="{{ $persona->tel_dom }}" required>
                            </div>
                            <div class="form-group">
                                <label for="celular_p">Celular:</label>
                                <input type="text" name="celular_p" id="celular_p" placeholder="Celular" class="form-control" value="{{ $persona->celular }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email_p">Correo Electrónico:</label>
                                <input type="text" name="email_p" id="email_p" placeholder="Correo Electrónico" class="form-control" value="{{ $persona->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dir_dom_p">Dirección de Domicilio:</label>
                                <textarea name="dir_dom_p" id="dir_dom_p" cols="30" rows="5" class="form-control">{{ $persona->dir_dom }}</textarea>
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