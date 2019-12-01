<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
                // $productosjson = json_encode($request);
                return [
                    'id' => $this->id,
                    // 'productos' => $this->productos,
                    'productos' => [
                        'producto_id' =>$this->producto_id,
                        'nombre' =>$this->nombre,
                        'cantidad' =>$this->cantidad,
                    ],
                    
                    'fecha' => $this->fecha,
                    'nombre_cliente' => $this->nombre_cliente,
                    'observaciones' => $this->observaciones,
                    'sala' => $this->sala,
                    'asiento' => $this->asiento,
                    'hora' => $this->hora,
                    'estado' => $this->estado,
                ];
                // return parent::toArray($request);
    }
}
