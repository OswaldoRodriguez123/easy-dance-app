<?php namespace App\Http\Controllers;

class EgresoController extends BaseController {

	public function principal(){

        return view('administrativo.egresos.index');

    }
}