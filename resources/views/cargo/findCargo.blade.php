@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR CARGO
@endsection

@section('subtituloPag')
  
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findCargo') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="exampleInputEmail1">Nombre del Cargo a buscar:</label>
          <input class="form-control" id="cargo" name="cargo" placeholder="Cargo" type="text">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createCargo') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($lista))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Num.</th>
              <th>Nombre Cargo</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
            @foreach($lista as $key => $cargo)
            <tr>
              <td>{{ $cargo->id_ca }}</td>
              <td>{{ $cargo->nombre }}</td>
              <td>
                @if ($cargo->estado)
                  <i class="glyphicon glyphicon-ok btn-lg" style="color:green;"></i>
                @else
                  <i class="glyphicon glyphicon-remove" style="color:red;"></i>  
                @endif
              </td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('updateCargo/'.$cargo->id_ca) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('deleteCargo/'.$cargo->id_ca) }}" class="btn btn-danger">
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