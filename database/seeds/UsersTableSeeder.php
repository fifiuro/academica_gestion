<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borramos los datos de la tabla
        DB::table('users')->delete();

        //Añadimos una entrada a esta tabla
        User::create(array(
            'name' => 'Administrador',
            'username' => 'adm',
            'email' => '12345678',
            'password' => bcrypt('adm'),
            'id_pe' => '1'
        ));
    }
}
