<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
{
    $pending = Commande::with(['client','produits'])
        ->where('status', 'en_attente')
        // ->orderBy('created_at','desc')
        ->get();

    $history = Commande::with(['client','produits'])
        ->whereIn('status',['acceptée','rejetée'])
        ->orderBy('created_at','desc')
        ->get();

    return view('admin.orders.index', compact('pending','history'));

}

    public function accept(Commande $commande)
    {
        $commande->update(['status' => 'acceptée']);

        foreach ($commande->produits as $p) {
            $p->decrement('stock', $p->pivot->quantite);
        }

        $history = $commande->history ?? [];
        $history[] = [
            'status' => 'acceptée',
            'changed_at' => now()->format('d/m/Y H:i')
        ];

        $commande->update(['history' => $history]);

        return back()->with('success','Commande acceptée');
    }

    public function reject(Commande $commande)
    {
        $commande->update(['status' => 'rejetée']);

        $history = $commande->history ?? [];
        $history[] = [
            'status' => 'rejetée',
            'changed_at' => now()->format('d/m/Y H:i')
        ];

        $commande->update(['history' => $history]);

        return back()->with('error','Commande rejetée');
    }
}
