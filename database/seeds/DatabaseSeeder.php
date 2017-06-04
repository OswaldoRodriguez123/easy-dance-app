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
        $this->call(CategoriasBlogTableSeeder::class);
        $this->call(ComoNosConocisteTableSeeder::class);
        $this->call(ConfigBoletosTableSeeder::class);
        $this->call(ConfigCitasTableSeeder::class);
        $this->call(ConfigCoreografiasTableSeeder::class);
        $this->call(ConfigEgresosTableSeeder::class);
        $this->call(ConfigEspecialidadesTableSeeder::class);
        $this->call(ConfigFacturasTableSeeder::class);
        $this->call(ConfigNivelesTableSeeder::class);
        $this->call(ConfigStaffTableSeeder::class);
        $this->call(ConfigTipoExamenesTableSeeder::class);
        $this->call(DiasDeInteresTableSeeder::class);
        $this->call(DiasDeSemanaTableSeeder::class); 
        $this->call(FormasPagoTableSeeder::class);  
        $this->call(ImpuestoTableSeeder::class);        
        $this->call(ItemsExamenesTableSeeder::class);         
        $this->call(PaisesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TiposEgresosTableSeeder::class);
    }
}
