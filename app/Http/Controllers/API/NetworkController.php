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
        //  $this->validate($request, [
        //     'name' => 'required|max:55|min:8',
        //     'phone' => 'required|unique:networks,phone|max:15|min:10',
        //     'city' => 'required|max:55',
        //     'uf' => 'required|max:2',
        //     'network_id' => 'nullable',
        // ]);
               
        return Network::create([
            'name' => $request->name,
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

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'uf' => 'required',
            'city' => 'required',
        ]);

        $network = Network::findOrFail($id);

        $network->update($request->all());
    }

    public function destroy($id)
    {
        $network = Network::findOrFail($id);
        $network->delete();
        return response()->json([
            'message' => 'Network deleted successfully'
        ]);
    }
    public function network($filiado)
    {
        $network = Network::find($filiado);
        return new NetworkResource($network->with('filiados')->find($filiado));
    }
}
