<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ComoNosConocisteTableSeeder::class);
        $this->call(ConfigBoletosTableSeeder::class);
        $this->call(ConfigEspecialidadesTableSeeder::class);
        $this->call(ConfigNivelesTableSeeder::class);
        $this->call(DiasDeInteresTableSeeder::class);
        $this->call(DiasDeSemanaTableSeeder::class);        
        //$this->call(ItemsExamenesTableSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(ImpuestoTableSeeder::class);
        $this->call(FormasPagoSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConfigTipoItemsSeeder::class);
    }
}
