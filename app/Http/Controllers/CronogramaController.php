<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\Curso;
use App\Horario;
use App\Feriado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class CronogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cronograma.findCronograma');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('curso.codigo','like','%'.$request->cod.'%')
                           ->Where('curso.nombre','like','%'.$request->nom.'%')
                           ->where('cronograma.mes','=',$request->mes)
                           ->where('cronograma.gestion','=',$request->gestion)
                           ->where('cronograma.estado','=',1)
                           ->select("cronograma.id_cr",
                                "curso.codigo",
                                "curso.nombre",
                                "curso.duracion",
                                "horario.f_inicio",
                                "horario.f_fin",
                                "horario.horarios",
                                "horario.dias",
                                "cronograma.estado")
                           ->get();

        if($crono->isEmpty()){
            return view('cronograma.findCronograma', array('cronograma' => '',
                                                           'estado' => false,
                                                           'mensaje' => 'No se tuvieron coincidencias.'));
        }else{
            return view('cronograma.findCronograma', array("cronograma" => $crono, 'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cronograma.createCronograma', array('mes' => mes(), 'anio' => anio()));
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
            'mes.required' => 'El Mes de cronograma es necesario.',
            'gestion.required' => 'La Gestion es necesario.',
            'id_cur.required' => 'No se selecciono ningun curso.',
            'fechaInicio.required' => 'La Fecha de Inicio es necesario.',
            'h.required' => 'Es necesario definir el horario.',
            'd.required' => 'Es necesaio los dias a pasar clases.',
        );
        $rules = array (
            'mes' => 'required',
            'gestion' => 'required',
            'id_cur' => 'required',
            'fechaInicio' => 'required',
            'h' => 'required',
            'd' => 'required'
        );

        $this->validate($request, $rules, $messages);

        /* GUARDA DATOS DE CRONOGRAMA */
        $crono = new Cronograma;

        $crono->id_cu = $request->id_cur;
        if(isset($request->pre) & isset($request->dur)){
            $crono->precio = $request->pre;
            $crono->duracion = $request->dur;
        }else{
            $crono->precio = 0;
            $crono->duracion = 0;
        }
        $crono->disponibilidad = $request->dis;
        $crono->id = $request->user()->id_pe;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->estado = 1;

        $crono->save();

        $insertId = $crono->id_cr;
        /* FIN DE GUARDAR DATOS */
        /** GUARDAR DATOS DE HORARIO */
        $feriado = Feriado::where('estado','=',1)->get();
        $hora = new Horario;

        $dias = implode(',',$request->d);
        $horas = implode(',',$request->h);
        if($request->dur > 0){
            $duracion = $request->dur;
        }else{
            $duracion = $request->duracion;
        }
        
        $hora->id_cr = $insertId;
        $hora->dias = $dias;
        $hora->horarios = $horas;
        $hora->f_inicio = formatoFecha($request->fechaInicio);
        $hora->f_fin = finalizacion(formatoFecha($request->fechaInicio),$request->d,$request->h,$duracion,$feriado);
        $hora->estado = 1;

        $hora->save();
        /** FIN DE GUARDAR DATOS */
        Notification::success("El registro se realizó correctamente.");
        return redirect('findCronograma');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crono = Cronograma::join('curso','cronograma.id_cu','=','curso.id_cu')
                           ->join('horario','cronograma.id_cr','=','horario.id_cr')
                           ->where('cronograma.id_cr','=',$id)
                           ->get();

        return view('cronograma.updateCronograma', array("cronograma" => $crono, 'mes' => mes(), 'anio' => anio()));
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
        echo "Mes: ".$request->mes."<br>";
        echo "Gestion: ".$request->gestion."<br>";
        echo "ID del curso: ".$request->id_cur."<br>";
        echo "Duracion original: ".$request->duracion."<br>";
        echo "Duracion Cambio: ".$request->dur."<br>";
        echo "Precio Cambio: ".$request->pre."<br>";
        echo "Fecha de Inicio: ".$request->fechaInicio."<br>";
        echo "Disponibilidad: ".$request->dis."<br>";
        echo "Observaciones: ".$request->obs."<br>";
        echo "Dias: ";
        print_r($request->d);
        echo "<br>";
        echo "Horas: ";
        print_r($request->h);
        echo "<br>";

        $messages = array(
            'mes.required' => 'El Mes de cronograma es necesario.',
            'gestion.required' => 'La Gestion es necesario.',
            'id_cur.required' => 'No se selecciono ningun curso.',
            'fechaInicio.required' => 'La Fecha de Inicio es necesario.',
            'h.required' => 'Es necesario definir el horario.',
            'd.required' => 'Es necesaio los dias a pasar clases.',
        );
        $rules = array (
            'mes' => 'required',
            'gestion' => 'required',
            'id_cur' => 'required',
            'fechaInicio' => 'required',
            'h' => 'required',
            'd' => 'required'
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
        $crono->id = $request->user()->id_pe;
        $crono->mes = $request->mes;
        $crono->gestion = $request->gestion;
        $crono->obs = $request->obs;
        $crono->estado = 1;

        $crono->save();

        $insertId = $crono->id_cr;
        /* FIN DE GUARDAR DATOS */
        /** GUARDAR DATOS DE HORARIO */
        $feriado = Feriado::where('estado','=',1)->get();
        $hora = Horario::find($request->id_ho);

        $dias = implode(',',$request->dias);

        $hora->id_cr = $insertId;
        $hora->dias = $dias;
        $hora->horarios = $request->horaInicio."-".$request->horaFin;
        $hora->f_inicio = formatoFecha($request->fechaInicio);
        $hora->f_fin = finalizacion(formatoFecha($request->fechaInicio),$request->dias,$request->duracion,$request->horaInicio,$request->horaFin,$feriado);
        $hora->estado = 1;

        $hora->save();
        /** FIN DE GUARDAR DATOS */
        Notification::success("El registro se modificó correctamente.");
        return redirect('findCronograma');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('cronograma.deleteCronograma', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $crono = Cronograma::find($request->id);

        $crono->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findCronograma');
    }

    public function pruebaJson(){
        
    }
}
