@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR INICIO
@endsection

@section('subtituloPag')
  COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findInicio') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-2">
            <label for="cod">Código:</label>
            <input class="form-control" id="cod" name="cod" placeholder="Código" type="text" autocomplete="off">
        </div>
        <div class="col-xs-5">
            <label for="nom">Nombre Curso:</label>
            <input class="form-control" id="nom" name="nom" placeholder="Nombre Curso" type="text" autocomplete="off">
        </div>
        <div class="col-xs-2">
            <label for="mes">Mes:</label>
            <select name="mes" id="mes" class="form-control" required>
                <option value="" selected></option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>
        <div class="col-xs-2">
            <label for="gestion">Gestión:</label>
            <select name="gestion" id="gestion" class="form-control" required>
                <option value="" selected></option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
            </select>
        </div>
        <div class="col-xs-1">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
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
              <th>Instructor</th>
              <th></th>
            </tr>
            @foreach($cronograma as $key => $c)
            <tr>
              <td>
                <a href="https://www.cognos-capacitacion.com/cursos/Cont/{{ $c->codigo }}" target="_blank">{{ $c->codigo }}</a>: {{ $c->nombre }}<br>
                <strong>Duraci&oacute;n</strong>: {{ $c->duracion }}</td>
              <td>{{ formatoFechaReporte($c->f_inicio) }} - {{ formatoFechaReporte($c->f_fin) }}</td>
              <td>{{ $c->horarios }}</td>
              <td>{{ dias($c->dias) }}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editInicio/'.$c->id_cr) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmInicio/'.$c->id_cr) }}" class="btn btn-danger">
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

$('#form select').on('change invalid', function() {
  var campotexto = $(this).get(0);

  campotexto.setCustomValidity('');

  if (!campotexto.validity.valid) {
    campotexto.setCustomValidity('Seleccione un Item de la lista.');  
  }
});
@endsection