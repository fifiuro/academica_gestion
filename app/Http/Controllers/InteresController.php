<?php

namespace App\Http\Controllers;

use App\Interes;
use App\Curso;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class InteresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('interes.findInteres');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Interes  $interes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $interes = DB::select(" select distinct 
                                    p.id_pe,
                                    p.nombre, 
                                    p.apellidos, 
                                    (select group_concat(concat('- ',curso.codigo,' ',curso.nombre) SEPARATOR '<br>') as cursos from interes inner join curso on interes.id_cu = curso.id_cu where interes.id_pe = i.id_pe) as curso 
                                from interes as i
                                    inner join persona as p on (i.id_pe = p.id_pe)
                                where 
                                    concat(p.nombre,' ',p.apellidos) like '%".$request->nom."%' and 
                                    p.email like '%".$request->email."%' and 
                                    p.celular like '%".$request->celular."%'
                             ");
        
        if(count($interes) > 0){
            return view('interes.findInteres', array('interes' => $interes,
                                                     'estado' => true,
                                                    ));
        }else{
            return view('interes.findInteres', array('interes' => $interes,
                                                     'estado' => false,
                                                     'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom
                                                    ));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $curso = Curso::where('estado','=',1)->get();
        return view('interes.createInteres', array('curso' => $curso));
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
            'nom' => 'required',
            'ape' => 'required',
            'email' => 'required',
            'cel' => 'required',
            'id_cu' => 'required'
        );
        $messages = array(
            'nom.required' => 'El nombre es necesario.',
            'ape.required' => 'Los apellidos son necesarios.',
            'email.required' => 'El correo es necesario.',
            'cel.required' => 'El celular es necesario.',
            'id_cu.required' => 'Seleccione un curso de interes.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $persona = new Persona;
        $persona->nombre = $request->nom;
        $persona->apellidos = $request->ape;
        $persona->email = $request->email;
        $persona->celular = $request->cel;
        $persona->save();

        $id_pe = $persona->id_pe;

        for($i=0; $i<count($request->id_cu); $i++){
            $interes = new Interes;
            $interes->id_pe = $id_pe;
            $interes->id_cu = $request->id_cu[$i];
            $interes->estado = true;
            $interes->save();
        }

        Notification::success('El registro de realizó correctamente.');
        return redirect('findInteres');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interes  $interes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persona = Persona::find($id);

        $interes = Interes::join("curso","curso.id_cu","=",'interes.id_cu')
                          ->where('interes.id_pe','=',$id)
                          ->get();
        
        $curso = Curso::where('estado','=',1)->get();

        return view('interes.updateInteres', array('persona' => $persona, 'interes' => $interes, 'curso' => $curso));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interes  $interes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'id_pe' => 'required',
            'id_cu' => 'required'
        );
        $messages = array(
            'id_pe.required' => 'Seleccione a una persona interesada.',
            'id_cu.required' => 'Seleccione un curso de interes.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $interes = Interes::find($request->id);
        $interes->id_pe = $request->id_pe;
        $interes->id_cu = $request->id_cu;
        $interes->estado = true;
        $interes->save();

        Notification::success('El registro se modificaron correctamente.');
        return redirect('findInteres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id,$pe)
    {
        return view('interes.deleteInteres', array("id" => $id, 'pe' => $pe));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interes  $interes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $interes = Interes::find($request->id);
        $interes->delete();

        Notification::success('El Interés fue Eliminado.');
        return redirect('editInteres/'.$request->pe);
    }

    /**
     * Add new course
     * 
     * @param \App\Interes $interes
     * @return \Illuminate\Http\response
     */
    public function addInteres(Request $request)
    {
        $rules = array(
            'id_pe' => 'required',
            'id_cu' => 'required'
        );

        $messages = array(
            'id_pe.required' => 'Seleccione una persona',
            'id_cu.required' => 'Selecciona un curso existente'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $interes = Interes::where('id_pe','=',$request->id_pe)
                          ->where('id_cu','=',$request->id_cu)
                          ->get();

        if(count($interes) > 0){
            Notification::error('Ya se tiene asignado este curso.');
            return redirect('editInteres/'.$request->id_pe);
        }else{
            $interes = new Interes;
            $interes->id_pe = $request->id_pe;
            $interes->id_cu = $request->id_cu;
            $interes->estado = 1;
            $interes->save();

            Notification::success('Se agregó un nuevo Interés.');
            return redirect('editInteres/'.$request->id_pe);
        }
    }

    /**
     * All Destroy Interes
     * 
     * @param \App\Interes $interes
     * @return \Illuminate\Http\response
     */
    public function allDestroyInteres($id)
    {
        if(isset($id)){
            $interes = Interes::where('id_pe','=',$id)->delete();

            Notification::success('Se eliminó todos los intereses de la persona.');
            return redirect('findInteres');
        }
    }
}
