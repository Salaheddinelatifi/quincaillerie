<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Client;

class StoreController extends Controller
{   
    // 🛒 Page store
    public function index()
    {
        $produits = Produit::where('stock','>',0)->get();
        return view('store.index', compact('produits'));
    }

    // ✅ Store order
    public function store(Request $request)
    {
        // 🔒 Validation
        $request->validate([
            'client_nom'       => 'required|string',
            'client_telephone' => 'required|string',
            'mode_paiement'    => 'required',
        ]);

        // 👤 Create client
        $client = Client::create([
            'nom'       => $request->client_nom,
            'telephone' => $request->client_telephone,
        ]);

        // 📦 Create commande
        $commande = Commande::create([
            'client_id'     => $client->id,
            'mode_paiement' => $request->mode_paiement,
            'status'        => 'en_attente', // ⚠️ status ماشي statut
            'total'         => 0,
        ]);

        $total = 0;

        // 📦 Attach produits
        if ($request->has('produits')) {

            foreach ($request->produits as $produit_id => $data) {
    $produit = Produit::find($produit_id);
    if (!$produit) continue;

    $quantites = is_array($data['quantite']) ? $data['quantite'] : [$data['quantite']];
    $sizes     = is_array($data['size'] ?? null) ? $data['size'] : [$data['size'] ?? null];

    foreach ($quantites as $i => $qte) {

    $qte  = (int) $qte;
    $size = $sizes[$i] ?? null;

    if ($qte <= 0) continue;

    $cartonQty = (int) $produit->carton;
    $packQty   = (int) $produit->pack;

    $reste = $qte;
    $nbCarton = 0;
    $nbPack = 0;

    if ($cartonQty > 0 && $reste >= $cartonQty) {
        $nbCarton = intdiv($reste, $cartonQty);
        $reste = $reste % $cartonQty;
    }

    if ($packQty > 0 && $reste >= $packQty) {
        $nbPack = intdiv($reste, $packQty);
        $reste = $reste % $packQty;
    }

    $price = $produit->sizes_prices[$size] ?? $produit->prix;

    $commande->produits()->attach($produit->id, [
        'quantite' => $qte,
        'prix'     => $price,
        'size'     => $size,
        'carton'   => $nbCarton,
        'pack'     => $nbPack,
        
    ]);

    $total += $price * $qte;
}

    
}

        }

        // 💰 Update total
        $commande->update(['total' => $total]);

        // ✅ Redirect
        return redirect()->route('store.confirmation');
    }

    // 📦 Modules
    public function modules()
    {
        return view('store.module', [
            'modules' => Module::all()
        ]);
    }

    // 🪪 Carte visite
    public function carteVisite()
    {
        return view('store.cartevisite');
    }

    // 📞 Contact
    public function contact()
    {
        return view('store.contact');
    }
}
