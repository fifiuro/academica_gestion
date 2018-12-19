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

    for($i=2014; $i<=$f['year']; $i++)
    {
        array_push($anio, $i);
    }

    return $anio;
}
/** Calcular Fecha de Finalizacion */
function finalizacion($fecha, $dias, $horas, $duracion, $feriado){
    $fer = array();
    foreach($feriado as $key => $f){
        array_push($fer,$f->fecha);
    }

    $fecha = strtotime($fecha);
    $dias = implode(",",$dias);
    $dias = explode(",",$dias);
    $horas = implode(",",$horas);
    $horas = explode(",",$horas);

    while($duracion > 0){
        $formateado = date('Y-m-j',$fecha);
        if(in_array($formateado,$fer)){

        }else{
            $buscar = date('N',$fecha);
            $clave = array_search($buscar,$dias);
            if($clave !== false){
                $duracion = $duracion - numeroHorasDia($horas, $clave);
            }
        }

        if($duracion == 0){
            
        }else{
            $fecha = strtotime('+1 day', $fecha);
        }
    }

    return date('Y-m-j',$fecha);
}

function numeroHorasDia($hora, $clave){
    $hora = explode("-",$hora[$clave]);
    $hi = explode(":",$hora[0]);
    $hf = explode(":",$hora[1]);

    $min = (($hf[0] * 60) + $hf[1]) - (($hi[0] * 60) + $hi[1]);
    $hor = $min / 60;

    return $hor;
}