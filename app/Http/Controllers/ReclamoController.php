<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Reclamo;

class ReclamoController extends Controller
{
    public function index()
    {
        $Reclamo = Reclamo::all();
        return response()->json($Reclamo);
    }

    public function show($id)
    {
        
        $Reclamo = Reclamo::find($id);
        return response()->json($Reclamo);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'descripcion' => 'required',
            //'fecha' => 'required',
            //'estado' => 'required',
           // 'archivo' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {   auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;
            $date = date('Y-m-d');

            if ($file = $request->file('archivo')) {
                $name = $file->getClientOriginalName();

                $path = $file->storeAs('reclamos',$name, ['disk' => 'archivos']);
      
                $Reclamo = new Reclamo;
                $Reclamo->tipo = $request->tipo;
                $Reclamo->descripcion = $request->descripcion;
                $Reclamo->idPaciente = $idPaciente;
                $Reclamo->fecha = $date;
                $Reclamo->estado = 1;
                $Reclamo->archivo = $name;
                $Reclamo->save();
                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha creado correctamente',
                    'data' => $Reclamo
                ], 201);

       
            }
            else{
                $Reclamo = new Reclamo;
                $Reclamo->tipo = $request->tipo;
                $Reclamo->descripcion = $request->descripcion;
                $Reclamo->idPaciente = $idPaciente;
                $Reclamo->fecha = $date;
                $Reclamo->estado = 1;
                $Reclamo->archivo = $request->archivo;
                $Reclamo->save();
                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha creado correctamente',
                    'data' => $Reclamo
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'descripcion' => 'required',
            'idPaciente' => 'required',
            'fecha' => 'required',
            'estado' => 'required',
           // 'archivo' => 'required'
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }


        try
        {
            $Reclamo = Reclamo::find($request->id);
            $Reclamo->tipo = $request->tipo;
            $Reclamo->descripcion = $request->descripcion;
            $Reclamo->idPaciente = $request->idPaciente;
            $Reclamo->fecha = $request->fecha;
            $Reclamo->estado = $request->estado;
            $Reclamo->archivo = $request->archivo;
            $Reclamo->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $Reclamo
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
