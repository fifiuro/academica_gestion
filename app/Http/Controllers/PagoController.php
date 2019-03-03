<?php

namespace App\Http\Controllers;

use App\Pago;
use Illuminate\Http\Request;
use Notification;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pago.findPago');
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $pago = Pago::where('tipo','like','%'.$request->tipo.'%')->get();

        if(count($pago) > 0){
            return view('pago.findPago', array('pago' => $pago,
                                               'estado' => true));
        }else{
            return view('pago.findPago', array('pago' => $pago,
                                               'estado' => false,
                                                'mensaje' => 'No se tuvieron coincidencias con: '.$request->tipo));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pago.createPago');
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
            'tipo' => 'required'
        );

        $messages = array(
            'tipo.required' => 'Esta información en requerida.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $pago = new Pago;
        $pago->tipo = $request->tipo;
        $pago->descripcion = $request->des;
        $pago->save();
        
        Notification::success('El registro de tipo de Pago se realizó correctamente.');
        return redirect('findPago');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pago = Pago::find($id);

        return view('pago.updatePago', array('pago' => $pago));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        $rules = array(
            'tipo' => 'required'
        );

        $messages = array(
            'tipo.required' => 'Esta información en requerida.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $pago = Pago::find($request->id);
        $pago->tipo = $request->tipo;
        $pago->descripcion = $request->des;
        $pago->estado = $request->estado;
        $pago->save();
        
        Notification::success('El registro de Tipo de Pago se modificó correctamente.');
        return redirect('findPago');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('pago.deletePago', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pago = Pago::find($request->id);
        $pago->delete();

        Notification::success('El registro de tipo de Pago fue Eliminado.');
        return redirect('findPago');
    }
}
