@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  BUSCAR INSTRUCTOR
@endsection

@section('subtituloPag')
  COGNOS
@endsection

@section('contenido')
@notification()
<div class="box box-primary">
  <div class="box-body">
    <form class="form-horizontal" name="form" id="form" role="form" method="POST" action="{{ url('findInstructor') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-10">
          <label for="nom">Nombre o Apellido a buscar:</label>
          <input class="form-control" id="nom" name="nom" placeholder="Nombre o Apellido" type="text">
          <input type="hidden" name="instructor" id="instructor" value="true">
        </div>
        <div class="col-xs-2">
          {{-- Boton Buscar --}}
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
          {{-- Boton Nuevo --}}
          <a href="{{ url('createInstructor') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>
    </form>
  </div>
  @if(isset($instructor))
    @if($estado)
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <th>Nombre</th>
              <th>ci</th>
              <th>Teléfono Domicilio</th>
              <th>Teléfono Trabajo</th>
              <th>Celular</th>
              <th>Email</th>
              <th>Acciones</th>
            </tr>
            @foreach($instructor as $key => $i)
            <tr>
              <td>{{ $i->nombre }} {{ $i->apellidos }}</td>
              <td>
                @if($i->ci == "")
                  
                @else
                  {{ $i->ci }} {{ $i->sigla }}
                @endif
              </td>
              <td>{{ $i->tel_dom }}</td>
              <td>{{ $i->tel_of }}</td>
              <td>{{ $i->celular }}</td>
              <td>{{ $i->email }}</td>
              <td>
                {{-- Boton Editar --}}
                <a href="{{ url('editInstructor/'.$i->id_pe) }}" class="btn btn-warning">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                {{-- Boton Eliminar --}}
                <a href="{{ url('confirmInstructor/'.$i->id_pe) }}" class="btn btn-danger">
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