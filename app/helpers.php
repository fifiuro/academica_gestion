<?php
/* Cambiar el fomato de la fecha para guardar a la Base de Datos */
function formatoFecha($fo){
    if($fo != ""){
        $fv = explode("/",$fo);

        $fm = $fv[2]."-".$fv[1]."-".$fv[0];
    }else{
        $fm = "";
    }

    return $fm;
}
/* Cambiar el formato de la fecha para mostrar en pantalla */
function formatoFechaReporte($fo){
    if($fo != ""){
        $fv = explode("-",$fo);

        $fm = $fv[2]."/".$fv[1]."/".$fv[0];
    }else{
        $fm = "";
    }

    return $fm;
}
/* Mostrar días de la semana */
function dias($d){
    $dias = array("","Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $d = explode(",",$d);
    $j = 0;
    $m = "";

    for($i=0; $i<count($dias); $i++){
        if($i == $d[$j]){
            $m .= $dias[$i];

            if($j < (count($d)-1)){
                $j = $j + 1;
                $m .= ",";
            }
        }
    }

    return $m;
}
/* Array del Mes */
function mes(){
    $n = array("0","1","2","3","4","5","6","7","8","9","10","11","12");
    $m = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $f = getdate();
    $mes = array();
    $cont = 1;

    while($cont != 3){
        if($cont == 1){
            $num = $f['mon'];
            array_push($mes,array("id" => $n[$num], "mes" => $m[$num]));
        }else{
            $num = $f['mon'] + 1;
            array_push($mes,array("id" => $n[$num], "mes" => $m[$num]));
        }
        $cont = $cont + 1;
    }

    return $mes;
}
/* Array del Anio */
function anio(){
    $f = getdate();
    $anio = array();

    array_push($anio, $f['year']);

    return $anio;
}