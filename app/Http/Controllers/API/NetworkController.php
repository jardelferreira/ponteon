<?php

namespace App\Http\Controllers\API;

use App\Models\API\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\NetworkRequest;
use App\Http\Resources\API\NetworkResource;

class NetworkController extends Controller
{
    public function index()
    {
        return Network::latest()->with('godfather')->paginate();
    }

    public function store(NetworkRequest $request)
    {
                
        return Network::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'uf' => $request->uf,
            'city' => $request->city,
            'network_id' => $request->network_id
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(NetworkRequest $request, $id)
    {

        $network = Network::findOrFail($id);

        $network->update($request->all());
    }

    public function destroy($id)
    {
        $network = Network::findOrFail($id);
        $network->delete();
        return response()->json([
            'message' => 'Empresário deletado com sucesso!'
        ]);
    }
    public function network($filiado)
    {
        $network = Network::find($filiado);
        return \view('rede',[
            'data' => ($network->with('filiados')->find($filiado))
        ]);
        // return ($network->with('filiados')->find($filiado)->get());
    }
    public function available(Network $network, $filiado)
    {
        return $network->available($filiado);
    }
}
