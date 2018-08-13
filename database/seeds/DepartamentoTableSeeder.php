<?php

use Illuminate\Database\Seeder;
use App\Departamento;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('departamento')->delete();

        //Añadimos una entrada a esta tabla
        Departamento::create(array(
            'nombre' => 'La Paz',
            'sigla' => 'LP'
        ));
        Departamento::create(array(
            'nombre' => 'Cochabamba',
            'sigla' => 'CBB'
        ));
        Departamento::create(array(
            'nombre' => 'Santa Cruz',
            'sigla' => 'SCZ'
        ));
    }
}
