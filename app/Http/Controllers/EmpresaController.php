<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Empresa;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('empresa.findEmpresa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $emp = Empresa::where("razon_social","like","%".$request->nom."%")->get();
        
        if($emp->isEmpty()){
            return view('empresa.findEmpresa', array('empresa' => '',
                                                       'estado' => false,
                                                       'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom.'.'));
        }else{
            return view('empresa.findEmpresa', array("empresa" => $emp, 'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresa.createEmpresa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emp = new Empresa;

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'sig' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $emp->razon_social = $request->nom;
        $emp->sigla = $request->sig;
        $emp->nit = $request->nit;
        $emp->direccion = $request->dir;
        $emp->tel = $request->tel;
        $emp->save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findEmpresa');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emp = Empresa::where("id_em","=",$id)->get();
        
        return view('empresa.updateEmpresa', array("empresa" => $emp));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $emp = Empresa::find($request->id_em);

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'sig' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $emp->razon_social = $request->nom;
        $emp->sigla = $request->sig;
        $emp->nit = $request->nit;
        $emp->direccion = $request->dir;
        $emp->tel = $request->tel;
        $emp->save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findEmpresa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('empresa.deleteEmpresa', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $emp = Empresa::find($request->id);

        $emp->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findEmpresa');
    }
}
