<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Client;
use App\Notifications\NewCommandeNotification;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    // عرض جميع الطلبات
    public function index()
    {
        $commandes = Commande::with('client','produits')->get();
        return view('admin.commandes.index', compact('commandes'));
    }

    // form إنشاء طلبية
    public function create()
    {
        $produits = Produit::all();
        return view('admin.commandes.create', compact('produits'));
    }

    // حفظ الطلبية
    public function store(Request $request)
{
    $request->validate([
        'client_id'  => 'nullable|exists:clients,id',
        'new_client' => 'nullable|string|max:255',
        'produits'   => 'required|array|min:1',
    ]);

    // client
    if ($request->filled('client_id')) {
        $client_id = $request->client_id;
    } elseif ($request->filled('new_client')) {
        $client = Client::create(['nom' => $request->new_client]);
        $client_id = $client->id;
    } else {
        return back()->with('error', 'خاصك تختار client');
    }

    // create commande
    $commande = Commande::create([
        'client_id' => $client_id,
        'total'     => 0,
        'status'    => 'en_attente', // ⚠️ ثابت
    ]);

    $total = 0;

    foreach ($request->produits as $p) {

        $produit = Produit::find($p['id']);
        if (!$produit) continue;

        foreach ($p['qte'] as $key => $qte) {

            $quantite = (int)$qte;
            if ($quantite <= 0) continue;

            $size = $p['size'][$key] ?? null;
            $prix = $produit->prix;

            $cartonQty = (int)$produit->carton;
            $packQty   = (int)$produit->pack;

            $reste = $quantite;
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

            // attach pivot
            $commande->produits()->attach($produit->id, [
                'quantite' => $quantite,
                'prix'     => $prix,
                'size'     => $size,
                'carton'   => $nbCarton,
                'pack'     => $nbPack,
                'reste'    => $reste,
            ]);

            $total += $prix * $quantite;
        }
    }

    $commande->update(['total' => $total]);

    return redirect()
        ->route('commandes.facture', $commande->id)
        ->with('success', 'Commande ajoutée');
}


    // عرض الطلبية
    public function show($id)
    {
        $commande = Commande::with('client','produits')->findOrFail($id);
        return view('admin.commandes.show', compact('commande'));
    }

    // فاتورة PDF/HTML
    public function facture($id)
    {
        $commande = Commande::with('client','produits')->findOrFail($id);

        if($commande->status != 'acceptée'){
            abort(403,'Facture متاحة فقط للطلبات المقبولة');
        }

        return view('admin.commandes.facture', compact('commande'));
    }

    // حذف الطلبية
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->produits()->detach();
        $commande->delete();

        return redirect()->route('commandes.index')->with('success','تم حذف الطلبية بنجاح');
    }
}
