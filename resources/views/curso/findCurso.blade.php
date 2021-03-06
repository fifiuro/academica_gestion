@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR CURSO
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findCurso') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="exampleInputEmail1">Nombre de Curso:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre" type="text" required>
          <input type="hidden" name="curso" id="curso" value="true">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createCurso') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($curso))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Código</th>
              <th>Nombre Curso</th>
              <th>Duración</th>
              <th>Precio</th>
              <th>Categoria</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
            @foreach($curso as $key => $c)
            <tr>
              <td>{{ $c->codigo }}</td>
              <td>{{ $c->nombre }}</td>
              <td>{{ $c->duracion }}</td>
              <td>{{ $c->precio }}</td>
              <td>{{ $c->categoria }}</td>
              <td>
                @if ($c->estado == 1)
                  <i class="glyphicon glyphicon-ok btn-lg" style="color:green;"></i>
                @else
                  <i class="glyphicon glyphicon-remove" style="color:red;"></i>  
                @endif
              </td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editCurso/'.$c->id_cu) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmCurso/'.$c->id_cu) }}" class="btn btn-danger">
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
      campotexto.setCustomValidity('Introduzca el texto a buscar');  
    }
});
@endsection