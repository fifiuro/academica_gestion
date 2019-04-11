@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    ASISTENCIA CURSO
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
<div class="col-md-6 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('storeAsistencia') }}">
            {{ csrf_field() }}
            <div class="box-body">
                @foreach ($curso as $key => $c)
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <label for="numero">Nombre Curso:</label>
                            <input type="hidden" name="id_cr" value="{{ $c->id_cr }}" required>
                            {{ $c->codigo }} {{ $c->nombre }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="numero">Duración:</label>
                            {{ $c->duracion }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="numero">Fecha inicio:</label>
                            {{ formatoFechaReporte($c->f_inicio) }}
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="numero">Horario:</label>
                            {{ horarios($c->horarios) }}
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="numero">Días:</label>
                            {{ dias($c->dias) }}
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    <label for="numero">Fecha Asistencia:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control pull-right" id="datepicker" type="text" name="fecha" autocomplete="off" required>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <td><strong>Nombre</strong></td>
                        <td><strong>Asistencia</strong></td>
                        <td><strong>Acciones</strong></td>
                    </thead>
                    @foreach ($inscritos as $key => $i)
                        <tr>
                            <td>
                                {{ $i->nombre }} {{ $i->apellidos }}
                                <input type="hidden" name="id_ins[]" value="{{ $i->id_alu }}" required>
                            </td>
                            <td>
                                <select name="tipo[]" id="tipo" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Presente</option>
                                    <option value="2">Falta</option>
                                    <option value="3">Permiso</option>
                                    <option value="4">Abandono</option>
                                </select>
                            </td>
                            <td>
                                {{-- Boton Editar --}}
                                <a href="{{ url('editAsistencia/'.$i->id_cr.'/'.$i->id_ins) }}" class="btn btn-warning">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                {{-- Boton Eliminar --}}
                                <a href="{{ url('confirmAsistencia/'.$i->id_cr.'/'.$i->id_ins) }}" class="btn btn-danger">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">GUARDAR ASISTENCIA</button>
                <a href="{{ url('findCronograma') }}" class="btn btn-danger">CANCELAR</a>
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

$('#datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
});
@endsection