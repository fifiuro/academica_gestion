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
        $crono = new Cronograma;

        $v = \Validator::make($request->all(), [
            'id_cu' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dias' => 'required',
            'duracion' => 'required',
            'id' => 'required',
            'mes' => 'required',
            'gestion' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $crono->id_cu = $request->id_cu;
        $crono->fecha_inicio = $request->fecha_inicio;
        $crono->fecha_fin = $request->fecha_fin;
        $crono->hora_inicio = $request->hora_inicio;
        $crono->hora_fin = $request->hora_fin;
        $crono->dias = $request->dias;
        $crono->precio = $request->precio;
        $crono->duracion = $request->duracion;
        $crono->disponibilidad = $request->disponibilidad;
        $crono->id = $request->id;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
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
                      ->join("persona","cronograma.id","=","persona.id_pe")
                      ->where("cronograma.id_cr","=",$id)
                      ->get();
        
        return view('cronograma.updateCronograma', array("cronograma" => $crono));
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
        $crono = Cronograma::find($request->id);

        $v = \Validator::make($request->all(), [
            'id_cu' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dias' => 'required',
            'duracion' => 'required',
            'id' => 'required',
            'mes' => 'required',
            'gestion' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $crono->id_cu = $request->id_cu;
        $crono->fecha_inicio = $request->fecha_inicio;
        $crono->fecha_fin = $request->fecha_fin;
        $crono->hora_inicio = $request->hora_inicio;
        $crono->hora_fin = $request->hora_fin;
        $crono->dias = $request->dias;
        $crono->precio = $request->precio;
        $crono->duracion = $request->duracion;
        $crono->disponibilidad = $request->disponibilidad;
        $crono->id = $request->id;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->save();

        Notification::success("El registro se realizó correctamente.");
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
