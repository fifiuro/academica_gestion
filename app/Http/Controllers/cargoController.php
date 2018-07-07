<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\cargo;
use Illuminate\Contracts\Validation\Validator;

class cargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findForm()
    {
        //
        return view ('cargo.findCargo');
    }

    /**
     * Buscar los cargos existentes
     *
     * @param  string  $text
     * @return \Illuminate\Http\Response
     */
    public function findCargo(Request $request)
    {
        $cargo = cargo::where('nombre','like','%'.$request->cargo.'%')->get();

        if(count($cargo)>0){
            return view('cargo.findCargo', array('lista' => $cargo, 'estado' => true));
        }else{
            return view('cargo.findCargo', array('lista' => '', 
                                                'estado' => false, 
                                                'mensaje' => 'No se tuvieron coincidencias con: '.$request->cargo.'.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        //
        return view('cargo.createForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createCargo(Request $request)
    {
        //
        $cargo = new cargo;

        $v = \Validator::make($request->all(),[
            'nom' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $cargo->nombre = $request->nom;
        $cargo->estado = 1;
        $cargo->save();

        Notification::success('El registro se realizó correctamente.');
        return redirect('findCargo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateForm($id)
    {
        $cargo = cargo::where("id_ca","=",$id)->get();

        return view('cargo.updateForm', array("cargo" => $cargo));
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
        $cargo = cargo::find($request->id);
        $cargo->nombre = $request->nom;
        $cargo->estado = $request->est;
        $cargo->save();

        Notification::success('Los datos se modificaron correctamente.');
        return redirect('findCargo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyForm($id)
    {
        return view('cargo.deleteForm', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cargo = cargo::find($request->id);
        $cargo->delete();

        Notification::success('El registro fue Eliminado.');
        return redirect('findCargo');
    }

}
