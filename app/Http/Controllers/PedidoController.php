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
    public function index(): PedidoResourceCollection
    {
        return new PedidoResourceCollection(Pedido::paginate(10));
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
        // return new PedidoResource($pedidoCompleto);
        
        
        $data = $request->only('productos');
        $pedido['productos'] = json_encode($data);
        // Pedido::insert($pedido);
        $pedido->save();
        return ('Pedido registrado exitosamente!');


    }
    
    public function update(Pedido $pedido, Request $request): PedidoResource
    {   
        $pedido->update($request->all());


        return new PedidoResource($pedido);
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return response()->json();
    }
}
