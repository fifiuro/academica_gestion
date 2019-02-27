@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR INTERES
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findInteres') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-4">
          <label for="nom">Nombre completo:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre o apellidos" type="text">
        </div>
        <div class="col-xs-4">
          <label for="celular">Celular:</label>
          <input class="form-control" id="celular" name="celular" placeholder="Número de Celular" type="text">
        </div>
        <div class="col-xs-4">
          <label for="email">E-mail:</label>
          <input class="form-control" id="email" name="email" placeholder="E-mail" type="text">
        </div>
        <div class="col-xs-4">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createInteres') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($interes))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Nombre</th>
              <th>Curso Interes</th>
              <th>Acciones</th>
            </tr>
            @foreach($interes as $key => $i)
            <tr>
              <td>{{ $i->nombre }} {{ $i->apellidos }}</td>
              <td>{!! $i->curso !!}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editInteres/'.$i->id_pe) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('allDestroyInteres/'.$i->id_pe) }}" class="btn btn-danger">
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