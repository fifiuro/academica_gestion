<?php

use Illuminate\Database\Seeder;
use App\Curso;

class CursoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('curso')->delete();

        //Añadimos una entrada a esta tabla
        Curso::create(array(
            'codigo' => 'OFF-604',
            'nombre' => 'Microsoft Excel 2013: Nivel I - Fundamentos',
            'duracion' => '18',
            'nom_corto' => 'Excel I',
            'precio' => '600',
            'categoria' => '3',
            'estado' => '1'
        ));

        Curso::create(array(
            'codigo' => 'OFF-605-1',
            'nombre' => 'Microsoft Excel 2013: Nivel II - Funciones y manejo de datos',
            'duracion' => '24',
            'nom_corto' => 'Excel II',
            'precio' => '650',
            'categoria' => '3',
            'estado' => '1'
        ));

        Curso::create(array(
            'codigo' => 'OFF-602',
            'nombre' => 'Microsoft Word 2013: Nivel II',
            'duracion' => '20',
            'nom_corto' => 'Wor II',
            'precio' => '600',
            'categoria' => '4',
            'estado' => '1'
        ));

        Curso::create(array(
            'codigo' => 'OFF-605-2',
            'nombre' => 'Microsoft Excel 2013: Nivel III - Herramientas Avanzadas',
            'duracion' => '24',
            'nom_corto' => 'Excel III',
            'precio' => '0',
            'categoria' => '3',
            'estado' => '1'
        ));
    }
}
