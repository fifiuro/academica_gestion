<?php

namespace App\Http\Controllers;

use App\Inscripcion;
use App\Persona;
use App\Cronograma;
use App\Horario;
use App\Aula;
use App\Interes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inscripcion.findInscripcion');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ins = DB::select(" select i.id_insc, concat(p.nombre, ' ', p.apellidos) as alumno, concat(cu.codigo, ' ', cu.nombre) as curso, i.estado 
                            from inscripcion as i
                                inner join persona as p on (i.id_pe = p.id_pe)
                                inner join cronograma as c on (i.id_cr = c.id_cr)
                                inner join curso as cu on (c.id_cu = cu.id_cu)
                            where
                                concat(p.nombre,' ',p.apellidos) like '%".$request->nom."%' and
                                concat(cu.codigo,' ',cu.nombre) like '%".$request->curso."%';");
        
        if(count($ins) > 0){
            return view('inscripcion.findInscripcion', array('ins' => $ins,
                                                 'estado' => true));
        }else{
            return view('inscripcion.findInscripcion', array('ins' => '',
                                                 'estado' => false,
                                                 'mensaje' => 'No se tuvieron coincidencias con : '.$request->nom.' o '.$request->curso));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('cronograma.id_cr','=',$id)
                           ->select('cronograma.id_cr',
                                    'cronograma.gestion',
                                    'cronograma.mes',
                                    'cronograma.disponibilidad',
                                    'cronograma.obs',
                                    'cronograma.estado',
                                    DB::raw('cronograma.precio as p'),
                                    DB::raw('cronograma.duracion as d'),
                                    'horario.id_ho',
                                    'horario.f_inicio',
                                    'curso.id_cu',
                                    'curso.codigo',
                                    'curso.nombre',
                                    'curso.duracion',
                                    'curso.precio')
                           ->get();
        
        $horario = Horario::where('id_cr','=',$id)->get();
        
        $aula = Aula::join('inicio_aula','inicio_aula.id_aul','=','aula.id_aul')
                    ->where('inicio_aula.id_cr','=',$id)
                    ->get();

        $ins = Persona::join('instructor','instructor.id_pe','=','persona.id_pe')
                      ->join('inicio_instructor','instructor.id_ins','=','inicio_instructor.id_ins')
                      ->where('inicio_instructor.id_cr','=',$id)
                      ->select('nombre','apellidos')
                      ->get();

        return view('inscripcion.createInscripcion', array("cronograma" => $crono, 
                                                           'horario' => $horario, 
                                                           'mes' => mes(), 
                                                           'anio' => anio(), 
                                                           'aula' => $aula, 
                                                           'ins' => $ins));
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
            'id_cr' => 'required',
            'idAlu' => 'required',
            'precio' => 'required',
            'pago' => 'required'
        );

        $messages = array(
            'id_cr.required' => 'Selecione un Curso para la inscripción.',
            'idAlu.required' => 'Seleccione una Persona para inscribir.',
            'precio.required' => 'Se necesita le precio para el curso',
            'pago' => 'Seleccione un tipo de pago.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $ins = new Inscripcion;
        $ins->id_cr = $request->id_cr;
        $ins->id_pe = $request->idAlu;
        $ins->precio = $request->precio;
        $ins->tipo_pago = $request->pago;
        if($request->cuota != 1){
            $request->estado = 2;
        }

        switch ($request->pago) {
            case '1':
                $ins->num_cuota = 1;
                $ins->estado = 1;
                break;
            
            case '2':
                $ins->num_cuota = $request->cuota;
                $ins->estado = 2;
                break;
            
            case '3':
                $ins->num_cuota = 1;
                $ins->estado = 2;
                break;
            
            case '4':
                $ins->num_cuota = $request->cuota;
                $ins->estado = 2;
                break;
        }
        $ins->obs = $request->obs;
        $ins->save();
        
        Notification::success('Se guardo correctamente la Inscripción.');
        return redirect('findInscripcion');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ins = Inscripcion::find($id);

        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('cronograma.id_cr','=',$ins->id_cr)
                           ->select('cronograma.id_cr',
                                    'cronograma.gestion',
                                    'cronograma.mes',
                                    'cronograma.disponibilidad',
                                    'cronograma.obs',
                                    'cronograma.estado',
                                    DB::raw('cronograma.precio as p'),
                                    DB::raw('cronograma.duracion as d'),
                                    'horario.id_ho',
                                    'horario.f_inicio',
                                    'curso.id_cu',
                                    'curso.codigo',
                                    'curso.nombre',
                                    'curso.duracion',
                                    'curso.precio')
                           ->get();
        
        $horario = Horario::where('id_cr','=',$ins->id_cr)->get();
        
        $aula = Aula::join('inicio_aula','inicio_aula.id_aul','=','aula.id_aul')
                    ->where('inicio_aula.id_cr','=',$ins->id_cr)
                    ->get();

        $instructor = Persona::join('instructor','instructor.id_pe','=','persona.id_pe')
                            ->join('inicio_instructor','instructor.id_ins','=','inicio_instructor.id_ins')
                            ->where('inicio_instructor.id_cr','=',$ins->id_cr)
                            ->select('nombre','apellidos')
                            ->get();
        
        $persona = Inscripcion::join('persona','persona.id_pe','=','inscripcion.id_pe')
                              ->where('inscripcion.id_cr','=',$ins->id_cr)
                              ->where('inscripcion.id_pe','=',$ins->id_pe)
                              ->select('persona.nombre','persona.apellidos')
                              ->get();
        
        
        
        return view('inscripcion.updateInscripcion', array("cronograma" => $crono, 
                                                           'horario' => $horario, 
                                                           'mes' => mes(), 
                                                           'anio' => anio(), 
                                                           'aula' => $aula, 
                                                           'ins' => $instructor,
                                                           'persona' => $persona,
                                                           'inscripcion' => $ins));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'id_insc' => 'required',
            'precio' => 'required',
            'pago' => 'required'
        );

        $messages = array(
            'id_insc.required' => 'No se seleccionó una inscripción correcta.',
            'precio.required' => 'Se necesita le precio para el curso',
            'pago.required' => 'Seleccione un tipo de pago.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $ins = Inscripcion::find($request->id_insc);
        $ins->precio = $request->precio;
        $ins->tipo_pago = $request->pago;
        if($request->cuota != 1){
            $request->estado = 2;
        }

        switch ($request->pago) {
            case '1':
                $ins->num_cuota = 1;
                $ins->estado = 1;
                break;
            
            case '2':
                $ins->num_cuota = $request->cuota;
                $ins->estado = 2;
                break;
            
            case '3':
                $ins->num_cuota = 1;
                $ins->estado = 2;
                break;
            
            case '4':
                $ins->num_cuota = $request->cuota;
                $ins->estado = 2;
                break;
        }
        $ins->obs = $request->obs;
        $ins->save();
        
        Notification::success('Se modificó correctamente la Inscripción.');
        return redirect('findInscripcion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('inscripcion.deleteInscripcion', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ins = Inscripcion::find($request->id);
        $persona = $ins->id_pe;
        $crono = $ins->id_cr;
        $ins->delete();

        $this->agregar($persona, $crono);
    }

    /**
     * Agrega al inscrito como un interesado em el curso que se borró
     */
    public function agregar($persona, $crono)
    {
        $curso = Cronograma::find($crono);

        $interes = new Interes;
        $interes->id_pe = $persona;
        $interes->id_cu = $curso->id_cu;
        $interes->estado = 1;
        $interes->save();

        Notitication::success('Se eliminó la Inscripción.');
        return redirect('findInscripcion');
    }

}
