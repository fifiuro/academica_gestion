<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Instructor;
use App\Departamento;
use App\Trabajo;
use App\Curso;
use App\Especialidad;
use App\Empresa;
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
                      ->join("departamento","persona.expedido","=","departamento.id_dep")
                      ->leftjoin("trabajo","persona.id_pe","=","trabajo.id_pe")
                      ->where(DB::raw("concat(persona.nombre,' ',persona.apellidos)"),"like","%".$request->nom."%")
                      ->select("instructor.id_ins","persona.id_pe","persona.nombre","persona.apellidos","persona.ci","departamento.sigla","persona.tel_dom","persona.celular","persona.email")
                      ->get();
        
        if($ins->isEmpty()){
            if($request->instructor){
                return view('instructor.findInstructor', array('instructor' => '',
                                                                'estado' => false,
                                                                'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom));
            }else{
                echo 'No se tuvieron coincidencias con: '.$request->nom;
            }
        }else{
            if($request->instructor){
                return view('instructor.findInstructor', array('instructor' => $ins,
                                                               'estado' => true));
            }else{
                echo $this->tabla($ins);
            }
        }
    }

    private function tabla($ins)
    {
        $todo = "";
        foreach($ins as $key => $i){
            $todo .= "<tr data-id='".$i->id_ins."' data-nombre='".$i->nombre."' data-apellidos='".$i->apellidos."'>";
            $todo .= "<td>".$i->nombre." ".$i->apellidos."</td>";
            $todo .= "<td><input type='radio' name='sel' value='".$i->id_ins."' class='accion'></td>";
            $todo .= "</td>";
        }

        return $todo;
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
        $emp = Empresa::all();
        return view('instructor.createInstructor', array('depto' => $depto, 
                                                         'curso' => $curso,
                                                         'empresa' => $emp
                                                        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nom_cvc = "";
        $nom_cvm = "";

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'ape' => 'required',
            'cel' => 'required',
            'email' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errore());
        }
        /**
         * GUARDA REGISTRO EN LA TABLA PERSONA
         */
        $p1 = new Persona;
        $p1->nombre = $request->nom;
        $p1->apellidos = $request->ape;
        if($request->ci != ""){
            $p1->ci = $request->ci;
            $p1->expedido = $request->dep;
        }else{
            $p1->ci = "";
            $p1->expedido = $request->dep;
        }
        $p1->tel_dom = $request->td;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->dir_dom = $request->dir_dom;
        $p1->save();

        $insertId = $p1->id_pe;
        /* FIN DEL REGISTRO EN LA TABLA PERSONA */

        /**
         * GUARDA REGISTRO EN LA TABLA INSTRUCTOR
         */
        $cont = 0;
        if(is_array($request->cv)){
            if(count($request->cv) > 0)
            {
                $files = $request->file('cv');

                foreach($files as $file){
                    $extension = $file->getClientOriginalExtension();
                    if($extension == 'pdf' or $extension == 'PDF')
                    {
                        $nom_file = $file->getClientOriginalName();
                        \Storage::disk('local')->put($nom_file, \File::get($file));
                        if($cont == 0){
                            $nom_cvc = $nom_file;
                            $cont++;
                        }else{
                            $nom_cvm = $nom_file;
                        }
                    }
                }
            }
        }

        $p2 = new Instructor;
        $p2->id_pe = $insertId;
        $p2->obs = $request->obs;
        $p2->cvc = $nom_cvc;
        $p2->cvm = $nom_cvm;
        $p2->save();

        $insertInstructor = $p2->id_ins;
        /* FIN DEL REGISTRO EN LA TABLA INSTRUCTOR */

        /** GUARDAR REGISTROS EN LA TABLA TRABAJO */
        $p3 = new Trabajo;
        $p3->id_pe = $insertId;
        if($request->id_em != ''){
            $p3->id_em = $request->id_em;
        }else{
            $p3->id_em = 1;
        }
        $p3->direccion = $request->direccion_em;
        $p3->telefono = $request->telefono_e;
        $p3->estado = true;
        $p3->save();
        /** FIN DEL REGHISTRO DE LA TABLA TRABAJO */

        /**
         * GUARDA REGITROS EN LA TABLA ESPECIALIDAD
         */
        $e = new Especialidad;
        foreach($request->espe as $key => $es){
            $dataSet[] = [
                "id_cu" => $es,
                "id_ins" => $insertInstructor,
                "certificacion" => false
            ];
        }

        if(count($dataSet) > 0){
            $e->insert($dataSet);
        }
        /* FIN DEL REGISTRO DE LA TABLA ESPECIALIDAD */

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

        $esp = Especialidad::join('instructor','instructor.id_ins','=','especialidad.id_ins')
                           ->where('instructor.id_pe','=',$id)
                           ->select('id_cu')
                           ->get();
        
        $otro = array();
        foreach($esp as $key => $e){
            array_push($otro,$e->id_cu);
        }
        
        $trabajo = Trabajo::where('id_pe','=',$id)
                          ->where('estado','=',true)
                          ->get();

        $emp = Empresa::all();
        $curso = Curso::all();

        return view('instructor.updateInstructor', array("ins" => $ins, 
                                                         "trabajo" => $trabajo,
                                                         "depto" => $depto, 
                                                         "espe" =>  $otro,
                                                         "empresa" => $emp,
                                                         "curso" => $curso));
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

        /**
         * GUARDA MODIFICACIONES EN LA TABLA PERSONA
         */
        $p1 = Persona::find($request->id_pe);
        $p1->nombre = $request->nom;
        $p1->apellidos = $request->ape;
        if($request->ci != ""){
            $p1->ci = $request->ci;
            $p1->expedido = $request->dep;
        }else{
            $p1->ci = "";
            $p1->expedido = $request->dep;
        }
        $p1->tel_dom = $request->td;
        $p1->celular = $request->cel;
        $p1->email = $request->email;
        $p1->dir_dom = $request->dir_dom;
        $p1->save();

        /* FIN DE LA MODIFICACION EN LA TABLA PERSONA */

        /**
         * GUARDA MODIFICACIONES EN LA TABLA INSTRUCTOR
         */
        $cont = 0;
        if(is_array($request->cv)){
            if(count($request->cv) > 0)
            {
                $files = $request->file('cv');

                foreach($files as $file){
                    $extension = $file->getClientOriginalExtension();
                    if($extension == 'pdf' or $extension == 'PDF')
                    {
                        $nom_file = $file->getClientOriginalName();
                        \Storage::disk('local')->put($nom_file, \File::get($file));
                        if($cont == 0){
                            $nom_cvc = $nom_file;
                            $cont++;
                        }else{
                            $nom_cvm = $nom_file;
                        }
                    }
                }
            }
        }

        $p2 = Instructor::find($request->id_ins);
        $p2->obs = $request->obs;
        $p2->cvc = $nom_cvc;
        $p2->cvm = $nom_cvm;
        $p2->save();

        $insertInstructor = $p2->id_ins;
        /* FIN DE LA MODIFICACION EN LA TABLA INSTRUCTOR */

        /** MODIFICAR REGISTROS EN LA TABLA TRABAJO */
        if(isset($request->id_em)){
            $p3 = Trabajo::find($request->id_tra);
            $p3->id_pe = $request->id_pe;
            $p3->id_em = $request->id_em;
            $p3->direccion = $request->direccion_em;
            $p3->telefono = $request->telefono_em;
            $p3->estado = true;
            $p3->save();
        }else{
            $p3 = new Trabajo;
            $p3->id_pe = $request->id_pe;
            $p3->id_em = $request->id_em;
            $p3->direccion = $request->direccion_em;
            $p3->telefono = $request->telefono_em;
            $p3->estado = true;
            $p3->save();
        }
        /** FIN DE LA MODIFICACION DE LA TABLA TRABAJO */
        
        /**
         * MODIFICAR REGITROS EN LA TABLA ESPECIALIDAD
         */
        if(is_array($request->espe)){
            $this->agregarCurso($request->id_ins,$request->espe);
            $this->eliminarCurso($request->id_ins,$request->espe);
        }
        /* FIN DE LA MODIFICACION DE LA TABLA ESPECIALIDAD */

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findInstructor');
    }

    public function agregarCurso($id,$esp){
        $dataSet;
        $le = Especialidad::where("id_ins","=",$id)->get();

        foreach($le as $key => $lista){
            $cursoG[] = $lista->id_cu;
        }

        for($i=0; $i<count($esp); $i++){
            if(in_array($esp[$i],$cursoG)){

            }else{
                $dataSet[] = [
                    "id_cu" => $esp[$i],
                    "id_ins" => $id,
                    "certificacion" => false
                ];
            }
        }

        $e = new Especialidad;

        if(isset($dataSet)){
            if(count($dataSet) > 0){
                $e->insert($dataSet);
            }
        }
    }
    
    public function eliminarCurso($id,$esp){
        $dataSet;
        $le = Especialidad::where("id_ins","=",$id)->get();

        foreach($le as $key => $lista){
            if(in_array($lista->id_cu,$esp)){

            }else{
                $dataSet[] = $lista->id_cu;
            }
        }
        
        if(isset($dataSet)){
            if(count($dataSet) > 0){
                Especialidad::whereIn("id_cu",$dataSet)
                            ->where("id_ins","=",$id)->delete();
            }
        }
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
