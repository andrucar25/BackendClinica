<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comentario;
use App\Models\Paciente;


class ComentarioController extends Controller
{
    public function index()
    {
        $comentario = Comentario::all();
        return response()->json($comentario);
    }

    public function showCommentaryMedic(Request $request)
    {
                
        $commentarys = Comentario::where('idMedico','=', $request->idMedico)->where('estado','=',3)->get();

        
         $listCommentarys = array();
        foreach($commentarys as $commentary){
            $paciente = Comentario::with(['paciente'])->where('idPaciente', '=', $commentary->idPaciente)->first();
            $date = date_create($commentary->fecha);

            $objetoPaciente=[
                'nombres'=>$paciente->paciente->nombres,
                'apellidos'=>$paciente->paciente->apellidos,
                'foto'=>$paciente->paciente->foto
            ];
            array_push($listCommentarys,[
                'idComentario'=>$commentary->idComentario,
                'idMedico'=>$commentary->idMedico,
                'paciente'=>$objetoPaciente,
               // 'paciente'=>$paciente->paciente,
                'puntuacion'=>$commentary->puntuacion,
                'estado'=>$commentary->estado,
                'descripcion'=>$commentary->descripcion,
                'fecha'=>date_format($date, 'd/m/Y')               
            ]);
        }
        
        return response()->json($listCommentarys);

    }

    public function storeCommentary(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'idMedico' => 'required',
            //'idPaciente' => 'required',
            'puntuacion' => 'required',
            //'estado' => 'required',
            'descripcion' => 'required',
            //'fecha' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;
            $date = date('Y-m-d');

            $comentario = new Comentario;
            $comentario->idMedico = $request->idMedico;
            $comentario->idPaciente = $idPaciente;
            $comentario->puntuacion = $request->puntuacion;
            $comentario->estado = 1;
            $comentario->descripcion = $request->descripcion;
            $comentario->fecha = $date;
            $comentario->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $comentario
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
            //'idComentario' => 'required',
            'idMedico' => 'required',
            'idPaciente' => 'required',
            'puntuacion' => 'required',
            'estado' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $comentario = Comentario::find($request->id);
            $comentario->idMedico = $request->idMedico;
            $comentario->idPaciente = $request->idPaciente;
            $comentario->puntuacion = $request->puntuacion;
            $comentario->estado = $request->estado;
            $comentario->descripcion = $request->descripcion;
            $comentario->fecha = $request->fecha;
            $comentario->update();
            
            return response()->json([
                'status' => 'update_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $comentario
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

?>