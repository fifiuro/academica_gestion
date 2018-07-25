<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Instructor;
use App\Departamento;
use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\DB;
use Notification;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instructor.findInstructor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ins = Persona::join("instructor","persona.id_pe","=","instructor.id_pe")
                      ->where(DB::raw("concat(persona.nombre,' ',persona.apellidos)"),"like","%".$request->nom."%")
                      ->get();
        
        if($ins->isEmpty()){
            return view('instructor.findInstructor', array('instructor' => '',
                                                           'estado' => false,
                                                           'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom));
        }else{
            return view('instructor.findInstructor', array('instructor' => $ins,
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
        $depto = Departamento::all();
        $curso = Curso::all();
        return view('instructor.createInstructor', array("depto" => $depto, 'curso' => $curso));
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
        $p2 = new Instructor;

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'ape' => 'required',
            'cel' => 'required',
            'email' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errore());
        }

        $p1->nombre = $request->nom;
        $p1->apellidos = $request->ape;
        if($request->ci != ""){
            $p1->ci = $request->ci;
            $p1->expedido = $request->dep;
        }else{
            $p1->ci = "";
            $p1->expedido = "";
        }
        $p1->tel_dom = $request->td;
        $p1->tel_of = $request->to;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->save();

        $insertId = $p1->id_pe;

        $cont = 0;
        $files = $request->file('cv');

        foreach($files as $file){
            $nom_file = $file->getClientOriginalName();
            \Storage::disk('local')->put($nom_file, \File::get($file));
            if($cont == 0){
                $nom_cvc = $nom_file;
                $cont++;
            }else{
                $nom_cvm = $nom_file;
            }
        }

        $p2->id_pe = $insertId;
        $p2->obs = $request->obs;
        $p2->cvc = $nom_cvc;
        $p2->cvm = $nom_cvm;

        $p2->save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findInstructor');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ins = Persona::join("instructor","persona.id_pe","=","instructor.id_pe")
                      ->where("persona.id_pe","=",$id)
                      ->get();

        $depto = Departamento::all();

        return view('instructor.updateInstructor', array("ins" => $ins, "depto" => $depto));
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
        $nom_cvc = "";
        $nom_cvm = "";

        $p1 = Persona::find($request->id_pe);
        $p2 = Instructor::find($request->id_ins);

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
        $p1->tel_of = $request->to;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->save();

        $files = $request->file('cv');

        if(!is_null($request->file('cv'))){
            for($i=0; $i<2; $i++){
                if(array_key_exists($i,$files)){
                    switch ($i) {
                        case '0':
                            if(\File::exists(public_path('almacen/'.$request->cvc))){
                                \File::delete(public_path('almacen/'.$request->cvc));
                            }
                            $nom_cvc = $files[$i]->getClientOriginalName();
                            \Storage::disk('local')->put($nom_cvc, \File::get($files[$i]));
                            break;
                        case '1':
                            if(\File::exists(public_path('almacen/'.$request->cvm))){
                                \File::delete(public_path('almacen/'.$request->cvm));
                            }
                            $nom_cvm = $files[$i]->getClientOriginalName();
                            \Storage::disk('local')->put($nom_cvm, \File::get($files[$i]));
                            break;
                    }
                }
            }
        }

        $p2->obs = $request->obs;
        if($nom_cvc != ""){
            $p2->cvc = $nom_cvc;
        }
        if($nom_cvm != ""){
            $p2->cvm = $nom_cvm;
        }
        $p2->save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findInstructor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('instructor.deleteInstructor', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $p1 = Persona::find($request->id);

        $p1->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findInstructor');
    }
}
