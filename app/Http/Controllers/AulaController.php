<?php

namespace App\Http\Controllers;

use App\Aula;
use Illuminate\Http\Request;
use Notification;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aula.findAula');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $aula = Aula::where('numero','like','%'.$request->num.'%')->get();

        if(count($aula) > 0){
            return view('aula.findAula', array('aula' => $aula,
                                               'estado' => true));
        }else{
            return view('aula.findAula', array('aula' => '',
                                               'estado' => false,
                                               'mensaje' => 'No se tuvieron coincidencias con: '.$request->num));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aula.createAula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'numero' => 'required|digits_between:1,2',
            'num_pc' => 'required|digits_between:1,3'
        );
        $messages = array(
            'numero.required' => 'Esta información es requerida. Ingrese un número',
            'numero.digits_between' => 'Ingrese en Número de Aula entre los rangos de 1 a 99',
            'num_pc.required' => 'Esta información es requerida. Ingrese un número.',
            'num_pc.digits_between' => 'Ingrese un número en Capacidad entre los rangos de 1 a 99.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $aula = new Aula;
        $aula->numero = $request->numero;
        $aula->num_pc = $request->num_pc;
        $aula->descripcion = $request->descripcion;
        $aula->estado = true;
        $aula->save();

        Notification::success('El registro se realizó correctamente.');
        return redirect('findAula');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aula = Aula::where('id_aul','=',$id)->get();

        return view('aula.updateAula', array('aula' => $aula));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'numero' => 'required|digits_between:1,2',
            'num_pc' => 'required|digits_between:1,3'
        );
        $messages = array(
            'numero.required' => 'Esta información es requerida. Ingrese un número',
            'numero.digits_between' => 'Ingrese en Número de Aula entre los rangos de 1 a 99',
            'num_pc.required' => 'Esta información es requerida. Ingrese un número.',
            'num_pc.digits_between' => 'Ingrese un número en Capacidad entre los rangos de 1 a 99.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $aula = Aula::find($request->id);
        $aula->numero = $request->numero;
        $aula->num_pc = $request->num_pc;
        $aula->descripcion = $request->descripcion;
        $aula->estado = $request->estado;
        $aula->save();

        Notification::success('El registro se modificaron correctamente.');
        return redirect('findAula');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('aula.deleteAula', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $aula = Aula::find($request->id);
        $aula->delete();

        Notification::success('El registro fue Eliminado');
        return redirect('findAula');
    }
}
