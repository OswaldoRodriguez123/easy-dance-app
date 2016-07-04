<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;
use App\Instructor;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class ReporteController extends Controller
{

	public function Inscritos(){

		$inscritos = DB::table('inscripcion_clase_grupal')
			->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        return view('reportes.inscritos')->with('inscritos', $inscritos);
	}

	public function Presenciales(){

		$presenciales = DB::table('visitantes_presenciales')
            ->join('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        ->get();

        return view('reportes.presenciales')->with('presenciales', $presenciales);
	}

	public function Contactos(){

		$alumnos = DB::table('alumnos')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.correo',  'alumnos.telefono', 'alumnos.celular', 'alumnos.id')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        return view('reportes.contactos')->with('alumnoscontacto', $alumnos);
	}

}