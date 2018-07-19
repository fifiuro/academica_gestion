<?php
/* Cambiar el fomato de la fecha para guardar a la Base de Datos */
function formatoFecha($fo){
    $fv = explode("/",$fo);

    $fm = $fv[2]."-".$fv[1]."-".$fv[0];

    return $fm;
}
/* Cambiar el formato de la fecha para mostrar en pantalla */
function formatoFechaReporte($fo){
    $fv = explode("-",$fo);

    $fm = $fv[2]."/".$fv[1]."/".$fv[0];

    return $fm;
}