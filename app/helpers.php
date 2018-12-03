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
    $m = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $f = date("m");
    $ver = array();

    for($i=0; $i<count($m); $i++)
    {
        if($i >= ($f+0))
        {
            $ver = array_add($ver,$i,$m[$i]); 
        }
    }

    return $ver;
}
/* Array del Anio */
function anio(){
    $f = getdate(); 
    $anio = array();

    array_push($anio, $f['year']);

    return $anio;
}