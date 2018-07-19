<?php

namespace App\Http\Controllers;

use App\Feriado;
use Illuminate\Http\Request;
use Notification;

class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feriado.findFeriado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $fer = Feriado::where("nombre","like","%".$request->nom."%")->get();

        if($fer->isEmpty()){
            return view('feriado.findFeriado', array('feriado' => '',
                                                     'estado' => false,
                                                     'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom));
        }else{
            return view('feriado.findFeriado', array('feriado' => $fer,
                                                     'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feriado.createFeriado');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fer = new Feriado;

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'fecha' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $fer->nombre = $request->nom;
        $fer->fecha = formatoFecha($request->fecha);
        $fer->estado = 1;
        $fer->save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findFeriado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fer = Feriado::where("id_fer","=",$id)->get();

        return view('feriado.updateFeriado', array('feriado' => $fer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fer = Feriado::find($request->id_fer);

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'fecha' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $fer->nombre = $request->nom;
        $fer->fecha = formatoFecha($request->fecha);
        $fer->estado = $request->estado;
        $fer->save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findFeriado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('feriado.deleteFeriado', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fer = Feriado::find($request->id);

        $fer->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findFeriado');
    }
}
