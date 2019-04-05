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

{{ mallaCurso($malla) }}

@endsection

@section('extra')

$("#asignacion").on("click", function(){
    /*-var ndias = [ '','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo' ];
    var dia = $("#dias").val();
    var d = "";
    var nd = "";
    var hd = "";
    var coin = 0;
    for(var i=1; i<ndias.length; i++){
        if(dia.includes(i.toString())){
            if(coin == 0){
                nd = nd + i;
                hd = hd + $("#horaInicio").val() + "-" + $("#horaFin").val();
                d = d + ndias[i];
                coin = coin + 1;
            }else{
                nd = nd + "," + i;
                d = d + ", " + ndias[i];
                hd = hd + "," + $("#horaInicio").val() + "-" + $("#horaFin").val();
            }
        }
    }*/
    $("#0700").append('<td rowspan="5" style="background-color: yellow; color: #000000;">hola</td>');

    /*$("#myModal").modal('hide');
    
    $("#ventanaDias").show(1000);
    $("#ventanaDis").show(1000);
    $("#ventanaObs").show(1000);*/
});

@endsection