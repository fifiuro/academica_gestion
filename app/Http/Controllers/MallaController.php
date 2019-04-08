<?php

namespace App\Http\Controllers;

use App\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mallaLunesViernes()
    {
        $hoy = "2019-04-08";
        
        $malla = Cronograma::join('curso','curso.id_cu','=','cronograma.id_cu')
                           ->join('horario','horario.id_cr','=','cronograma.id_cr')
                           ->join('inicio_aula','inicio_aula.id_cr','=','cronograma.id_cr')
                           ->join('aula','aula.id_aul','=','inicio_aula.id_aul')
                           ->join('inicio_instructor','cronograma.id_cr','=','inicio_instructor.id_cr')
                           ->join('instructor','inicio_instructor.id_ins','=','instructor.id_ins')
                           ->join('persona','instructor.id_pe','=','persona.id_pe')
                           ->where('cronograma.estado','=','2')
                           ->where('horario.f_fin','>=',$hoy)
                           ->where('horario.estado','=',true)
                           ->whereRaw('dayofweek(?) in (2,3,4,5,6)',$hoy)
                           ->select('cronograma.id_cr',
                                    'curso.id_cu',
                                    'curso.codigo',
                                    'curso.nombre',
                                    'curso.nom_corto',
                                    'aula.numero',
                                    'f_inicio',
                                    'f_fin',
                                    'horario.dias',
                                    DB::raw('concat(persona.nombre," ",persona.apellidos) as instructor'),
                                    DB::raw('if(cronograma.duracion <> 0, cronograma.duracion, curso.duracion) as duracion'))
                            ->selectRaw('substring(horario.horarios,
                                            case (find_in_set(dayofweek(?), horario.dias))
                                                when 1 then 1
                                                when 2 then 13
                                                when 3 then 25
                                                when 4 then 37
                                                when 5 then 49
                                                when 6 then 61
                                                when 7 then 73
                                            end,
                                        5) as horario_i, 
                                        substring(horario.horarios,
                                            case (find_in_set(dayofweek(?), horario.dias))
                                                when 1 then 7
                                                when 2 then 19
                                                when 3 then 31
                                                when 4 then 43
                                                when 5 then 55
                                                when 6 then 67
                                                when 7 then 79
                                            end,
                                        5) as horario_f',[$hoy,$hoy])
                            ->orderBy('horario_i','asc')
                            ->orderBy('aula.numero','asc')
                            ->get();

        $iniciar = Cronograma::join('horario','cronograma.id_cr','=','horario.id_cr')
                             ->where('cronograma.estado','=','2')
                             ->where('horario.estado','=',true)
                             ->where('horario.f_fin','>=',$hoy)
                             ->whereRaw('(find_in_set(dayofweek(?), horario.dias)) > 0',[$hoy])
                             ->selectRaw('substring(horarios,1,5) as hora')
                             ->orderBy('hora','asc')
                             ->first();
        
        return view('malla.lun-vie', array('malla' => $malla, 'iniciar' => $iniciar));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mallaSabados()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mallaSitio(Request $request)
    {
        //
    }

}
