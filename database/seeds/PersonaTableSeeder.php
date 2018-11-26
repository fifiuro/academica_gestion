<?php

use Illuminate\Database\Seeder;
use App\Persona;

class PersonaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('persona')->delete();

        //Añadimos una entrada a esta tabla
        Persona::create(array(
            'nombre' => 'Administrador',
            'apellidos' => 'Administrador',
            'ci' => '12345678',
            'expedido' => '1',
            'tel_dom' => '2668932',
            'tel_of' => '2668932',
            'celular' => '60154789',
            'email' => 'administrador@gmail.com'
        ));
    }
}
