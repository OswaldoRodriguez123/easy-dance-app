<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class EmpresaController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{

        return view('empresa.index');  

	}

    public function embajadores()
    {

        return view('flujo_registro.listo');                    
    }

    public function acuerdos()
    {
        return view('soporte.acuerdo_servicio');                   
    }

    public function politicas(){
    	return view('soporte.politicas');
    }

    public function normas(){
    	return view('soporte.normas');
    }

}
