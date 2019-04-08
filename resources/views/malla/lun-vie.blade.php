@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  MALLA DE LUNES A VIERNES
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')

{{ mallaCurso($malla, $iniciar) }}

@endsection

@section('extra')

@endsection