@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR CRONOGRAMA
@endsection

@section('subtituloPag')
  COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findCronograma') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-2">
            <label for="cod">Código:</label>
            <input class="form-control" id="cod" name="cod" placeholder="Código" type="text" autocomplete="off">
        </div>
        <div class="col-xs-4">
            <label for="nom">Nombre Curso:</label>
            <input class="form-control" id="nom" name="nom" placeholder="Nombre Curso" type="text" autocomplete="off">
        </div>
        <div class="col-xs-2">
            <label for="mes">Mes:</label>
            <select name="mes" id="mes" class="form-control" required>
                <option value="" selected></option>
                @for ($i=0; $i<13; $i++)
                  @if (array_key_exists($i,$mes))
                      <option value="{{ $i }}">{{ $mes[$i] }}</option>
                  @endif
                @endfor
            </select>
        </div>
        <div class="col-xs-2">
            <label for="gestion">Gestión:</label>
            <select name="gestion" id="gestion" class="form-control" required>
                <option value="" selected></option>
                @foreach($anio as $key => $a)
                    <option value="{{ $a }}">{{ $a }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createCronograma') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($cronograma))
    @if($estado)
      <div class="box-footer">
        <table class="table table-striped table-hover">
          <tbody>
            <tr>
              <th>Curso</th>
              <th>Fecha</th>
              <th>Horario</th>
              <th>D&iacute;as</th>
              <th></th>
            </tr>
            @foreach($cronograma as $key => $c)
            <tr>
              <td>
                @if($c->estado == 2)
                  <i class="fa fa-fw fa-star text-yellow"></i>
                @endif
                <a href="https://www.cognos-capacitacion.com/cursos/Cont/{{ $c->codigo }}" target="_blank">{{ $c->codigo }}</a>: {{ $c->nombre }}<br>
                <strong>Duraci&oacute;n</strong>: {{ $c->duracion }}
              </td>
              <td>{{ formatoFechaReporte($c->f_inicio) }} - {{ formatoFechaReporte($c->f_fin) }}</td>
              <td>{{ horarios($c->horarios) }}</td>
              <td>{{ dias($c->dias) }}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editCronograma/'.$c->id_cr) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmCronograma/'.$c->id_cr) }}" class="btn btn-danger">
                  <i class="glyphicon glyphicon-trash"></i>
                </a>
                {{-- Boton Inicar Curso --}}
                @if ($c->estado == 1)
                  <a href="{{ url('createInicio/'.$c->id_cr) }}" class="btn btn-success">
                    <i class="fa fa-check"></i>
                  </a>
                @endif
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

$('#form select').on('change invalid', function() {
  var campotexto = $(this).get(0);

  campotexto.setCustomValidity('');

  if (!campotexto.validity.valid) {
    campotexto.setCustomValidity('Seleccione un Item de la lista.');  
  }
});
@endsection