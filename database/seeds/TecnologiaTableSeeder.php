<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class TecnologiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('categoria')->delete();

        //Añadimos una entrada a esta tabla
        Categoria::create(array(
            'nombre' => 'Microsoft',
            'nivel' => '0',
            'id_cate' => '0',
            'orden' => '0',
            'estado' => '1',
        ));
        Categoria::create(array(
            'nombre' => 'Ofimática',
            'nivel' => '0',
            'id_cate' => '0',
            'orden' => '0',
            'estado' => '1',
        ));
        Categoria::create(array(
            'nombre' => 'Microsoft Excel 2013',
            'nivel' => '1',
            'id_cate' => '2',
            'orden' => '0',
            'estado' => '1',
        ));
        Categoria::create(array(
            'nombre' => 'Microsoft Word 2013',
            'nivel' => '1',
            'id_cate' => '2',
            'orden' => '0',
            'estado' => '1',
        ));
    }
}
