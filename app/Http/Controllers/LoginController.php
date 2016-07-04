<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Usuario;
use App\Alumno;
use Validator;
use Carbon\Carbon;
use Storage;
use DB;

class LoginController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return view('login.index');
	}

	public function plantilla()
	{
		return view('alumno.plantilla');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function login(Request $request)
	{   
        $usuario = Usuario::where('correo', '=', $request->correo)->first();

        if (!empty($usuario)) {  
            if($request->contrasena == $usuario->contrasena){
                return view('alumno.index')->with('alumno', Alumno::all());
            }
            else{
                return response()->json(['status' => 'ERROR CONTRASENA'],422);
            }
        }else{
            return response()->json(['status' => 'ERROR CORREO'],422);
        }

    }
}