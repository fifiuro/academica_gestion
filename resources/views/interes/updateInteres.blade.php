@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag')
    MODIFICANDO INTERES
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
        <form name="form" id="form" role="form" method="POST" action="{{ url('addInteres') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="nom">Nombre(s):</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre(s)" type="text" value="{{ $persona->nombre }} {{ $persona->apellido }}" disabled>
                    <input type="hidden" name="id_pe" id="id_pe" value="{{ $persona->id_pe }}">
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="email">E-mail:</label>
                        <input type="text" name="email" id="email" placeholder="E-mail" class="form-control" value="{{ $persona->email }}" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="cel">Celular:</label>
                        <input type="text" name="cel" id="cel" class="form-control" placeholder="Celular" value="{{ $persona->celular }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-10">
                        <label>Listadod e Cursos:</label>
                        <select class="form-control select2" style="width: 100%;" name="id_cu" id="id_cu">
                            @foreach($curso as $key => $cu)
                                <option value="{{ $cu->id_cu }}">{{ $cu->codigo }} {{ $cu->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        {{-- Boton Agregar Curso --}}
                        <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-plus"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <table class="table table-striped">
                        <tr>
                            <td colspan="2" class="text-center"><strong>LISTADO DE CURSO DE INTERES</strong></td>
                        </tr>
                        <tr>
                            <td><strong>NOMBRE CURSO</strong></td>
                            <td><strong>ESTADO</strong></td>
                            <td></td>
                        </tr>
                        @foreach($interes as $key => $i)
                        <tr>
                            <td>{{ $i->codigo }}: {{ $i->nombre }}</td>
                            <td>
                                @if($i->estado == 1)
                                    INTERESADO
                                @elseif($i->estado == 2)
                                    INSCRITO
                                @endif
                            </td>
                            <td>
                                {{-- Boton Eliminar --}}
                                <a href="{{ url('confirmInteres/'.$i->id_int.'/'.$i->id_pe) }}" class="btn btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <a href="{{ url('findInteres') }}" class="btn btn-primary">TERMINAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

@endsection

@section('extra')
/* Da funcionalidad a un select a buscar dentro de sus elementos */
$(".select2").select2();

/* Valida campos vacios de campos de tipo texto */
$('#form input[type=text]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida.');  
    }
});
/* Valida lista sin ninguna seleccion, elemento de tipo select */
$('#form select[name=curso]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Seleccione un curso de la lista.');  
    }
});
@endsection