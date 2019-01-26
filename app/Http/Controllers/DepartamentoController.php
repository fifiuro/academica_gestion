<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Departamento;
use Illuminate\Contracts\Validation\Validator;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departamento.findDepartamento');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $depto = Departamento::where("nombre","like","%".$request->nom."%")->get();

        if(count($depto)>0)
        {
            return view('departamento.findDepartamento', array('depto' => $depto,
                                                               'estado' => true));
        }else{
            return view('departamento.findDepartamento', array('depto' => '',
                                                               'estado' => false,
                                                               'mensaje' => 'No se tuvieron coincidencisa con: '.$request->nom));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departamento.createDepartamento');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $depto = new Departamento;

        $v = \Validator::make($request->all(),[
            'nom' => 'required',
            'sig' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $depto->nombre = $request->nom;
        $depto->sigla = $request->sig;
        $depto->save();

        Notification::success('El registro se realizó correctamente.');
        return redirect('findDepartamento');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depto = Departamento::where('id_dep','=',$id)->get();

        return view('departamento.updateDepartamento', array('depto' => $depto));
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
        $depto = Departamento::find($request->id);

        $v = \Validator::make($request->all(),[
            'nom' => 'required',
            'sig' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $depto->nombre = $request->nom;
        $depto->sigla = $request->sig;
        $depto->save();

        Notification::success('Los datos se modificaron correctamente.');
        return redirect('findDepartamento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('departamento.deleteDepartamento', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $depto = Departamento::find($request->id);
        $depto->delete();

        Notification::success('El registro fue Eliminado.');
        return redirect('findDepartamento');
    }
}
