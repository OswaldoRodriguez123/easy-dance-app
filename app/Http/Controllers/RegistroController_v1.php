<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Usuario;
use App\ConfigEspecialidades;
use App\Paises;
use App\ComoNosConociste;
use Validator;
use Mail;
use Carbon\Carbon;

class RegistroController extends Controller {

    public function __construct()
    {
        // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('guest', ['except' => ['getLogout', 'checkSession']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('flujo_registro.registro')->with('como_nos_conociste' ,ComoNosConociste::all());
    }

}