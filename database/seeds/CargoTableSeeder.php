<?php

use Illuminate\Database\Seeder;
use App\cargo;

class CargoTableSeeder extends Seeder
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
            'nombre' => 'Administrador',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Gerente General La Paz',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Responsable Ventas Office',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Respomsable Ventas Autodesk',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Departamento de Contable',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Departamento Académico',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Asistente de Gerencia',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Asistente Académico',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Encargado de Sistemas',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Soporte Técnico',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Mensajería',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Refrigerios',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Encargado de Fotocopias',
            'estado' => '1'
        ));
        Cargo::create(array(
            'nombre' => 'Diseñador Gráfico',
            'estado' => '1'
        ));
    }
}
