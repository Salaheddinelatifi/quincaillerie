<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Commande;

class StoreTrackingController extends Controller
{
    public function index()
    {
        return view('store.tracking');
    }

    public function check(Request $request)
    {
        $request->validate([
            'telephone' => 'required'
        ]);

        $client = Client::where('telephone', $request->telephone)->first();

        if(!$client){
            return view('store.tracking', ['commandes' => collect()]);
        }

        $commandes = Commande::where('client_id', $client->id)
                        ->orderBy('created_at','desc')
                        ->get();

        return view('store.tracking', compact('commandes'));
    }
    
}
