<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\Curso;
use App\Horario;
use App\Feriado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class CronogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cronograma.findCronograma');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('curso.codigo','like','%'.$request->cod.'%')
                           ->orWhere('curso.nombre','like','%'.$request->nom.'%')
                           ->where('cronograma.mes','=',$request->mes)
                           ->where('cronograma.gestion','=',$request->gestion)
                           ->select("cronograma.id_cr",
                                "curso.codigo",
                                "curso.nombre",
                                "curso.duracion",
                                "horario.f_inicio",
                                "horario.f_fin",
                                "horario.horarios",
                                "horario.dias",
                                "cronograma.estado")
                           ->get();

        if($crono->isEmpty()){
            return view('cronograma.findCronograma', array('cronograma' => '',
                                                           'estado' => false,
                                                           'mensaje' => 'No se tuvieron coincidencias.'));
        }else{
            return view('cronograma.findCronograma', array("cronograma" => $crono, 'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cronograma.createCronograma', array('mes' => mes(), 'anio' => anio()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'mes.required' => 'El Mes de cronograma es necesario.',
            'gestion.required' => 'La Gestion e s necesario.',
            'id_cur.required' => 'No se selecciono ningun curso.',
            'fechaInicio.required' => 'La Fecha de Inicio es necesario.',
            'horaInicio.required' => 'La Hora de Inicio es necesario.',
            'horaFin.required' => 'La Hora de Finalizacion es necesario.',
            'dias.required' => 'Los Dias son necesario.'
        );
        $rules = array (
            'mes' => 'required',
            'gestion' => 'required',
            'id_cur' => 'required',
            'fechaInicio' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'dias' => 'required'
        );

        $this->validate($request, $rules, $messages);
        /* GUARDA DATOS DE CRONOGRAMA */
        $crono = new Cronograma;

        $crono->id_cu = $request->id_cur;
        if(isset($request->pre) & isset($request->dur)){
            $crono->precio = $request->pre;
            $crono->duracion = $request->dur;
        }else{
            $crono->precio = 0;
            $crono->duracion = 0;
        }
        $crono->disponibilidad = $request->dis;
        $crono->id = $request->user()->id_pe;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->estado = 1;

        $crono->save();

        $insertId = $crono->id_cr;
        /* FIN DE GUARDAR DATOS */
        /** GUARDAR DATOS DE HORARIO */
        $feriado = Feriado::where('estado','=',1)->get();
        $hora = new Horario;

        $dias = implode(',',$request->dias);

        $hora->id_cr = $insertId;
        $hora->dias = $dias;
        $hora->horarios = $request->horaInicio."-".$request->horaFin;
        $hora->f_inicio = formatoFecha($request->fechaInicio);
        $hora->f_fin = finalizacion(formatoFecha($request->fechaInicio),$request->dias,$request->duracion,$request->horaInicio,$request->horaFin,$feriado);
        $hora->estado = 1;

        $hora->save();
        /** FIN DE GUARDAR DATOS */
        Notification::success("El registro se realizó correctamente.");
        return redirect('findCronograma');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('cronograma.id_cr','=',$id)
                           ->get();

        return view('cronograma.updateCronograma', array("cronograma" => $crono, 'mes' => mes(), 'anio' => anio()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = array(
            'mes.required' => 'El Mes de cronograma es necesario.',
            'gestion.required' => 'La Gestion e s necesario.',
            'fechaInicio.required' => 'La Fecha de Inicio es necesario.',
            'horaInicio.required' => 'La Hora de Inicio es necesario.',
            'horaFin.required' => 'La Hora de Finalizacion es necesario.',
            'dias.required' => 'Los Dias son necesario.'
        );
        $rules = array (
            'mes' => 'required',
            'gestion' => 'required',
            'fechaInicio' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'dias' => 'required'
        );

        $this->validate($request, $rules, $messages);
        /* GUARDA DATOS DE CRONOGRAMA */
        $crono = Cronograma::find($request->id_cr);

        if(isset($request->pre) & isset($request->dur)){
            $crono->precio = $request->pre;
            $crono->duracion = $request->dur;
        }else{
            $crono->precio = 0;
            $crono->duracion = 0;
        }
        $crono->disponibilidad = $request->dis;
        $crono->id = $request->user()->id_pe;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->estado = 1;

        $crono->save();

        $insertId = $crono->id_cr;
        /* FIN DE GUARDAR DATOS */
        /** GUARDAR DATOS DE HORARIO */
        $feriado = Feriado::where('estado','=',1)->get();
        $hora = Horario::find($request->id_ho);

        $dias = implode(',',$request->dias);

        $hora->id_cr = $insertId;
        $hora->dias = $dias;
        $hora->horarios = $request->horaInicio."-".$request->horaFin;
        $hora->f_inicio = formatoFecha($request->fechaInicio);
        $hora->f_fin = finalizacion(formatoFecha($request->fechaInicio),$request->dias,$request->duracion,$request->horaInicio,$request->horaFin,$feriado);
        $hora->estado = 1;

        $hora->save();
        /** FIN DE GUARDAR DATOS */
        Notification::success("El registro se modificó correctamente.");
        return redirect('findCronograma');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('cronograma.deleteCronograma', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $crono = Cronograma::find($request->id);

        $crono->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findCronograma');
    }

    public function pruebaJson(){
        
    }
}
