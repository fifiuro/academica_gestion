<?php

use Illuminate\Database\Seeder;
use App\cargo;

class PersonalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('cargo')->delete();

        //Añadimos una entrada a esta tabla
        Cargo::create(array(
            'nombre' => 'Gerente General La Paz',
            'estado' => '1'
        ));
    }
}
