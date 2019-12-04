<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoResourceCollection;
use App\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * @param Pedido $pedido
     * @return Pedido Resource
     */
    public function show(Pedido $pedido): PedidoResource
    {
        return new PedidoResource($pedido);
    }

    /**
     * @return PedidoResourceCollection
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar=='') {
            //Creando un array de tipo Alumno(model)
            $pedidos = Pedido::orderBy('id', 'desc')->paginate(20);
        }
        else {
            $pedidos = Pedido::where($criterio, 'like', '%' . $buscar . '%' )->orderBy('id', 'desc')->paginate(20);
        }
        // return new PedidoResourceCollection(Pedido::paginate(10));
        return[
            'pagination' => [
                'total'        => $pedidos->total(),
                'current_page' => $pedidos->currentPage(),
                'per_page'     => $pedidos->perPage(),
                'last_page'    => $pedidos->lastPage(),
                'from'         => $pedidos->firstItem(),
                'to'           => $pedidos->lastItem(),
            ],
            'pedidos' => $pedidos
        ];
    }

    /**
     * @return 
     */

    public function store(Request $request)
    {
        // $request->validate([
        //     //'productos' => 'required',
        //     'fecha' => 'required',
        //     'nombre_cliente' => 'required',
        //     // 'observaciones' => 'required',
        //     'sala' => 'required',
        //     'asiento' => 'required',
        //     'hora' => 'required',
        //     'estado' => 'required',
        // ]);

        // $pedido = Pedido::create($request->all());
        $pedido = new Pedido();
        $pedido->fecha = $request->fecha;
        $pedido->nombre_cliente = $request->nombre_cliente;
        $pedido->observaciones = $request->observaciones;
        $pedido->sala = $request->sala;
        $pedido->asiento = $request->asiento;
        $pedido->hora = $request->hora;
        $pedido->estado = $request->estado;
        
        
        $data = $request->only('productos');
        $pedido['productos'] = json_encode($data);
        // Pedido::insert($pedido);
        $pedido->save();
        return new PedidoResource($pedido);
        // return ('Pedido registrado exitosamente!');


    }
    
    public function update(Pedido $pedido, Request $request)
    {   
        $pedido->update($request->all());


        // return new PedidoResource($pedido);
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return response()->json();
    }

    public function actualizar_Proceso(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        // if(!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = 'En proceso';
        $pedido->save();
    }

    public function actualizar_Recibido(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        // if(!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = 'Recibido';
        $pedido->save();
    }
}
