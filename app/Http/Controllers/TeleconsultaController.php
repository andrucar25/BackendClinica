<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teleconsulta;
use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Paciente;



class TeleconsultaController extends Controller
{
    public function index()
    {
        $Teleconsulta = Teleconsulta::all();
        return response()->json($Teleconsulta);
    }

    public function endTeleconsultation(Request $request){
        $validator = Validator::make($request->all(),[
            'idTeleconsulta' => 'required',
            'diagnostico' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
    
                $teleconsulta = Teleconsulta::find($request->idTeleconsulta);
                $teleconsulta->estadoConsulta = '2';
                $teleconsulta->diagnostico = $request->diagnostico;
                $teleconsulta->update();

                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha finalizado correctamente',
                    'data' => $teleconsulta
                ], 201);

       
            
         
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde',
                'error' => $e
            ], 500);
        }
    }

    public function storeUrl(Request $request){
        $validator = Validator::make($request->all(),[
            'idTeleconsulta' => 'required',
            'url' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
    
                $teleconsulta = Teleconsulta::find($request->idTeleconsulta);
                $teleconsulta->enlace = $request->url;
                $teleconsulta->update();

                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha creado correctamente',
                    'data' => $teleconsulta
                ], 201);

       
            
         
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde',
                'error' => $e
            ], 500);
        }
    }

    public function storeRecipe(Request $request){
        $validator = Validator::make($request->all(),[
            'idTeleconsulta' => 'required',
            'archivo' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            if ($file = $request->file('archivo')) {
                $name = $file->getClientOriginalName();

                $path = $file->storeAs('recetas',$name, ['disk' => 'archivos']);
                $teleconsulta = Teleconsulta::find($request->idTeleconsulta);
                $teleconsulta->receta = $path;
                $teleconsulta->update();

                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha creado correctamente',
                    'data' => $teleconsulta
                ], 201);

       
            }
         
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde',
                'error' => $e
            ], 500);
        }
    }

    public function showPacientePending()
    {
        auth()->shouldUse('api_pacientes');
        $idPaciente = \Auth::user()->idPaciente;
      

        $teleconsultasPendientes = Teleconsulta::where('idPaciente','=', $idPaciente)
                                ->where('estadoConsulta','=',1)
                                ->where('estadoPago','=',1)->get();

         $listTeleconsultasPendientes = array();
        foreach($teleconsultasPendientes as $teleconsultaPendiente){
            $medico = Medico::with(['especialidad'])->where('idMedico', '=', $teleconsultaPendiente->idMedico)->first();
            $date = date_create($teleconsultaPendiente->fechaHora);
            array_push($listTeleconsultasPendientes,[
                'idTeleconsulta'=>$teleconsultaPendiente->idTeleconsulta,
                'idPaciente'=>$teleconsultaPendiente->idPaciente,
                'idMedico'=>$teleconsultaPendiente->idMedico,
                'estadoConsulta'=>$teleconsultaPendiente->estadoConsulta,
                'estadoPago'=>$teleconsultaPendiente->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'enlace'=>$teleconsultaPendiente->enlace,
                'especialidad'=>$medico->especialidad->descripcion,
                'foto'=>$medico->foto,
                'nombresMedico'=>$medico->nombres,
                'apellidosMedico'=>$medico->apellidos
               
            ]);
        }
        
        return response()->json($listTeleconsultasPendientes);
        
    }

    public function showPacienteHistory()
    {
        auth()->shouldUse('api_pacientes');
        $idPaciente = \Auth::user()->idPaciente;
      

        $teleconsultasPendientes = Teleconsulta::where('idPaciente','=', $idPaciente)
                                ->where('estadoConsulta','=',2)
                                ->where('estadoPago','=',1)->get();

         $listTeleconsultasPendientes = array();
        foreach($teleconsultasPendientes as $teleconsultaPendiente){
            $medico = Medico::with(['especialidad'])->where('idMedico', '=', $teleconsultaPendiente->idMedico)->first();
            $date = date_create($teleconsultaPendiente->fechaHora);
            array_push($listTeleconsultasPendientes,[
                'idTeleconsulta'=>$teleconsultaPendiente->idTeleconsulta,
                'idPaciente'=>$teleconsultaPendiente->idPaciente,
                'idMedico'=>$teleconsultaPendiente->idMedico,
                'diagnostico'=>$teleconsultaPendiente->diagnostico,
                'receta'=>$teleconsultaPendiente->receta,
                'estadoConsulta'=>$teleconsultaPendiente->estadoConsulta,
                'estadoPago'=>$teleconsultaPendiente->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'especialidad'=>$medico->especialidad->descripcion,
                'foto'=>$medico->foto,
                'nombresMedico'=>$medico->nombres,
                'apellidosMedico'=>$medico->apellidos
               
            ]);
        }
        
        return response()->json($listTeleconsultasPendientes);
        
    }
    
    //Historial de teleconsultas del paciente en la vista del medico
    public function showPacienteHistoryMedic(Request $request)
    {   
        $teleconsultasPendientes = Teleconsulta::where('idPaciente','=', $request->idPaciente)->where('estadoConsulta','=',2)->where('estadoPago','=',1)->get();

         $listTeleconsultasPendientes = array();
        foreach($teleconsultasPendientes as $teleconsultaPendiente){
            $medico = Medico::with(['especialidad'])->where('idMedico', '=', $teleconsultaPendiente->idMedico)->first();
            $date = date_create($teleconsultaPendiente->fechaHora);
            array_push($listTeleconsultasPendientes,[
                'idTeleconsulta'=>$teleconsultaPendiente->idTeleconsulta,
                'idPaciente'=>$teleconsultaPendiente->idPaciente,
                'idMedico'=>$teleconsultaPendiente->idMedico,
                'diagnostico'=>$teleconsultaPendiente->diagnostico,
                'receta'=>$teleconsultaPendiente->receta,
                'estadoConsulta'=>$teleconsultaPendiente->estadoConsulta,
                'estadoPago'=>$teleconsultaPendiente->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'especialidad'=>$medico->especialidad->descripcion,
                'idEspecialidad'=>$medico->especialidad->idEspecialidad,
                'foto'=>$medico->foto,
                'nombresMedico'=>$medico->nombres,
                'apellidosMedico'=>$medico->apellidos
               
            ]);
        }
        
        return response()->json($listTeleconsultasPendientes);
        
    }
    

    public function showMedicPending()
    {
        auth()->shouldUse('api_medicos');
        $idMedico = \Auth::user()->idMedico;
      

        $teleconsultasPendientes = Teleconsulta::where('idMedico','=', $idMedico)
                                ->where('estadoConsulta','=',1)
                                ->where('estadoPago','=',1)->get();

         $listTeleconsultasPendientes = array();
        foreach($teleconsultasPendientes as $teleconsultaPendiente){
            $paciente = Paciente::where('idPaciente', '=', $teleconsultaPendiente->idPaciente)->first();
            //Transformar el mes de la fecha a espaniol
            setlocale(LC_TIME, "spanish");
            $mes = strftime("%B", strtotime($teleconsultaPendiente->fechaHora));
        
            $date = date_create($teleconsultaPendiente->fechaHora);
            array_push($listTeleconsultasPendientes,[
                'idTeleconsulta'=>$teleconsultaPendiente->idTeleconsulta,
                'idPaciente'=>$teleconsultaPendiente->idPaciente,
                'idMedico'=>$teleconsultaPendiente->idMedico,
                'estadoConsulta'=>$teleconsultaPendiente->estadoConsulta,
                'estadoPago'=>$teleconsultaPendiente->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'enlace'=>$teleconsultaPendiente->enlace,
                'foto'=>$paciente->foto,
                'nombresPaciente'=>$paciente->nombres,
                'apellidosPaciente'=>$paciente->apellidos,
                'mes'=>ucfirst($mes)
               
            ]);
        }
        
        return response()->json($listTeleconsultasPendientes);
        
    }

    public function showMedicHistory()
    {
        auth()->shouldUse('api_medicos');
        $idMedico = \Auth::user()->idMedico;
      

        $teleconsultasPendientes = Teleconsulta::where('idMedico','=', $idMedico)
                                ->where('estadoConsulta','=',2)
                                ->where('estadoPago','=',1)->get();

         $listTeleconsultasPendientes = array();
        foreach($teleconsultasPendientes as $teleconsultaPendiente){
            $paciente = Paciente::where('idPaciente', '=', $teleconsultaPendiente->idPaciente)->first();

            //Transformar el mes de la fecha a espaniol
            setlocale(LC_TIME, "spanish");
            $mes = strftime("%B", strtotime($teleconsultaPendiente->fechaHora));
            $date = date_create($teleconsultaPendiente->fechaHora);
            array_push($listTeleconsultasPendientes,[
                'idTeleconsulta'=>$teleconsultaPendiente->idTeleconsulta,
                'idPaciente'=>$teleconsultaPendiente->idPaciente,
                'idMedico'=>$teleconsultaPendiente->idMedico,
                'diagnostico'=>$teleconsultaPendiente->diagnostico,
                'receta'=>$teleconsultaPendiente->receta,
                'estadoConsulta'=>$teleconsultaPendiente->estadoConsulta,
                'estadoPago'=>$teleconsultaPendiente->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'mes'=>ucfirst($mes),
                'foto'=>$paciente->foto,
                'nombresPaciente'=>$paciente->nombres,
                'apellidosPaciente'=>$paciente->apellidos
               
            ]);
        }
        
        return response()->json($listTeleconsultasPendientes);
        
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          //  'idPaciente' => 'required',
            'idMedico' => 'required',
            //'diagnostico' => 'required',
            //'receta' => 'required',
            //'estadoConsulta' => 'required',
            //'estadoPago' => 'required',
            'fechaHora' => 'required',
            //'enlace' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;

            $Teleconsulta = new Teleconsulta;
            $Teleconsulta->idPaciente = $idPaciente;
            $Teleconsulta->idMedico = $request->idMedico;
            $Teleconsulta->diagnostico = $request->diagnostico;
            $Teleconsulta->receta = $request->receta;
            $Teleconsulta->estadoConsulta = 1;
            $Teleconsulta->estadoPago = 1;
            $Teleconsulta->fechaHora = $request->fechaHora;
            $Teleconsulta->enlace = $request->enlace;
            $Teleconsulta->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $Teleconsulta
            ], 201);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde',
                'error' => $e
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idPaciente' => 'required',
            'idMedico' => 'required',
            'diagnostico' => 'required',
            'receta' => 'required',
            'estadoConsulta' => 'required',
            'estadoPago' => 'required',
            'fechaHora' => 'required',
            'enlace' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }


        try
        {
            $Teleconsulta = Teleconsulta::find($request->id);
            $Teleconsulta->idPaciente = $request->idPaciente;
            $Teleconsulta->idMedico = $request->idMedico;
            $Teleconsulta->diagnostico = $request->diagnostico;
            $Teleconsulta->receta = $request->receta;
            $Teleconsulta->estadoConsulta = $request->estadoConsulta;
            $Teleconsulta->estadoPago = $request->estadoPago;
            $Teleconsulta->fechaHora = $request->fechaHora;
            $Teleconsulta->enlace = $request->enlace;
            $Teleconsulta->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $Teleconsulta
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'updated_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function remove()
    {
        return response()->json([]);
    }
}
