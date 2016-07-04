<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsFactura extends Model {

	protected $table = 'items_factura';

	public function factura()
    {
        return $this->belongsToToMany('App\Factura');
        // return $this->belongsToMany('App\Factura', 'items_factura')
        //            ->withPivot('alumno_id', 'importe_neto');
    } 

}