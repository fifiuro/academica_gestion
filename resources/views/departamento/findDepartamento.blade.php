@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR DEPARTAMENTO
@endsection

@section('subtituloPag')
  COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findDepartamento') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="exampleInputEmail1">Nombre Departamento:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre Departamento" type="text">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createDepartamento') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($depto))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Nombre</th>
              <th>sigla</th>
              <th>Acciones</th>
            </tr>
            @foreach($depto as $key => $d)
            <tr>
              <td>{{ $d->nombre }}</td>
              <td>{{ $d->sigla }}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editDepartamento/'.$d->id_dep) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmDepartamento/'.$d->id_dep) }}" class="btn btn-danger">
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