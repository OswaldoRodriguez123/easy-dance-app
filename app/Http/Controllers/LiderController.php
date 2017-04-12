<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use Mail;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use Illuminate\Support\Facades\Session;

class LiderController extends BaseController {

	public function index()
    {
    	return view('lideres.principal');
    }

    public function empezar()
    {
    	return view('lideres.empezar');
    }

}