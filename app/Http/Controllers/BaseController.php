<?php 

namespace App\Http\Controllers;

use View;
use App\Alumno;
use App\Instructor;
use Illuminate\Support\Facades\Auth;


class BaseController extends Controller {

    public function __construct() {

    if (Auth::check()) { 

	       $alumno = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

	       $instructor = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

	       View::share ( 'alumnos', $alumno  );
	       View::share ( 'instructores', $instructor );
   		}

    }  

}