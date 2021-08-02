<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorio;
use App\Models\Paciente;

class LaboratorioController extends Controller
{
    public function index()
    {
        $Laboratorio = Laboratorio::all();
        return response()->json($Laboratorio);
    }

    public function show($id)
    {
        
        $Laboratorio = Laboratorio::find($id);
        return response()->json($Laboratorio);
    }

    public function showLabHistory()
    {
     
       auth()->shouldUse('api_pacientes');
        $idPaciente = \Auth::user()->idPaciente;
        $laboratoriosHistorial = Laboratorio::where('idPaciente','=', $idPaciente)->get();

         $listlaboratoriosHistorial = array();
        foreach($laboratoriosHistorial as $laboratorioHistorial){
            $date = date_create($laboratorioHistorial->fecha);
            array_push($listlaboratoriosHistorial,[
                'idLaboratorio'=>$laboratorioHistorial->idLaboratorio,
                'idPaciente'=>$laboratorioHistorial->idPaciente,
                'descripcion'=>$laboratorioHistorial->descripcion,
                'fecha'=> date_format($date, 'd/m/Y'),
                'responsable'=>$laboratorioHistorial->responsable,
                'area'=>$laboratorioHistorial->area,
                'archivo'=>$laboratorioHistorial->archivo
               
            ]);
        }
        
        return response()->json($listlaboratoriosHistorial);
    }
    public function sendSMS(Request $request){
        $validator = Validator::make($request->all(), [
            'telefono' => 'required',
           
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try{
            $confirmation_number = rand(1000, 9999);
            $base_url = 'https://platform.clickatell.com/';
            $client = new Client(['base_uri' => $base_url, 'verify' => false]);
            $response = $client->request('GET', 'messages/http/send', [
                'query' => [
                    'apiKey' => 'jZiAtuWuQcGQbA8IObbmZg==',
                    'to' => '51' . $request->telefono,
                    'content' => 'Su numero de confirmacion es ' . $confirmation_number 
                ],
            ]);
            return response()->json([
                'status' => 'send',
                'number' => $confirmation_number
            ], 201);
        }   
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'error' => $e
            ], 500);
        }
  
    }
    public function store(Request $request)
    {            
       auth()->shouldUse('api_pacientes');
       $idPaciente = \Auth::user()->idPaciente;
        $validator = Validator::make($request->all(), [
            'responsable' => 'required',
            'descripcion' => 'required',
            'area' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

      

        try
        {
            $Laboratorio = new Laboratorio;
            $Laboratorio->idPaciente = $idPaciente;
            $Laboratorio->descripcion = $request->descripcion;
            $Laboratorio->fecha = date("Y-m-d"); 
            $Laboratorio->responsable = $request->responsable;
            $Laboratorio->area = $request->area;
            $Laboratorio->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $Laboratorio
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
            'descripcion' => 'required',
            'fecha' => 'required',
            'responsable' => 'required',
            'area' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }


        try
        {
            $Laboratorio = Laboratorio::find($request->id);
            $Laboratorio->idPaciente = $request->idPaciente;
            $Laboratorio->descripcion = $request->descripcion;
            $Laboratorio->fecha = $request->fecha;
            $Laboratorio->responsable = $request->responsable;
            $Laboratorio->area = $request->area;
            $Laboratorio->archivo = $request->archivo;
            $Laboratorio->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $Laboratorio
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
