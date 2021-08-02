<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ArchivoTeleconsulta;
use App\Models\Teleconsulta;
use App\Models\Paciente;
use App\Models\Medico;

class ArchivoTeleconsultaController extends Controller
{
    public function index(Request $request)
    {
        $archivosTeleconsulta = ArchivoTeleconsulta::where('idTeleconsulta','=', $request->id)->get();
        $listArchivos = array();
        foreach($archivosTeleconsulta as $archivoTeleconsulta){
            $medico = Medico::with(['especialidad'])->where('idMedico', '=', $archivoTeleconsulta->teleconsulta->idMedico)->first();
            $date = date_create($archivoTeleconsulta->teleconsulta->fechaHora);
            $objetoTeleconsulta= [
                'idTeleconsulta'=>$archivoTeleconsulta->teleconsulta->idTeleconsulta,
                'idPaciente'=>$archivoTeleconsulta->teleconsulta->idPaciente,
                'idMedico'=>$archivoTeleconsulta->teleconsulta->idMedico,
                'diagnostico'=>$archivoTeleconsulta->teleconsulta->diagnostico,
                'receta'=>$archivoTeleconsulta->teleconsulta->receta,
                'estadoConsulta'=>$archivoTeleconsulta->teleconsulta->estadoConsulta,
                'estadoPago'=>$archivoTeleconsulta->teleconsulta->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'enlace'=>$archivoTeleconsulta->teleconsulta->enlace,
                'especialidad'=>$medico->especialidad->descripcion,
                'foto'=>$medico->foto,
                'nombresMedico'=>$medico->nombres,
                'apellidosMedico'=>$medico->apellidos
               
            ];
            array_push($listArchivos,[
                'idArchivoTeleconsulta'=>$archivoTeleconsulta->idArchivoTeleconsulta,
                'teleconsulta'=>$objetoTeleconsulta,
                'archivo'=>$archivoTeleconsulta->archivo
               
            ]);
        }
        return response()->json($listArchivos);
    }

    public function indexMedico(Request $request)
    {
        $archivosTeleconsulta = ArchivoTeleconsulta::where('idTeleconsulta','=', $request->id)->get();
        $listArchivos = array();
        foreach($archivosTeleconsulta as $archivoTeleconsulta){
            $medico = Medico::with(['especialidad'])->where('idMedico', '=', $archivoTeleconsulta->teleconsulta->idMedico)->first();
            $date = date_create($archivoTeleconsulta->teleconsulta->fechaHora);
               //Transformar el mes de la fecha a espaniol
               setlocale(LC_TIME, "spanish");
               $mes = strftime("%B", strtotime($archivoTeleconsulta->teleconsulta->fechaHora));
            $objetoTeleconsulta= [
                'idTeleconsulta'=>$archivoTeleconsulta->teleconsulta->idTeleconsulta,
                'idPaciente'=>$archivoTeleconsulta->teleconsulta->idPaciente,
                'idMedico'=>$archivoTeleconsulta->teleconsulta->idMedico,
                'diagnostico'=>$archivoTeleconsulta->teleconsulta->diagnostico,
                'receta'=>$archivoTeleconsulta->teleconsulta->receta,
                'estadoConsulta'=>$archivoTeleconsulta->teleconsulta->estadoConsulta,
                'estadoPago'=>$archivoTeleconsulta->teleconsulta->estadoPago,
                'fecha'=> date_format($date, 'd/m/Y'),
                'hora'=> date_format($date,  'H:i'),
                'enlace'=>$archivoTeleconsulta->teleconsulta->enlace,
                'especialidad'=>$medico->especialidad->descripcion,
                'foto'=>$archivoTeleconsulta->teleconsulta->paciente->foto,
                'nombresPaciente'=>$archivoTeleconsulta->teleconsulta->paciente->nombres,
                'apellidosPaciente'=>$archivoTeleconsulta->teleconsulta->paciente->apellidos,
                'mes'=>$mes,
               
            ];
            array_push($listArchivos,[
                'idArchivoTeleconsulta'=>$archivoTeleconsulta->idArchivoTeleconsulta,
                'teleconsulta'=>$objetoTeleconsulta,
                'archivo'=>$archivoTeleconsulta->archivo
               
            ]);
        }
        return response()->json($listArchivos);
    }

    

    public function show($id)
    {
        $archivoTeleconsulta = ArchivoTeleconsulta::find($id);
        return response()->json($archivoTeleconsulta);
    }

    public function store(Request $request)
    {
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

                $path = $file->storeAs('archivos',$name, ['disk' => 'archivos']);
      
                //store your file into directory and db
                $archivoTeleconsulta = new ArchivoTeleconsulta;
                $archivoTeleconsulta->idTeleconsulta = $request->idTeleconsulta;
                $archivoTeleconsulta->archivo = $path;
                $archivoTeleconsulta->save();
                
                return response()->json([
                    'status' => 'register_ok',
                    'message' => 'Se ha creado correctamente',
                    'data' => $archivoTeleconsulta
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
        $validator = Validator::make($request->all(),[
            //'idArchivoTeleconsulta' => 'required',
            'idTeleconsulta' => 'required',
            'archivo' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $archivoTeleconsulta = ArchivoTeleconsulta::find($request->id);
            $archivoTeleconsulta->idTeleconsulta = $request->idTeleconsulta;
            $archivoTeleconsulta->archivo = $request->archivo;
            $archivoTeleconsulta->update();
            
            return response()->json([
                'status' => 'update_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $archivoTeleconsulta
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