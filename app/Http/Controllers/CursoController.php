<?php

namespace App\Http\Controllers;

use App\Curso;
use Illuminate\Http\Request;
use Notification;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('curso.findCurso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cu = Curso::join("categoria","categoria.id_cat","=","curso.categoria")
                   ->where("nombre","like","%".$request->nom."%")
                   ->get();
        
        if($cu->idEmpty()){
            return view('curso.findCurso', array('curso' => '',
                                                 'estado' => false,
                                                 'mensaje' => 'No se tuvieron xoincidencias con: '.$request->nom));
        }else{
            return view('curso.findCurso', array('curso' => $cu,
                                                 'estado' => true));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Categoria::where("estado","=",1)->get();

        return view('curso.createCurso', array('cate' => $cate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cu = new Curso;

        $v = \Validator::make($request->all(), [
            'cod' => 'required',
            'nom' => 'required',
            'dur' => 'required',
            'nom_corto' => 'required',
            'cat' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $cu->codigo = $request->cod;
        $cu->nombre = $request->nom;
        $cu->duracion = $request->dur;
        $cu->nom_corto = $request->nom_corto;
        $cu->precio = $request->pre;
        $cu->categoria = $request->cat;
        $cu->estado = 1;
        $cu-> save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findCurso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Categoria::where("estado","=",1)->get();
        $cu = Curso::where("id_cu","=",$id)->get();

        return view('curso.updateCurso', array('curso' => $cu,'cate' => $cate));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        $cu = Curso::find($request->id_cu);

        $v = \Validator::make($request->all(), [
            'cod' => 'required',
            'nom' => 'required',
            'dur' => 'required',
            'nom_corto' => 'required',
            'cat' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $cu->codigo = $request->cod;
        $cu->nombre = $request->nom;
        $cu->duracion = $request->dur;
        $cu->nom_corto = $request->nom_corto;
        $cu->precio = $request->pre;
        $cu->categoria = $request->cat;
        $cu->estado = 1;
        $cu-> save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findCurso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('curso.deleteCurso', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        $cu = Curso::find($request->id);

        $cu->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findCurso');
    }
}
