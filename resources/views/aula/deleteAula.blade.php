@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  ELIMINAR AULA
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
    <div class="box box-danger">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('destroyAula') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="text-center">
                    <h2>¿Está seguro de eleminar el Aula?</h2>
                    <input type="hidden" class="form-control" name="id" id="id" value="{{ $id }}">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="si" id="si">SI</button>
                <a href="{{ url('findAula') }}" class="btn btn-danger">NO</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-3"></div>

@endsection

@section('extra')
@endsection