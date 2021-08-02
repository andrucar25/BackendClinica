<?php

namespace App\Http\Controllers;

use App\Paciente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $users = Paciente::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = Paciente::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'password' => 'required',
            'estado' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user = new Paciente();
            $user->dni = $request->dni;
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->email = strtolower($request->email);
            $user->telefono = $request->telefono;
            $user->password = bcrypt($request->password);
            $user->estado = $request->estado;
            $user->foto = $request->foto;
            $user->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $user
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
            'id' => 'required',
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'password' => 'required',
            'estado' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user = Paciente::find($request->id);
            $user->dni = $request->dni;
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->email = strtolower($request->email);
            $user->telefono = $request->telefono;
            $user->password = bcrypt($request->password);
            $user->estado = $request->estado;
            $user->foto = $request->foto;
            $user->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $user
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


}
