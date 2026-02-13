<?php


namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Commande;
use App\Services\SmsService;

class AdminController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $totalProduits = Produit::count();
        $totalCommandes = Commande::where('status','acceptée')->count();
        $totalRevenue = Commande::where('status','acceptée')->sum('total');

        $recentCommandes = Commande::with('client')
            ->where('status','acceptée') // فقط الطلبات المقبولة
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalClients', 
            'totalProduits', 
            'totalCommandes', 
            'totalRevenue', 
            'recentCommandes'
        ));
    }
    
    
}
