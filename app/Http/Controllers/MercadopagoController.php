<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Alumno;
use MP;

class MercadopagoController extends Controller
{
    //
    public function mercadopago()
    {
    	$alumno = Alumno::find(4);


		$preference_data = array(
		"items" => array(
			array(
			//"id" => $array['mov_id'],
			//"title" => $array['mov_nomplan'].', este paquete incluye '.$array['mov_sms'].' SMS',
			"currency_id" => "VEF",
			"title" => 'EasyDance - Servicio de Baile',
			"picture_url" => "http://app.easydancelatino.com/assets/img/icono_easydance1.png",
			"description" => 'Servicio de Baile',
			//"category_id" => "Category",
			"quantity" => 1,
			"unit_price" =>  3//intval($array['mov_precioplan'])
			)
		),
			"payer" => array(
			  "name" => $alumno->nombre,
			  "surname" => $alumno->apellido,
			  "email" => $alumno->correo,
			  //"date_created" => "2014-07-28T09:50:37.521-04:00"
			)
		);
		$preference = MP::create_preference($preference_data);
		//dd($preference);
		return view('mercadopago.index')->with('datos', $preference);


    }
}
