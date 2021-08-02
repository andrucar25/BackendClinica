<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\HorarioMedico;

class HorarioMedicoController extends Controller
{
    public function index()
    {
        $horarioMedico = HorarioMedico::all();
        return response()->json($horarioMedico);
    }

    public function show($id)
    {
        
        $horarioMedico = HorarioMedico::find($id);
        return response()->json($horarioMedico);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idMedico' => 'required',
            'dia' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $horarioMedico = new HorarioMedico;
            $horarioMedico->idMedico = $request->idMedico;
            $horarioMedico->dia = $request->dia;
            $horarioMedico->horaInicio = $request->horaInicio;
            $horarioMedico->horaFin = $request->horaFin;
            $horarioMedico->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $horarioMedico
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

    public function getDates(Request $request){
        $validator = Validator::make($request->all(),[
            'idMedico' => 'required',
            'mes'=> 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try {
            $dates = \App\Models\HorarioMedico::where('idMedico', $request->idMedico)->get();
            $teleconsultas = \App\Models\Teleconsulta::where('idMedico', $request->idMedico)->get();
           
            $dates = $dates->filter(function ($value, $key) use($request){
                $datesExplode = explode("/", $value->dia);
                return $datesExplode[1] == $request->mes;
            });
            $avalibleDates= array();

            foreach($dates as $date){
                //08:00
                $horaInicioExplode = explode(":", $date->horaInicio);
                $horaFinExplode = explode(":", $date->horaFin);


                $avalibleQuantity = ($horaFinExplode[0]-$horaInicioExplode[0])*2; 

                if($horaInicioExplode[1]!=$horaFinExplode[1]){
                    $horaInicioExplode[1]==30 ? $avalibleQuantity-- : $avalibleQuantity++;
                }             

                $avalibleHours= array($date->horaInicio);

                if($horaInicioExplode[1]=='30'){
                    $horaInicioExplode[0] = sprintf("%02d", $horaInicioExplode[0]+1);
                    $horaInicioExplode[1] = '00';
                }else{
                    $horaInicioExplode[1] = '30';
                }

                for($i = 1; $i <= $avalibleQuantity; $i++)
                {
                    array_push($avalibleHours,$horaInicioExplode[0] . ':' . $horaInicioExplode[1]);
                    if($horaInicioExplode[1]=='30'){
                        $horaInicioExplode[0] = sprintf("%02d", $horaInicioExplode[0]+1);
                        $horaInicioExplode[1] = '00';
                    }else{
                        $horaInicioExplode[1] = '30';
                    }

                }
                /*
                SUSTENTACION DE CALCULO DE HORAS
                 return $avalibleHours;
                 */
                $avalibleHoursValidate = $avalibleHours;
                foreach($teleconsultas as $teleconsulta){
                    $dateFormat = date_create($teleconsulta->fechaHora);
                    if(date_format($dateFormat, 'd/m/Y') == $date->dia)
                    {
                        for($i = 0; $i < $avalibleQuantity; $i++)
                        {
                          
                            if($avalibleHours[$i]==  date_format($dateFormat,  'H:i')){
                                // array_push($avalibleDates, date_format($dateFormat,  'H:i'));
                                unset($avalibleHoursValidate[$i]);
                             
                            }
                        }
                    }

                }
                $avalibleHoursValidate = array_values($avalibleHoursValidate);
                if(count($avalibleHoursValidate) != 0 ){
                    array_push($avalibleDates,[
                        'idHorarioMedico'=>$date->idHorarioMedico,
                        'dia'=> $date->dia,
                        'horasDisponibles'=>$avalibleHoursValidate
                    ]);
                }
            }
    
            return $avalibleDates;
            

        }
        catch(Exception $e)
        {
            return response()->json([
                'status' => 'get_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idMedico' => 'required',
            'dia' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }


        try
        {
            $horarioMedico = HorarioMedico::find($request->id);
            $horarioMedico->idMedico = $request->idMedico;
            $horarioMedico->dia = $request->dia;
            $horarioMedico->horaInicio = $request->horaInicio;
            $horarioMedico->horaFin = $request->horaFin;
            $horarioMedico->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $horarioMedico
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
