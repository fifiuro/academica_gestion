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
    $dias = array("","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
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
/** Calcular Fecha de Finalizacion */
function finalizacion($fecha, $dias, $duracion, $hi, $hf, $feriado){
    $d =  diasCurso($hi,$hf,$duracion);
    $fer = array();
    foreach($feriado as $key => $f){
        array_push($fer,$f->fecha);
    }

    $fecha = strtotime($fecha);

    while($d > 0){
        $formateado = date('Y-m-j',$fecha);
        if(in_array($formateado,$fer)){

        }else{
            $buscar = date('N',$fecha);
            if(in_array($buscar,$dias)){
                $d = $d - 1;
            }
        }

        if($d == 0){
            
        }else{
            $fecha = strtotime('+1 day', $fecha);
        }
    }

    return date('Y-m-j',$fecha);
}

function diasCurso($hi, $hf, $duracion){
    $f1 = new DateTime($hi);
    $f2 = new DateTime($hf);

    $d = $f1->diff($f2);

    $h = explode(':', $d->format('%H:%I'));
    $min = ($h[0] * 60) + $h[1];
    $hor = $min / 60;

    if($hor > 0){
        $todo = $duracion / $hor;
    }else{
        $todo = 0;
    }

    return $todo;
}