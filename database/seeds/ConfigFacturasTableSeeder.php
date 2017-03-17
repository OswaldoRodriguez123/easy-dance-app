<?php

use Illuminate\Database\Seeder;
use App\ConfigFactura;

class ConfigFacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_facturas')->delete();

  	    ConfigFactura::create(array(
  	      'nombre' => 'Servicio',
  	    ));

        ConfigFactura::create(array(
          'nombre' => 'Producto',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Inscripción Clase Grupal',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Cuota Clase Grupal',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Inscripción Taller',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Acuerdo de Pago',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Remanente',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Retraso de Pago',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Inscripción Clase Personalizada',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Regalo',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Recompensa Campaña',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Contribución Campaña',
        ));

        ConfigFactura::create(array(
          'nombre' => 'Abono',
        ));
    }
}
