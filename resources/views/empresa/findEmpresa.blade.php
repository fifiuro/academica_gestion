@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR EMPRESA
@endsection

@section('subtituloPag')
  
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findEmpresa') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="exampleInputEmail1">Razon Social de la Empresa a buscar:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre" type="text">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createEmpresa') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($empresa))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Razon Social</th>
              <th>Sigla</th>
              <th>NIT</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </tr>
            @foreach($empresa as $key => $e)
            <tr>
              <td>{{ $e->razon_social }}</td>
              <td>{{ $e->sigla }}</td>
              <td>{{ $e->nit }}</td>
              <td>{{ $e->direccion }}</td>
              <td>{{ $e->tel }}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editEmpresa/'.$e->id_em) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmEmpresa/'.$e->id_em) }}" class="btn btn-danger">
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