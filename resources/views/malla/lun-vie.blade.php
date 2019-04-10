@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
  MALLA {{ $titulo }}
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')

@if (isset($malla) and isset($iniciar))
  {{ mallaCurso($malla, $iniciar) }}
@else
  <h3 style="color:tomato">No se tiene tiene resultado de Cursos en {{ $titulo }}</h3>
@endif

@endsection

@section('extra')

@endsection