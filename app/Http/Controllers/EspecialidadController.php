<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    public function index()
    {
        $ubigeos = Especialidad::all();
        return response()->json($ubigeos);
    }

    public function show($id)
    {
        $ubigeo = Especialidad::find($id);
        return response()->json($ubigeo);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:100'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $especialidad = new Especialidad();
            $especialidad->descripcion = $request->descripcion;
            $especialidad->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $especialidad
            ], 201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:100'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $especialidad = Especialidad::find($request->id);
            $especialidad->descripcion = $request->descripcion;
            $especialidad->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $especialidad
            ]);
        }
        catch(\Exception $e)
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
