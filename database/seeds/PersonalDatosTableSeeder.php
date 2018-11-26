<?php

use Illuminate\Database\Seeder;
use App\Personal;

class PersonalDatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('personal')->delete();

        //Añadimos una entrada a esta tabla
        Personal::create(array(
            'id_pe' => '1',
            'id_ca' => '1',
            'estado' => '1'
        ));
    }
}
