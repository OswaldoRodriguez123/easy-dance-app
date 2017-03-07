<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Staff;
use App\HorarioStaff;
use App\ConfigStaff;
use App\DiasDeSemana;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class StaffController extends BaseController
{

	public function principal()
	{

        $staffs = Staff::join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.id', 'staff.identificacion', 'staff.nombre', 'staff.apellido', 'staff.sexo', 'config_staff.nombre as cargo')
            ->where('staff.deleted_at', '=', null)
            ->where('staff.academia_id', Auth::user()->academia_id)
        ->get();

		return view('staff.principal')->with(['staffs' => $staffs]);
	}

	public function create()
    {
        $dia_de_semana = DiasDeSemana::all();

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        Session::forget('horarios_staff');

        return view('staff.create')->with(['dias_de_semana' => $dia_de_semana, 'config_staff' => $config_staff]);
    }

    public function store(Request $request)
	{

		$request->merge(array('correo' => trim($request->correo)));

	    $rules = [
	        'identificacion' => 'required|min:7|numeric|unique:staff,identificacion',
	        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
	        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
	        'fecha_nacimiento' => 'required',
	        'sexo' => 'required',
	        'cargo' => 'required',
	    ];

	    $messages = [

	        'identificacion.required' => 'Ups! El identificador es requerido',
	        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
	        'identificacion.max' => 'El maximo de numeros permitidos son 20',
	        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
	        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
	        'nombre.required' => 'Ups! El Nombre  es requerido ',
	        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre.max' => 'El máximo de caracteres permitidos son 20',
	        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
	        'apellido.required' => 'Ups! El Apellido  es requerido ',
	        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
	        'apellido.max' => 'El máximo de caracteres permitidos son 20',
	        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
	        'sexo.required' => 'Ups! El Sexo  es requerido ',
	        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
	        'cargo.required' => 'Ups! El cargo es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


	        if($edad < 1){
	            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
	        }

	        $hora_inicio = strtotime($request->hora_inicio);
	        $hora_final = strtotime($request->hora_final);

	        if($hora_inicio > $hora_final)
	        {

	            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
	        }

	        $staff = new Staff;

	        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

	        $nombre = title_case($request->nombre);
	        $apellido = title_case($request->apellido);
	        $correo = strtolower($request->correo);

	        if($request->telefono)
	        {
	            $telefono = $request->telefono;

	        }else{
	            $telefono = '';
	        }

	        if($request->direccion)
	        {
	            $direccion = $request->direccion;

	        }else{
	            $direccion = '';
	        }

	        $staff->academia_id = Auth::user()->academia_id;
	        $staff->identificacion = $request->identificacion;
	        $staff->nombre = $nombre;
	        $staff->apellido = $apellido;
	        $staff->sexo = $request->sexo;
	        $staff->fecha_nacimiento = $fecha_nacimiento;
	        $staff->correo = $correo;
	        $staff->telefono = $telefono;
	        $staff->celular = $request->celular;
	        $staff->direccion = $direccion;
	        $staff->cargo = $request->cargo;

	        if($staff->save()){

                $horarios = Session::get('horarios_staff');

                foreach ($horarios as $tmp) {

                    $horario = new HorarioStaff;
                    $horario->staff_id = $staff->id;
                    $horario->dia_de_semana_id = $tmp['dia_de_semana_id'];
                    $horario->hora_inicio = $tmp['hora_inicio'];
                    $horario->hora_final = $tmp['hora_final'];
                    $horario->save();
                    
                    
                }


	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }

    public function operar($id)
    {   
        $staff = Staff::find($id);

        if($staff){
        	return view('staff.operacion')->with(['id' => $id, 'staff' => $staff]);   
        }else{
           return redirect("staff"); 
        }     
    }

    public function edit($id)
    {   
        $staff = Staff::join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'config_staff.nombre as cargo')
            ->where('staff.id', $id)
        ->first();

        if($staff){

            $dia_de_semana = DiasDeSemana::all();

            $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

            $horarios = HorarioStaff::join('dias_de_semana', 'horarios_staff.dia_de_semana_id', '=', 'dias_de_semana.id')
                ->join('staff', 'horarios_staff.staff_id', '=', 'staff.id')
                ->select('horarios_staff.*', 'dias_de_semana.nombre as dia')
                ->where('staff.academia_id' , Auth::user()->academia_id)
            ->get();
            return view('staff.planilla')->with(['alumno' => $staff, 'id' => $id, 'horarios' => $horarios, 'dias_de_semana' => $dia_de_semana, 'config_staff' => $config_staff]);
        }else{
           return redirect("staff"); 
        }
    }

    public function updateID(Request $request){
        $rules = [
            'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion, '.$request->id.'',
        ];

        $messages = [
            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El mínimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }else{
            $alumno = Staff::withTrashed()->find($request->id);
            $alumno->identificacion = $request->identificacion;        
            if($alumno->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 20',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 20',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }
        $alumno = Staff::withTrashed()->find($request->id);


        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);


        $alumno->nombre = $nombre;
        $alumno->apellido = $apellido;

        if($alumno->save()){

     
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){


        $alumno = Staff::withTrashed()->find($request->id);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
        $alumno->fecha_nacimiento = $fecha_nacimiento;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }
    public function updateSexo(Request $request){

        $alumno = Staff::withTrashed()->find($request->id);
        $alumno->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($alumno->save()){

         
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateTelefono(Request $request){

        $alumno = Staff::withTrashed()->find($request->id);
        $alumno->telefono = $request->telefono;
        $alumno->celular = $request->celular;

        if($alumno->save()){

           
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $alumno = Staff::withTrashed()->find($request->id);

        $direccion = $request->direccion;

        $alumno->direccion = $direccion;
        
        if($alumno->save()){


        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCargo(Request $request){

        $rules = [
            'cargo' => 'required',
        ];

        $messages = [

            'cargo.required' => 'Ups! El Cargo  es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $alumno = Staff::withTrashed()->find($request->id);
        $cargo = title_case($request->cargo);

        $alumno->cargo = $cargo;

        if($alumno->save()){
     
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateHorario(Request $request){

        $rules = [
            'hora_inicio' => 'required',
        	'hora_final' => 'required',
        ];

        $messages = [

            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        	'hora_final.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $alumno = Staff::withTrashed()->find($request->id);

        $alumno->hora_inicio = $request->hora_inicio;
        $alumno->hora_final = $request->hora_final;

        if($alumno->save()){
     
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregar_horario_fijo(Request $request){
        
    $rules = [

        'dia_de_semana_id' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $horario = new HorarioStaff;
        
        $horario->staff_id = $request->id;                   
        $horario->dia_de_semana_id = $request->dia_de_semana_id;
        $horario->hora_inicio = $request->hora_inicio;
        $horario->hora_final = $request->hora_final;

        if($horario->save()){

            $dia_de_semana = DiasDeSemana::find($request->dia_de_semana_id);

            $array=array('dia_de_semana' => $dia_de_semana->nombre, 'hora_inicio' => $request->hora_inicio , 'hora_final' => $request->hora_final);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $horario->id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }


        }
    }

    public function eliminar_horario_fijo($id){

        $horario = HorarioStaff::find($id);

        if($horario->delete()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function agregar_horario(Request $request){

        
    $rules = [

        'dia_de_semana_id' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $dia_de_semana = DiasDeSemana::find($request->dia_de_semana_id);

        $array=array('dia_de_semana_id' => $request->dia_de_semana_id, 'dia_de_semana' => $dia_de_semana->nombre, 'hora_inicio' => $request->hora_inicio , 'hora_final' => $request->hora_final);

        Session::push('horarios_staff', $array);

        $item = Session::get('horarios_staff');
        end( $item );
        $contador = key( $item );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminar_horario($id){

        $arreglo = Session::get('horarios_staff');

        unset($arreglo[$id]);
        Session::put('horarios_staff', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function destroy($id)
    {
        
        $staff = Staff::withTrashed()->find($id);
        
        if($staff->delete()){
            return response()->json(['mensaje' => '¡Excelente! El staff ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
      

        // return redirect("alumno");
    

}