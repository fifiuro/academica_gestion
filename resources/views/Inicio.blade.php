@extends('plantilla.master')

@section('menu')
    @include('menus.adm')
@endsection

@section('tituloPag')
     CURSOS DE CRONOGRAMA MENSUAL
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')
    <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Inicio</th>
                        <th>Horario</th>
                        <th>Interesador</th>
                    </tr>
                </thead>
                <tbody>
                    {{ listadoCursos(\App\Helpers\Helper::cursos()) }}
                </tbody>
                <tfoot>
                    <tr>
                        <th>Curso</th>
                        <th>Inicio</th>
                        <th>Horario</th>
                        <th>Interesados</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('extra')
        $(function () {
          $("#example1").DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
          });
        });
@endsection