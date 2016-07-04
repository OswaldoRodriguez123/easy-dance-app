<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model {

	protected $table = 'facturas';

	public function items_factura()
    {
        return $this->hasMany('App\ItemsFactura');
    }

}