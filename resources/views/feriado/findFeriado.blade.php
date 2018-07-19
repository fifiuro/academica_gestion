@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR FERIADO
@endsection

@section('subtituloPag')
  
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findFeriado') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="exampleInputEmail1">Nombre del Feriado a buscar:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre" type="text">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createFeriado') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($feriado))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Num.</th>
              <th>Nombre Cargo</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
            @foreach($feriado as $key => $f)
            <tr>
              <td>{{ $f->id_fer }}</td>
              <td>{{ $f->nombre }}</td>
              <td>{{ formatoFechaReporte($f->fecha) }}</td>
              <td>
                @if ($f->estado)
                  <i class="glyphicon glyphicon-ok btn-lg" style="color:green;"></i>
                @else
                  <i class="glyphicon glyphicon-remove" style="color:red;"></i>  
                @endif
              </td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editFeriado/'.$f->id_fer) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmFeriado/'.$f->id_fer) }}" class="btn btn-danger">
                  <i class="glyphicon glyphicon-trash"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <h3>
      <p class="text-red" style="text-align:center;">
        {{ $mensaje }}
      </p>
      </h2>
    @endif
  @endif
</div>

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