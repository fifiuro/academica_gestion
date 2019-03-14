<?php

namespace App\Http\Controllers;

use App\Inscripcion;
use App\Persona;
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
        $ins = DB::select(" select i.id_insc, p.nombre, p.apellidos, cu.codigo, cu.nombre, i.estado 
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
    public function create()
    {
        return view('inscripcion.createInscripcion');
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
            'id_pe' => 'required',
            'precio' => 'required',
            'tipo_pago' => 'required',
            'num_cuota' => 'required'
        );

        $messages = array(
            'id_cr.required' => 'Selecione un Curso para la inscripción.',
            'id_pe.required' => 'Seleccione una Persona para inscribir.',
            'precio.required' => 'Se necesita le precio para el curso',
            'tipo_pago' => 'Seleccione un tipo de pago.',
            'num_cuota' => 'INgrese el numero de cuotas que se pagará.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v-errors());
        }

        $ins = new Inscripcion;
        $ins->id_cr = $request->id_cr;
        $ins->id_pe = $request->id_pe;
        $ins->precio = $request->precio;
        $ins->tipo_pago = $request->pago;
        $ins->num_cuota = $request->cuota;
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

        $nom = Persona::find($ins->id_pe);

        return view('inscripcion.updateInscripcion', array('ins' => $ins, 'nom' => $nom));
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
            'id_cr' => 'required',
            'id_pe' => 'required',
            'precio' => 'required',
            'tipo_pago' => 'required',
            'num_cuota' => 'required'
        );

        $messages = array(
            'id_cr.required' => 'Selecione un Curso para la inscripción.',
            'id_pe.required' => 'Seleccione una Persona para inscribir.',
            'precio.required' => 'Se necesita le precio para el curso',
            'tipo_pago' => 'Seleccione un tipo de pago.',
            'num_cuota' => 'INgrese el numero de cuotas que se pagará.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v-errors());
        }

        $ins = Inscripcion::find($request->id);
        $ins->id_cr = $request->id_cr;
        $ins->id_pe = $request->id_pe;
        $ins->precio = $request->precio;
        $ins->tipo_pago = $request->pago;
        $ins->num_cuota = $request->cuota;
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
        $ins->delete();

        Notitication::success('La eliminó la Inscripción.');
        return redirect('findInscripcion');
    }

}
