<?php

namespace App\Http\Controllers;

use App\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class MedicoController extends Controller
{
    public function index()
    {
        $users = Medico::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = Medico::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|unique:medico',
            'cv' => 'required',
            'foto' => 'required',
            'password' => 'required',
            'idEspecialidad' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $user = Medico::create([
            'nombres' => $request->get('nombres'),
            'apellidos' => $request->get('apellidos'),
            'email' => strtolower($request->get('email')),
            'cv' => $request->get('cv'),
            'foto' => $request->get('foto'),
            'password' => bcrypt($request->get('password')),
            'estado' => 1,
            'idEspecialidad' => $request->get('idEspecialidad'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
       /*$validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required',
            'cv' => 'required',
            'foto' => 'foto,jpg',
            'password' => 'required',
            'estado' => 'required',
            'idEspecialidad' => 'required',
        ]);*/

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $medico = new Paciente();
            $medico->nombres = $request->nombres;
            $medico->apellidos = $request->apellidos;
            $medico->email = strtolower($request->email);
            $medico->cv = $request->cv;
            $medico->foto = $request->foto;
            $medico->password = bcrypt($request->password);
            $medico->estado = $request->estado;
            $medico->idEspecialidad = $request->idEspecialidad;

            $medico->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $medico
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
}
