<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CargoTableSeeder::class);
        $this->call(DepartamentoTableSeeder::class);
        $this->call(FeriadoTableSeeder::class);
        $this->call(TecnologiaTableSeeder::class);
        $this->call(PersonaTableSeeder::class);
        $this->call(PersonalDatosTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }
}
