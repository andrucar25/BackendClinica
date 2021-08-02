<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Culqi\Culqi;
use Illuminate\Support\Facades\Validator;
use Culqi\CulqiException;


class PaymentController extends Controller
{
    public function orderCharge(Request $request){
        $validator = Validator::make($request->all(), [

            'token' => 'required',

            'email' => 'required|max:100',

            'description' => 'required|max:80',

            'amount' => 'required|max:100'
        ]);
        if($validator->fails())

        {

            return response()->json($validator->errors(), 400);

        }else{
            auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;
            $nombres = \Auth::user()->nombres;
            $apellidos = \Auth::user()->apellidos;
            $telefono = \Auth::user()->telefono;

            $token=$request->token;
            $email=$request->email;
            $description=$request->description;
            $descriptionPaciente=$apellidos." ".$description;
            $amount=$request->amount;


            $SECRET_KEY = "sk_test_5bd0485f446376c6";
            $culqi = new Culqi(array('api_key' => $SECRET_KEY));
             
            $arrayCharge =   array(
                "amount" => $amount,
                "currency_code" => "PEN",
                "description" => $descriptionPaciente,
                "email" =>  $email,
                "antifraud_details" => array(
                    "address_city" => "TACNA",
                    "country_code" => "PE",
                    "first_name" => $nombres,
                    "last_name" => $apellidos,
                    "phone_number" => $telefono ,
                ),
                "source_id" => $token
            );
            try{
            $cargo = $culqi->Charges->create($arrayCharge);

            if($cargo->object == 'charge'){
                return response()->json(['status' => 'success', 'message' => $cargo->outcome->user_message]);  
            }else{
                return response()->json(['status' => 'failed', 'message' => $cargo->user_message]);    
            }
        }catch(\Exception $e){
           
         return response()->json(['status' => 'failed', 'message' => 'No se ha podido realizar el pago. Inténtalo de nuevo más tarde.']);
            
          }
        }

      
    }

    public function orderChargeChat(Request $request){
        $validator = Validator::make($request->all(), [

            'token' => 'required',

            'email' => 'required|max:100',

            'amount' => 'required|max:100'
        ]);
        if($validator->fails())

        {

            return response()->json($validator->errors(), 400);

        }else{
            auth()->shouldUse('api_pacientes');
            $idPaciente = \Auth::user()->idPaciente;
            $nombres = \Auth::user()->nombres;
            $apellidos = \Auth::user()->apellidos;
            $telefono = \Auth::user()->telefono;

            $token=$request->token;
            $email=$request->email;
            $descriptionPaciente=$apellidos." "."desbloquea chat";
            $amount=$request->amount;


            $SECRET_KEY = "sk_test_5bd0485f446376c6";
            $culqi = new Culqi(array('api_key' => $SECRET_KEY));
             
            $arrayCharge =   array(
                "amount" => $amount,
                "currency_code" => "PEN",
                "description" => $descriptionPaciente,
                "email" =>  $email,
                "antifraud_details" => array(
                    "address_city" => "TACNA",
                    "country_code" => "PE",
                    "first_name" => $nombres,
                    "last_name" => $apellidos,
                    "phone_number" => $telefono ,
                ),
                "source_id" => $token
            );
            try{
            $cargo = $culqi->Charges->create($arrayCharge);

            if($cargo->object == 'charge'){
                return response()->json(['status' => 'success', 'message' => $cargo->outcome->user_message]);  
            }else{
                return response()->json(['status' => 'failed', 'message' => $cargo->user_message]);    
            }
        }catch(\Exception $e){
           
         return response()->json(['status' => 'failed', 'message' => 'No se ha podido realizar el pago. Inténtalo de nuevo más tarde.']);
            
          }
        }

      
    }
}
