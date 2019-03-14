<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function cursos()
    {
        $curso = DB::select('select c.id_cr, 
                                    c.duracion as dur_cro, 
                                    cu.codigo, cu.nombre, 
                                    cu.duracion as dur_cur, 
                                    h.f_inicio, h.dias, 
                                    h.horarios, 
                                    (select count(*) from interes where id_cu = c.id_cu and estado = 1) as total
                            from cronograma as c 
                                inner join curso as cu on (c.id_cu = cu.id_cu)
                                inner join horario as h on (c.id_cr = h.id_cr)
                            order by c.id_cr asc');

        return $curso;
    }

}