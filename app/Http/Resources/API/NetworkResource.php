<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class NetworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = array(
            'Nome'=>$this->name,
            'E-mail'=>$this->email,
            'Telefone'=>$this->phone,
            'Local' => "{$this->city}/{$this->uf}",
            
        );
        (count($this->filiados)) ? $resource['Filiado'] = NetworkResource::collection($this->filiados):
        $resource['Filiado'] = "Sem filiados.";
        
        return $resource;
    }
}
