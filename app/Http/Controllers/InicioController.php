<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\Curso;
use App\Horario;
use App\Feriado;
use Illuminate\Http\Request;
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
        //
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
                           ->select('cronograma.id_cr','cronograma.gestion','cronograma.mes','cronograma.disponibilidad','cronograma.obs','cronograma.estado','horario.id_ho','horario.dias','horario.horarios','horario.f_inicio','curso.id_cu','curso.codigo','curso.nombre','curso.duracion','curso.precio')
                           ->get();

        return view('inicio.createInicio', array("cronograma" => $crono, 'mes' => mes(), 'anio' => anio()));
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
            'fechaInicio' => 'required',
            'h' => 'required',
            'd' => 'required',
            'f' => 'required',
            'dis' => 'required'
        );

        $this->validate($request, $rules, $messages);

        echo "ID de cronograma: ".$request->id_cr."<br>";
        echo "ID de curso: ".$request->id_cur."<br>";
        echo "Duracion: ".$request->duracion."<br>";
        echo "Precio: ".$request->pre."<br>";
        echo "Fecha de Inicio: ".$request->fechaInicio."<br>";
        print_r($request->f);
        echo "<br>";
        print_r($request->h);
        echo "<br>";
        print_r($request->d);
        echo "<br>";
        echo "Disponibilidad: ".$request->dis."<br>";
        echo "Observaciones: ".$request->obs."<br>";

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
        $feriado = Feriado::where('estado','=',1)->get();
        $hora = Horario::find($request->id_ho);

        $dias = implode(',',$request->d);
        $horas = implode(',',$request->h);
        if($request->dur > 0){
            $duracion = $request->dur;
        }else{
            $duracion = $request->duracion;
        }
        
        $hora->dias = $dias;
        $hora->horarios = $horas;
        $hora->f_inicio = formatoFecha($request->fechaInicio);
        $hora->f_fin = finalizacion(formatoFecha($request->fechaInicio),$request->d,$request->h,$duracion,$feriado);
        $hora->estado = 1;

        $hora->save();
        /** FIN DE GUARDAR DATOS */
        Notification::success("El registro se Inicio correctamente.");
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
