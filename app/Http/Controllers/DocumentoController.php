<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('documento.findDocumento');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $doc = Documento::where('documento','like','%'.$request->doc.'%')->get();

        if(count($doc) > 0){
            return view('documento.findDocumento', array('doc' => $doc,
                                                         'estado' => true));
        }else{
            return view('documento.findDocumento', array('doc' => $doc,
                                                         'estado' => false,
                                                         'mensaje' => 'No se tuvieron coincidencias con: '.$request->doc));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documento.createDocumento');
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
            'doc' => 'required'
        );

        $messages = array(
            'doc.required' => 'Esta información es requerida.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $doc = new Documento;
        $doc->documento = $request->doc;
        $doc->descripcion = $request->des;
        $doc-save();
        
        Notification::success('El registro de Tipo de Documento se realizó correctamente.');
        return redirect('findDocumento');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doc = Docuemento::find($id);

        return view('documento.updateDocumento', array('doc' => $doc));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        $rules = array(
            'doc' => 'required'
        );

        $messages = array(
            'doc.required' => 'Esta información es requerida.'
        );

        $v = \Validator::make($request->all(), $rules, $messages);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $doc = Documento::find($request->id);
        $doc->documento = $request->doc;
        $doc->descripcion = $request->des;
        $doc->estado = $request->estado;
        $doc-save();
        
        Notification::success('La modificación de Tipo de Documento se realizó correctamente.');
        return redirect('findDocumento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('documento.deleteDocumento', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        $doc = Documento::find($request->id);
        $doc->delete();

        Notification::success('El registro de Tipo de Documento fue Eliminado.');
        return redirect('findDocumento');
    }
}
