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

<div class="col-md-1"></div>
<div class="col-md-10">
    <div class="box">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeInstructor') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <!-- Tabs con informacion de Instructor -->
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#info-trabajo" data-toggle="tab"><strong>Información de Trabajo</strong></a></li>
                        <li class="active"><a href="#datos-personales" data-toggle="tab"><strong>Datos Personales</strong></a></li>
        
                        <li class="pull-left header"><i class="fa fa-inbox"></i></li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="chart tab-pane" id="info-trabajo" style="position: relative;">
                            <div class="form-group">
                                <label for="id_em">Empresa:</label>
                                <select name="id_em" id="id_em" class="form-control">
                                    <option></option>
                                    @foreach($empresa as $key => $em)
                                        <option value="{{ $em->id_em }}">{{ $em->razon_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="direccion_em">Dirección:</label>
                                <textarea name="direccion_em" id="direccion_em" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telefono_em">Teléfono:</label>
                                <input type="text" name="telefono_em" id="telefono_em" class="form-control">
                            </div>
                        </div>
                        <div class="chart tab-pane active" id="datos-personales" style="position: relative;">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="nom">Nombre *:</label>
                                    <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" required>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="ape">Apellidos *:</label>
                                    <input class="form-control" name="ape" id="ape" placeholder="Apellidos" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 col-sm-8">
                                    <label for="ci">Carnet de Identidad:</label>
                                    <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label for="dep">Expedido en:</label>
                                    <select class="form-control" name="dep" id="dep">
                                        @foreach ($depto as $ke => $d)
                                            <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="td">Teléfono de Domicilio:</label>
                                    <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="cel">Número de Celular *:</label>
                                    <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for="email">Email *:</label>
                                    <input class="form-control" name="email" id="email" placeholder="Email" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dir_dom">Dirección Domicilio:</label>
                                <textarea name="dir_dom" id="dir_dom" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="espe">Especialidad *:</label>
                                <select multiple name="espe[]" id="espe" class="form-control select2" data-placeholder="Seleccione Curso" required>
                                    <option></option>
                                    @foreach($curso as $key => $cu)
                                        <option value="{{ $cu->id_cu }}">{{ $cu->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="obs">Observaciones:</label>
                                <textarea class="form-control" name="obs" id="obs" cols="30" rows="2"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="cvc">CV Original:</label>
                                    <input type="file" name="cv[]" id="cvo">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="cvm">CV Modificado:</label>
                                    <input type="file" name="cv[]" id="cvm">
                                </div>
                            </div>
                        </div>
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
<div class=" col-md-1"></div>

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