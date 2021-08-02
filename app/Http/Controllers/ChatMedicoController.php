<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ChatMedico;
use App\Models\Paciente;


class ChatMedicoController extends Controller
{
    public function index()
    {
        $chatMedico = ChatMedico::all();
        return response()->json($chatMedico);
    }

    public function show($id)
    {
        $chatMedico = ChatMedico::find($id);
        return response()->json($chatMedico);
    }

    public function searchChatPaciente()
    {
        auth()->shouldUse('api_pacientes');
        $idPaciente = \Auth::user()->idPaciente;
      
        
    

        $chatMedico = ChatMedico::where('idPaciente','=', $idPaciente)
                                ->where('estado','=',1)->get();

        if($chatMedico->count()>0)
        {
            
            return response()->json([
                'status' => 'Existe',
                'message' => 'Se ha creado correctamente'
            ], 201);
        }
       else{

            return response()->json([
                'status' => 'Vacio',
                'message' => 'Se ha creado correctamente'
            ], 201);

           // return "No existe";
        }
        
       /* $arr = (array)$chatMedico;
        $conteo =  count($arr);
        return $conteo;
      return response()->json($chatMedico);*/
       
        
        
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'idMedico' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;

            $chatMedico = new ChatMedico;
            $chatMedico->idPaciente = $idPaciente;
            $chatMedico->idMedico = $request->idMedico;
            $chatMedico->estado = 1;
            $chatMedico->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $chatMedico
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
        $validator = Validator::make($request->all(),[
            //'idChatMedico' => 'required',
            'idPaciente' => 'required',
            'idMedico' => 'required',
            'estado' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $chatMedico = ChatMedico::find($request->id);
            $chatMedico->idPaciente = $request->idPaciente;
            $chatMedico->idMedico = $request->idMedico;
            $chatMedico->estado = $request->estado;
            $chatMedico->update();
            
            return response()->json([
                'status' => 'update_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $chatMedico
            ], 201);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'update_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde',
                'error' => $e
            ], 500);
        }
    }

    public function remove()
    {
        return response()->json([]);
    }

}

