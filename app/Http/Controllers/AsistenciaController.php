<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cronograma;
use App\Inscripcion;
use Notification;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asistencia.findAsistencia');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $asistencia = Asistencia::join();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $curso = Cronograma::join('horario','horario.id_cr','=','cronograma.id_cr')
                           ->join('curso','curso.id_cu','=','cronograma.id_cu')
                           ->select('cronograma.id_cr','curso.codigo','curso.nombre','horario.f_inicio','horario.horarios','horario.dias')
                           ->selectRaw('if(cronograma.duracion = 0, curso.duracion, cronograma.duracion) as duracion')
                           ->where('cronograma.id_cr','=',$id)
                           ->get();

        $inscritos = Inscripcion::join('alumno','alumno.id_alu','=','inscripcion.id_alu')
                                ->join('persona','persona.id_pe','=','alumno.id_pe')
                                ->where('id_cr','=',$id)
                                ->get();
        
        return view('asistencia.createAsistencia', array('curso' => $curso, 'inscritos' => $inscritos));
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
            'fecha' => 'required',
            'id_ins' => 'required',
            'tipo' => 'required'
        );

        $messages = array(
            'id_cr' => 'No se seleccionó el curso a registrar la asistencia.',
            'fecha' => 'No se seleccionnó la fecha de asistencia.',
            'id_ins' => 'No se tiene a ningun alumno seleccionado.',
            'tipo' => 'Determinar le tipo de a<sistencia que tiene el alumno.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        if(count($request->id_ins) > 0 and count($request->tipo) > 0){
            for ($i=0; $i < cont($request->id_ins); $i++) { 
                $asistencia = New Asistencia;
                $asistencia->id_cr = $request->id_cr;
                $asistencia->id_insc = $request->id_ins[$i];
                $asistencia->fecha_asis = formatoFecha($request->fecha);
                $asistencia->tipo = $request->tipo[$i];
                $asistencia->save();
            }
        }

        Notification::success('El registro de Asistencia se realizó correctamente.');
        return redirect('findAsistencia');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
