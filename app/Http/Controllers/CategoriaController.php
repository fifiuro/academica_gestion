<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categoria.findCategoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cat = DB::select("
        select c.id_cat, c.nombre, c.nivel, IFNULL((select nombre from categoria where id_cat = c.id_cate),'Ninguno') as nomOtro, c.orden, c.estado
        from categoria as c
        where c.nombre like '%".$request->nom."%'
        ");

        if(count($cat)<0){
            return view('categoria.findCategoria', array('categoria' => '',
                                                         'estado' => false,
                                                         'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom));
        }else{
            return view('categoria.findCategoria', array('categoria' => $cat,
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
        $cate = Categoria::where("estado","=",1)
                         ->where("nivel","=",0)
                         ->get();

        return view('categoria.createCategoria', array("cate" => $cate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = new Categoria;

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'nivel' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $cat->nombre = $request->nom;
        $cat->nivel = $request->nivel;
        $cat->id_cate = $request->n;
        $cat->orden = 0;
        $cat->estado = 1;
        $cat->save();

        Notification::success("El registro se realizó correctamente.");
        return redirect('findCategoria');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Categoria::where("estado","=",1)
                         ->where("nivel","=",0)
                         ->get();
        $cat = Categoria::where("id_cat","=",$id)->get();
        return view('categoria.updateCategoria', array('categoria' => $cat, 'cate' => $cate));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cat = Categoria::find($request->id_cat);

        $v = \Validator::make($request->all(), [
            'nom' => 'required',
            'nivel' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $cat->nombre = $request->nom;
        $cat->nivel = $request->nivel;
        $cat->id_cate = $request->n;
        $cat->estado = $request->estado;
        $cat->save();

        Notification::success("La modificación se realizó correctamente.");
        return redirect('findCategoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        return view('categoria.deleteCategoria', array("id" => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cat = Categoria::find($request->id);

        $cat->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findCategoria');
    }
}
