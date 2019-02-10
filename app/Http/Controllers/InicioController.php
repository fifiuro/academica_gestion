<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\Curso;
use App\Horario;
use App\Feriado;
use App\Aula;
use App\InicioInstructor;
use App\InicioAula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inicio.findInicio');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cronograma = Cronograma::where();
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
        
        $aula = Aula::where('estado','=','1')->get();

        return view('inicio.createInicio', array("cronograma" => $crono, 'horario' => $horario, 'mes' => mes(), 'anio' => anio(), 'aula' => $aula));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'id_cr.required' => 'No es ningun inicio de curso valido.',
            'id_cur.required' => 'No se selecciono ningun curso.',
            'fechaInicio.required' => 'La Fecha de Inicio es necesario.',
            'h.required' => 'Es necesario definir el horario.',
            'd.required' => 'Es necesaio los dias a pasar clases.',
            'f.required' => 'Es necesaio las fechas de Inicio y Fin.',
            'dis.required' => 'Disponiblidad debe ser mayor a 0'
        );
        $rules = array (
            'id_cr' => 'required',
            'id_cur' => 'required',
            'idIns' => 'required',
            'fechaInicio' => 'required',
            'h' => 'required',
            'd' => 'required',
            'f' => 'required',
            'dis' => 'required'
        );

        $this->validate($request, $rules, $messages);

        /* GUARDA DATOS DE CRONOGRAMA */
        $crono = Cronograma::find($request->id_cr);

        if(isset($request->pre) & isset($request->dur)){
            $crono->precio = $request->pre;
            $crono->duracion = $request->dur;
        }else{
            $crono->precio = 0;
            $crono->duracion = 0;
        }
        $crono->disponibilidad = $request->dis;
        $crono->obs = $request->obs;
        $crono->estado = 2;

        $crono->save();
        /* FIN DE GUARDAR DATOS */

        /** GUARDAR DATOS DE HORARIO */
        $this->asigHorario($request->f, $request->h, $request->d, $request->id_ho, $request->id_cr);
        /** FIN DE GUARDAR DATOS */

        /** GUARDAR DATOS DE ASIGNACION DE INSTRUCTOR */
        $this->asigInstructor($request->idIns, $request->id_cr, $request->chora);
        /** FIN DE GUARDAR DATOS */

        /** GUARDAR DATOS DE ASIGNACION DE AULA */
        $this->asigAula($request->id_cr, $request->aula);
        /** FIN DE GUARDAR DATOS */

        Notification::success("El registro de Inicio se realizó correctamente.");
        return redirect('findCronograma');
    }

    public function asigHorario($f, $h, $d, $id, $id_cr)
    {
        if(count($f) == 1){
            $fecha = explode('-',$f[0]);
            $hora = Horario::find($id);

            $hora->dias = $d[0];
            $hora->horarios = $h[0];
            $hora->f_inicio = formatoFecha($fecha[0]);
            $hora->f_fin = formatoFecha($fecha[1]);
            $hora->save();

            return true;
        }elseif(count($f) > 1){
            for($i=0; $i<count($f); $i++){
                $fecha = explode('-',$f[$i]);
                if($i == 0){
                    $horaM = Horario::find($id);

                    $horaM->dias = $d[$i];
                    $horaM->horarios = $h[$i];
                    $horaM->f_inicio = formatoFecha($fecha[0]);
                    $horaM->f_fin = formatoFecha($fecha[1]);
                    $horaM->save();
                }else{
                    $horaN = new Horario;

                    $horaN->id_cr = $id_cr;
                    $horaN->dias = $d[$i];
                    $horaN->horarios = $h[$i];
                    $horaN->f_inicio = formatoFecha($fecha[0]);
                    $horaN->f_fin = formatoFecha($fecha[1]);
                    $horaN->estado = true;
                    $horaN->save();
                }
            }

            return true;
        }
    }

    public function asigInstructor($id_ins, $id_cr, $chora)
    {
        $instructor = new InicioInstructor;

        $instructor->id_cr = $id_cr;
        $instructor->id_ins = $id_ins;
        $instructor->c_hora = $chora;
        $instructor->estado = true;
        $instructor->save();

        return true;
    }

    public function asigAula($id_cr, $id_aul)
    {
        $aula = new InicioAula;

        $aula->id_cr = $id_cr;
        $aula->id_aul = $id_aul;
        $aula->estado = true;
        $aula->save();

        return true;
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
