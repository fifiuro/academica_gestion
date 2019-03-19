<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findAluInt(Request $request)
    {
        $bus = DB::select('select Interes.id_pe, Interes.nombre, Interes.apellidos
                            from
                                (select distinct p.id_pe, p.nombre, p.apellidos from interes as i inner join persona as p on (i.id_pe = p.id_pe) where i.estado = true) as Interes
                                left join (select distinct p.id_pe, p.nombre, p.apellidos from persona as p inner join inscripcion as i on (p.id_pe = i.id_pe)) as Inscrito
                                            on (Interes.id_pe = Inscrito.id_pe)
                            where concat(Interes.nombre," ",Interes.apellidos) like "%'.$request->nom.'%"');

        if(count($bus) == 0){
            echo 'No se tuvieron coincidencias con: '.$request->nom;
        }else{
            echo $this->tabla($bus);
        }
    }

    private function tabla($bus){
        $todo = "";
        foreach($bus as $key => $b){
            $todo .= "<tr data-id='".$b->id_pe."' data-nombre='".$b->nombre."' data-apellidos='".$b->apellidos."'>";
            $todo .= "<td>".$b->nombre." ".$b->apellidos."</td>";
            $todo .= "<td><input type='radio' name='sel' value='".$b->id_pe."' class='accion'></td>";
            $todo .= "</td>";
        }

        return $todo;
    }
}
