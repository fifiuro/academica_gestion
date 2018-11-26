<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\Curso;
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
        $crono = Cronograma::join("curso","cronograma.id_cu","=","curso.id_cu")
                      ->join("persona","cronograma.id","=","persona.id_pe")
                      ->where("curso.codigo","like","%".$request->cod."%")
                      ->orWhere("curso.nombre","like","%".$request->nom."%")
                      ->orWhere("cronograma.mes","=",$request->mes)
                      ->orWhere("cronograma.gestion","=",$request->gestion)
                      ->select("cronograma.id_cr",
                                "curso.codigo",
                                "curso.nombre",
                                "curso.duracion",
                                "cronograma.fecha_inicio",
                                "cronograma.fecha_fin",
                                "cronograma.hora_inicio",
                                "cronograma.hora_fin",
                                "cronograma.dias")
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

        $crono = new Cronograma;

        $dias = implode(',',$request->dias);

        $crono->id_cu = $request->id_cur;
        $crono->fecha_inicio = formatoFecha($request->fechaInicio);
        $crono->fecha_fin = formatoFecha($request->fechaInicio);
        $crono->hora_inicio = $request->horaInicio;
        $crono->hora_fin = $request->horaFin;
        $crono->dias = $dias;
        $crono->precio = 0;
        $crono->duracion = 0;
        $crono->disponibilidad = $request->dis;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->id = $request->user()->id_pe;
        $crono->save();

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
        $crono = Cronograma::join("curso","cronograma.id_cu","=","curso.id_cu")
                           ->where("cronograma.id_cr","=",$id)
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
        print_r ($request->dias);
        $v = \Validator::make($request->all(), [
            'id_cr' => 'required',
            'fechaInicio' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'dias' => 'required',
            'mes' => 'required',
            'gestion' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $crono = Cronograma::find($request->id_cr);

        $dias = implode(",",$request->dias);

        $crono->fecha_inicio = formatoFecha($request->fechaInicio);
        $crono->fecha_fin = formatoFecha($request->fechaInicio);
        $crono->hora_inicio = $request->horaInicio;
        $crono->hora_fin = $request->horaFin;
        $crono->dias = $dias;
        //$crono->precio = $request->precio;
        //$crono->duracion = $request->duracion;
        $crono->disponibilidad = $request->dis;
        //$crono->id = $request->id;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->save();

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
}
