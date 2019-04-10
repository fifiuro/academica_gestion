<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Persona;
use App\Trabajo;
use App\Referencia;
use App\Departamento;
use App\Empresa;
use App\Interes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alumno.findAlumno');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $alumno = Alumno::join('persona','persona.id_pe','=','alumno.id_pe')
                        ->where(DB::raw('concat(nombre," ",apellidos)'),'like','%'.$request->nom.'%')
                        ->where('email','like','%'.$request->email.'%')
                        ->get();
        
        if(count($alumno) > 0){
            return view('alumno.findAlumno', array('alumno' => $alumno,
                                                    'estado' => true));
        }else{
            return view('alumno.findAlumno', array('alumno' => '',
                                                    'estado' => false,
                                                    'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom.' o '.$request->email));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dep = Departamento::all();
        $emp = Empresa::all();

        return view('alumno.createAlumno', array('dep' => $dep, 'emp' => $emp));
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
            'nombre_p' => 'required',
            'apellidos_p' => 'required',
            'ci_p' => 'required',
            'expedido_p' => 'required',
            'celular_p' => 'required',
            'email_p' => 'required',
            'dir_dom_p' => 'required',
            'id_em' => 'required',
            'direccion_t' => 'required',
            'telefono_t' => 'required',
            'nombre_r' => 'required',
            'apellidos_r' => 'required',
            'telefono_r' => 'required',
            'celular_r' => 'required'
        );
        $messages = array(
            'nombre_p.required' => 'Nombre del Alumno es requerido.',
            'apellidos_p.required' => 'Apellidos del Alumno es requerido.',
            'ci_p.required' => 'Carnet de Identidad del Alumno es requerido.',
            'expedido_p.required' => 'Detalle de donde se saco el Carnet de Identidad.',
            'celular_p.required' => 'Celular del Alumno es requerido.',
            'email_p.required' => 'Email del Alumno es requerido.',
            'dir_dom_p.required' => 'Dirección del domicilio del Alumno es requerido.',
            'id_em.required' => 'Nombre de la Empresa es requerido.',
            'direccion_t.required' => 'Direccion del trabajo es requerido.',
            'telefono_t.required' => 'Telefono del trabajo es requerido.',
            'nombre_r.required' => 'Nombre de la referencia es requerido.',
            'apellidos_r.required' => 'Apellidos de la referencia son requeridos.',
            'telefono_r.required' => 'Teléfono de la referendia son requeridos.',
            'celular_r.required' => 'Celular de la referencia son requeridos.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $persona = new Persona;

        $persona->nombre = $request->nombre_p;
        $persona->apellidos = $request->apellidos_p;
        $persona->ci = $request->ci_p;
        $persona->expedido = $request->expedido_p;
        $persona->tel_dom = $request->teldom_p;
        $persona->celular = $request->celular_p;
        $persona->email = $request->email_p;
        $persona->dir_dom = $request->dir_dom_p;
        $persona->save();

        $pe = $persona->id_pe;

        $trabajo = new Trabajo;
        $trabajo->id_pe = $pe;
        $trabajo->id_em = $request->id_em;
        $trabajo->direccion = $request->direccion_t;
        $trabajo->telefono = $request->telefono_t;
        $trabajo->estado = true;
        $trabajo->save();

        $referencia = new Referencia;
        $referencia->id_pe = $pe;
        $referencia->nombre = $request->nombre_r;
        $referencia->apellidos = $request->apellidos_r;
        $referencia->telefono = $request->telefono_r;
        $referencia->celular = $request->celular_r;
        $referencia->estado = true;
        $referencia->save();

        $alumno = new Alumno;
        $alumno->id_pe = $pe;
        $alumno->save();

        Notification::success('El registro del Alumno se realizó correctamente.');
        return redirect('findAlumno');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno = Alumno::find($id);

        $persona = Persona::find($alumno->id_pe);

        $trabajo = Trabajo::where('id_pe','=',$alumno->id_pe)
                          ->where('estado','=',true)
                          ->get();

        $referencia = Referencia::where('id_pe','=',$alumno->id_pe)
                                ->where('estado','=',true)
                                ->get();
                            
        $dep = Departamento::all();
        $emp = Empresa::all();
                        
        return view('alumno.updateAlumno', array(
                                                'persona' => $persona,
                                                'trabajo' => $trabajo,
                                                'referencia' => $referencia,
                                                'dep' => $dep,
                                                'emp' => $emp
                                            ));
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
        $rules = array(
            'nombre_p' => 'required',
            'apellidos_p' => 'required',
            'ci_p' => 'required',
            'expedido_p' => 'required',
            'celular_p' => 'required',
            'email_p' => 'required',
            'dir_dom_p' => 'required',
            'id_em' => 'required',
            'direccion_t' => 'required',
            'telefono_t' => 'required',
            'nombre_r' => 'required',
            'apellidos_r' => 'required',
            'telefono_r' => 'required',
            'celular_r' => 'required'
        );
        $messages = array(
            'nombre_p.required' => 'Nombre del Alumno es requerido.',
            'apellidos_p.required' => 'Apellidos del Alumno es requerido.',
            'ci_p.required' => 'Carnet de Identidad del Alumno es requerido.',
            'expedido.required' => 'Detalle de donde se saco el Carnet de Identidad.',
            'celular_p.required' => 'Celular del Alumno es requerido.',
            'email_p.required' => 'Email del Alumno es requerido.',
            'dir_dom_p.required' => 'Dirección del domicilio del Alumno es requerido.',
            'id_em.required' => 'Nombre de la Empresa es requerido.',
            'direccion_t.required' => 'Direccion del trabajo es requerido.',
            'telefono_t.required' => 'Telefono del trabajo es requerido.',
            'nombre_r.required' => 'Nombre de la referencia es requerido.',
            'apellidos_r.required' => 'Apellidos de la referencia son requeridos.',
            'telefono_r.required' => 'Teléfono de la referendia son requeridos.',
            'celular_r.required' => 'Celular de la referencia son requeridos.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $persona = Persona::find($request->id_pe);

        $persona->nombre = $request->nombre_p;
        $persona->apellidos = $request->apellidos_p;
        $persona->ci = $request->ci_p;
        $persona->expedido = $request->expedido_p;
        $persona->tel_dom = $request->teldom_p;
        $persona->celular = $request->celular_p;
        $persona->email = $request->email_p;
        $persona->dir_dom = $request->dir_dom_p;
        $persona->save();

        $trabajo = Trabajo::find($request->id_tra);
        $trabajo->id_em = $request->id_em;
        $trabajo->direccion = $request->direccion_t;
        $trabajo->telefono = $request->telefono_t;
        $trabajo->estado = true;
        $trabajo->save();

        $referencia = Referencia::find($request->id_ref);
        $referencia->nombre = $request->nombre_r;
        $referencia->apellidos = $request->apellidos_r;
        $referencia->telefono = $request->telefono_r;
        $referencia->celular = $request->celular_r;
        $referencia->estado = true;
        $referencia->save();

        Notification::success('El registro del Alumno se Modificó.');
        return redirect('findAlumno');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('alumno.deleteAlumno', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $alumno = Persona::find($request->id);
        $alumno->delete();

        Notification::success('El registro del Alumno fue Eliminado.');
        return redirect('findAlumno');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findAluInt(Request $request)
    {
        $todo = Persona::whereRaw('concat(nombre," ",apellidos) like "%'.$request->nom.'%"')->limit(5)->get();

        if(count($todo) == 0){
            echo 'No se tuvieron coincidencias con: '.$request->nom;
        }else{
            echo $this->tabla($todo);
        }
    }

    private function tabla($bus)
    {
        $todo = "";
        foreach($bus as $key => $b){
            $todo .= "<tr data-id='".$b->id_pe."' data-nombre='".$b->nombre."' data-apellidos='".$b->apellidos."'>";
            $todo .= "<td>".$b->nombre." ".$b->apellidos."</td>";
            $todo .= "<td><input type='radio' name='sel' value='".$b->id_pe."' class='accion'></td>";
            $todo .= "</td>";
        }

        return $todo;
    }
}
