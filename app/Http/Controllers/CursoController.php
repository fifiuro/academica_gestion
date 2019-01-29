<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $cu = DB::select("
        select c.id_cu, c.codigo, c.nombre, c.duracion, c.nom_corto, c.precio, ca.nombre as categoria, c.estado 
        from curso as c
            inner join categoria as ca on c.categoria = ca.id_cat
        where concat(c.codigo,' ',c.nombre) like '%".$request->nom."%'
        ");
        
        if(count($cu)<=0){
            if($request->curso){
                return view('curso.findCurso', array('curso' => '',
                                                    'estado' => false,
                                                    'mensaje' => 'No se tuvieron coincidencias con: '.$request->nom));
            }else{
                echo 'No se tuvieron coincidencias con: '.$request->nom;
            }
        }else{
            if($request->curso){
                return view('curso.findCurso', array('curso' => $cu,
                                                     'estado' => true));
            }else{
                echo $this->tabla($cu);
            }
        }
    }
    
    private function tabla($curso){
        $todo = "";
        foreach($curso as $key => $c){
            $todo .= "<tr data-id='".$c->id_cu."' data-c='".$c->codigo."' data-n='".$c->nombre."' data-d='".$c->duracion."' data-p='".$c->precio."'>";
            $todo .= "<td>".$c->codigo."</td>";
            $todo .= "<td>".$c->nombre."</td>";
            $todo .= "<td>".$c->duracion."</td>";
            $todo .= "<td>".$c->precio."</td>";
            $todo .= "<td><input type='radio' name='sel' value='".$c->id_cu."' class='accion'></td>";
            $todo .= "</td>";
        }

        return $todo;
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

        $cu = new Curso;

        $dur = str_replace("_","",$request->dur);
        if($dur == ""){
            $dur = 0;
        }

        $pre = str_replace("_","",$request->pre);
        if($pre == ""){
            $pre = 0;
        }

        $cu->codigo = $request->cod;
        $cu->nombre = $request->nom;
        $cu->duracion = $dur;
        $cu->nom_corto = $request->nom_corto;
        $cu->precio = $pre;
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
    public function update(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'id_cu' => 'required',
            'cod' => 'required',
            'nom' => 'required',
            'dur' => 'required',
            'nom_corto' => 'required',
            'cat' => 'required'
        ]);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        
        $cu = Curso::find($request->id_cu);

        $dur = str_replace("_","",$request->dur);
        if($dur == ""){
            $dur = 0;
        }

        $pre = str_replace("_","",$request->pre);
        if($pre == ""){
            $pre = 0;
        }

        $cu->codigo = $request->cod;
        $cu->nombre = $request->nom;
        $cu->duracion = $dur;
        $cu->nom_corto = $request->nom_corto;
        $cu->precio = $pre;
        $cu->categoria = $request->cat;
        $cu->estado = $request->estado;
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
    public function destroy(Request $request)
    {
        $cu = Curso::find($request->id);

        $cu->delete();

        Notification::success("El registro fue Eliminado.");
        return redirect('findCurso');
    }
}
