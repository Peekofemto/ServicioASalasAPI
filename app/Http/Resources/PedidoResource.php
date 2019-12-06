<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductoResourceCollection;
use App\Http\Resources\ProductoResource;
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
        $data = $this->productos;
        $productos = json_decode($data);
        return [
            'id' => $this->id,
            $productos,
            'fecha' => $this->fecha,
            'nombre_cliente' => $this->nombre_cliente,
            'observaciones' => $this->observaciones,
            'sala' => $this->sala,
            'asiento' => $this->asiento,
            'hora' => $this->hora,
            'estado' => $this->estado,
            'codigo_cliente' => $this->codigo_cliente,
            'puntos' => $this->puntos,
            'costo_final' => $this->costo_final,
        ];
        // return parent::toArray($request);
    }
}
