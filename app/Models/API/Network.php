<?php

namespace App\Models\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Network extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'phone', 'city', 'uf', 'email', 'network_id'];
    protected $array_ids = array();

    public function godfather()
    {
        return $this->hasOne(Network::class, 'id', 'network_id');
    }

    public function filiados()
    {
        return $this->hasMany(Network::class, 'network_id', 'id')->with('filiados');
    }

    public function available($filiado)
    {
        array_push($this->array_ids,$filiado);
        $filiados =  Network::find($filiado)->filiados()->get()->toArray();
        $this->recursive($filiados);
        return Network::all()->whereNotIn('id',$this->array_ids);
    }

    public function recursive($array)
    {
        foreach ($array as $value) {
            array_push($this->array_ids, $value['id']);
            if (count($value['filiados']) > 0) {
                $this->recursive($value['filiados']);
            }
        }
    }
}
