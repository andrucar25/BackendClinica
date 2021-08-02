<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FarmaciaPedido;


class farmaciaPedidoController extends Controller
{
    public function index()
    {
        $farmaciaPedido = FarmaciaPedido::all();
        return response()->json($farmaciaPedido);
    }

    public function show($id)
    {
        $farmaciaPedido = FarmaciaPedido::find($id);
        return response()->json($farmaciaPedido);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //'idfarmaciaPedido' => 'required',
            'idTeleconsulta' => 'required',
            'estado' => 'required',
            'metodoPago' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $farmaciaPedido = new FarmaciaPedido;
            $farmaciaPedido->idTeleconsulta = $request->idTeleconsulta;
            $farmaciaPedido->estado = $request->estado;
            $farmaciaPedido->metodoPago = $request->metodoPago;
            $farmaciaPedido->descripcion = $request->descripcion;
            $farmaciaPedido->direccion = $request->direccion;
            $farmaciaPedido->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $farmaciaPedido
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
            //'idfarmaciaPedido' => 'required',
            'idTeleconsulta' => 'required',
            'estado' => 'required',
            'metodoPago' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $farmaciaPedido = FarmaciaPedido::find($request->id);
            $farmaciaPedido->idTeleconsulta = $request->idTeleconsulta;
            $farmaciaPedido->estado = $request->estado;
            $farmaciaPedido->metodoPago = $request->metodoPago;
            $farmaciaPedido->descripcion = $request->descripcion;
            $farmaciaPedido->direccion = $request->direccion;
            $farmaciaPedido->update();
            
            return response()->json([
                'status' => 'update_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $farmaciaPedido
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