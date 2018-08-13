<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Personal;
use App\cargo;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('personal.findPersonal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $per = Persona::join("personal","persona.id_pe","=","personal.id_pe")
                      ->join("departamento","persona.expedido","=","departamento.id_dep")
                      ->where(DB::raw("concat(persona.nombre,' ',persona.apellidos)"),"like","%".$request->nom."%")
                      ->select("personal.id_pe","persona.nombre","persona.apellidos","persona.ci","departamento.sigla","persona.tel_dom","persona.celular","persona.email","personal.id_ca","personal.estado")
                      ->get();
        
        $cargo = cargo::where("estado","=",1)->get();
        
        if($per->isEmpty()){
            return view('personal.findPersonal', array('personal' => '',
                                                       'estado' => false,
                                                       'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom.'.'));
        }else{
            return view('personal.findPersonal', array("personal" => $per, "cargo" => $cargo, 'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cargo = cargo::where("estado","=",1)->get();
        $depto = Departamento::all();
        return view('personal.createForm', array("cargo" => $cargo, "depto" => $depto));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $p1 = new Persona;
        $p2 = new Personal;

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'ape' => 'required',
            'cel' => 'required',
            'email' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $p1->nombre = $request->nom;
        $p1->apellidos = $request->ape;
        $p1->ci = $request->ci;
        $p1->expedido = $request->dep;
        $p1->tel_dom = $request->td;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->save();

        $insertId = $p1->id_pe;

        $p2->id_pe = $insertId;
        $p2->id_ca = $request->car;
        $p2->estado = 1;
        $p2->save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findPersonal');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p = Persona::join("personal","persona.id_pe","=","personal.id_pe")
                    ->where("persona.id_pe","=",$id)
                    ->get();
        
        $cargo = cargo::where("estado","=",1)->get();

        $depto = Departamento::all();
        
        return view('personal.updateForm', array("persona" => $p, "cargo" => $cargo, "depto" => $depto));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $p1 = Persona::find($request->id_pe);
        $p2 = Personal::find($request->id_pe);

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'ape' => 'required',
            'cel' => 'required',
            'email' => 'required'
        ]);

        if($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $p1->nombre = $request->nom;
        $p1->apellidos = $request->ape;
        $p1->ci = $request->ci;
        $p1->expedido = $request->dep;
        $p1->tel_dom = $request->td;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->save();

        $p2->id_ca = $request->car;
        $p2->estado = 1;
        $p2->save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findPersonal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('personal.deleteForm', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $p1 = Persona::find($request->id);

        $p1->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findPersonal');
    }
}
