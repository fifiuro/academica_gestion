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
    $dias = array("","Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
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

/* Esta funcion no se utiliza */
function diasMod($fi,$ff,$d,$h,$t=''){
    $dias = array('','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
    $d = explode(',',$d);
    $h = explode(',',$h);
    $j = 0;
    $m = '';
    $n = '';
    $r = '';
    $s = '';
    $todo = array();
    $ant = '';
    $md1 = '';
    $mh1 = '';
    $md2 = '';
    $mh2 = '';

    for($i=0; $i<count($dias); $i++) {
        if($i == $d[$j]){
            switch ($i) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    $m .= $dias[$i];
                    $md1 .= $i;
                    $mh1 .= $h[$j];
                    if($ant != $h[$j]){
                        $n .= $h[$j];
                        $ant = $h[$j];
                    }
        
                    if($j < (count($d)-1)){
                        $j = $j + 1;
                        $m .= ',';
                        //$n .= ',';
                        $md1 .= ',';
                        $mh1 .= ',';
                    }
                    break;
                case 6:
                case 7:
                    $r .= $dias[$i];
                    $md2 .= $i;
                    if($ant != $h[$j]){
                        $s .= $h[$j];
                        $ant = $h[$j];
                        $mh2 .= $h[$j];
                    }

                    if($j < (count($d)-1)){
                        $j = $j + 1;
                        $r .= ',';
                        $s .= ',';
                        $md2 .= ',';
                        $mh2 .= ',';
                    }
                    break;
            }
            
        }
    }

    if($m != '' and $n != '')
    {
        if($t == 'i')
        {
            array_push($todo, '<tr><td>'.formatoFechaReporte($fi).' - '.formatoFechaReporte($ff).'<input type="hidden" name="f[]" value="'.formatoFechaReporte($fi).'-'.formatoFechaReporte($ff).'"></td><td>'.trim($m,',').'<input type="hidden" name="d[]" value="'.trim($md1,',').'"></td><td>'.trim($n,',').'<input type="hidden" name="h[]" value="'.trim($mh1,',').'"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');
        }else{
            array_push($todo, '<tr><td>'.formatoFechaReporte($fi).' - '.formatoFechaReporte($ff).'<input type="hidden" name="f[]" value="'.formatoFechaReporte($fi).' - '.formatoFechaReporte($ff).'"></td><td>'.trim($m,',').'<input type="hidden" name="d[]" value="'.trim($md1,',').'"></td><td>'.trim($n,',').'<input type="hidden" name="h[]" value="'.trim($mh1,',').'"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');
        }
    }
    if($r != '' and $s != '')
    {
        if($t == 'i')
        {
            array_push($todo, '<tr><td>'.formatoFechaReporte($fi).' - '.formatoFechaReporte($ff).'<input type="hidden" name="f[]" value="'.formatoFechaReporte($fi).'-'.formatoFechaReporte($ff).'"></td><td>'.trim($r,',').'<input type="hidden" name="d[]" value="'.trim($md2,',').'"></td><td>'.trim($s,',').'<input type="hidden" name="h[]" value="'.trim($mh2,',').'"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');
        }else{
            array_push($todo, '<tr><td>'.formatoFechaReporte($fi).' - '.formatoFechaReporte($ff).'<input type="hidden" name="f[]" value="'.formatoFechaReporte($fi).'-'.formatoFechaReporte($ff).'"></td><td>'.trim($r,',').'<input type="hidden" name="d[]" value="'.trim($md2,',').'"></td><td>'.trim($s,',').'<input type="hidden" name="h[]" value="'.trim($mh2,',').'"></td><td><button type="button" class="btn btn-danger" id="eliminar">ELIMINAR</button></td></tr>');
        }
    }

    return $todo;
}

function horarios($h){
    $h = explode(',',$h);
    $ant = '';
    $t = '';

    for($i=0; $i<count($h); $i++){
        if($ant != $h[$i]){
            $t .= $h[$i].",";
            $ant = $h[$i];
        }
    }

    return $t;
}
/* Array del Mes */
function mes(){
    $m = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $f = date("m");
    $ver = array();

    for($i=0; $i<count($m); $i++)
    {
        //if($i >= ($f+0))
        //{
            $ver = array_add($ver,$i,$m[$i]); 
        //}
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

    while($duracion >= 0){
        $formateado = date('Y-m-j',$fecha);
        if(in_array($formateado,$fer)){

        }else{
            $buscar = date('N',$fecha);
            $clave = array_search($buscar,$dias);
            if($clave !== false){
                $duracion = $duracion - numeroHorasDia($horas, $clave);
            }
        }

        if($duracion <= 0){
            
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

/** Listaod de cursos para Inscripciones */
function listadoCursos($curso){
    $actual = '';
    $count = 1;
    $show = '';

    foreach($curso as $key => $c){
        switch ($count) {
            case '1':
                $actual = $c->id_cr;
                $count = $count + 1;
                $show = '<tr>';
                $show .= '<td><strong>'.$c->codigo.'</strong>: '.$c->nombre .'<br>';
                if ($c->dur_cro != 0){
                    $show .= '<strong>Duración:</strong> '.$c->dur_cro;
                }else{
                    $show .= '<strong>Duración:</strong> '.$c->dur_cur;
                }
                $show .= '</td>';
                $show .= '<td>'.formatoFechaReporte($c->f_inicio).'</td>';
                $show .= '<td>'.dias($c->dias).' '.horarios($c->horarios);
                break;
            
            default:
                if($actual == $c->id_cr){
                    $show .= '<br>'.dias($c->dias).' '.horarios($c->horarios);
                }else{
                    $show .= '</td>';
                    $show .= '<td>'.$c->total.'</td>';
                    $show .= '</tr>';
                    $actual = $c->id_cr;

                    $show .= '<tr>';
                    $show .= '<td><strong>'.$c->codigo.'</strong>: '.$c->nombre .'<br>';
                    if ($c->dur_cro != 0){
                        $show .= '<strong>Duración:</strong> '.$c->dur_cro;
                    }else{
                        $show .= '<strong>Duración:</strong> '.$c->dur_cur;
                    }
                    $show .= '</td>';
                    $show .= '<td>'.formatoFechaReporte($c->f_inicio).'</td>';
                    $show .= '<td>'.dias($c->dias).' '.horarios($c->horarios);
                }
                break;
        }

        if($c === end($curso)){
            $show .= '</td>';
            $show .= '<td>'.$c->total.'</td>';
            $show .= '</tr>';
        }
    }
    echo $show;
}

/** MALLA DE CURSOS */
function mallaCurso($malla,$iniciar){
    $hora = array('','07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','07:00','00:00');

    $inicio = '<table class="table table-striped table-bordered">
                <tbody>
                    <th>
                        <td>Aula 1</td>
                        <td>Aula 2</td>
                        <td>Aula 3</td>
                        <td>Aula 4</td>
                        <td>Aula 5</td>
                        <td>Aula 6</td>
                        <td>Aula 7</td>
                        <td>Aula 8</td>
                        <td>Aula 9</td>
                    </th>';
    echo $inicio;

    for($i=1; $i<37; $i++){
        echo '<tr>';
        for($j=0; $j<=9; $j++){
            if($hora[$i] >=$iniciar->hora){
                if($j == 0){
                    echo '<td>'.$hora[$i].'</td>'; // Se muestra la hora correlativa
                }else{
                    switch ($j) {
                        case '1':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '2':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '3':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '4':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '5':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '6':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '7':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '8':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                        case '9':
                            echo buscar($malla,$hora[$i],$j);
                            break;
                    }
                }
            }
        }
        echo '</tr>';
    }

    $fin = '</tbody>
    </table>';
    echo $fin;
}

function buscar($malla,$hora,$j){
    $curso = '';
    $vacio = '<td></td>';
    foreach($malla as $key => $m){
        if($hora == $m->horario_i and $j == $m->numero){
            $curso = '<td rowspan="'.((numeroHorasDia(array($m->horario_i."-".$m->horario_f),0) * 2) + 1).'" style="background: #357dbb; color: white;"><strong>'.$m->nom_corto.'</strong><br>'.$m->horario_i.' '.$m->horario_f.'<br>'.formatoFechaReporte($m->f_inicio).' - '.formatoFechaReporte($m->f_fin).'<br>'.dias($m->dias).'<br>'.$m->instructor.' '.$m->duracion.'<td>';
        }else{
            if($m->horario_i <= $hora and $m->horario_f >= $hora){
                $vacio = '';
            }else{
                $vacio = '<td></td>';
            }
        }
    }
    if($curso != ''){
        return $curso;
    }else{
        return $vacio;
    }
}