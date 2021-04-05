<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Network extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','phone','city','uf','email', 'network_id'];

    public function godfather(){
        return $this->hasOne(Network::class,'id','network_id');
    }

    public function filiados()
    {
        return $this->hasMany(Network::class,'network_id','id')->with('filiados')->where('id','<>',$this->id);
    }
}
