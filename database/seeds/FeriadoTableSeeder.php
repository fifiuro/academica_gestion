<?php

use Illuminate\Database\Seeder;
use App\Feriado;

class FeriadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('feriado')->delete();

        //Añadimos una entrada a esta tabla
        feriado::create(array(
            'nombre' => 'Día de la Patria',
            'fecha' => '2018-08-06',
            'estado' => '1'
        ));
    }
}
