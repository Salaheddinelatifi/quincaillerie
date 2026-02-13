<?php 
namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use App\Models\Produit; 
class ProduitController extends Controller { 
    public function index() { 
        $produits = Produit::all(); 
        return view('admin.produits.index', compact('produits') );
         }
        public function create() {
             return view('admin.produits.create');
              } 
              public function store(Request $request)
{
    $request->validate([
        'reference' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'prix' => 'required|numeric',
        'stock' => 'required|integer',
        'sizes' => 'nullable|array',
        'sizes_prices' => 'nullable|array',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // IMAGE
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('produits', 'public');
    }

    // ✨ نخلي غير sizes المختارين
   $sizes = $request->sizes ?? [];
$pricesInput = $request->sizes_prices ?? [];

$finalPrices = [];

foreach ($sizes as $size) {
    if (
        isset($pricesInput[$size]) &&
        $pricesInput[$size] !== '' &&
        $pricesInput[$size] !== null
    ) {
        $finalPrices[$size] = (float) $pricesInput[$size];
    }
}


    Produit::create([
    'reference' => $request->reference,
    'nom' => $request->nom,
    'prix' => $request->prix,
    'stock' => $request->stock,

    'sizes' => array_keys($finalPrices),
    'sizes_prices' => $finalPrices,

    'image' => $imagePath,
    'carton' => $request->carton ?? 0,
    'pack' => $request->pack ?? 0,
]);


    return redirect()->route('produits.index')
        ->with('success','Produit ajouté avec succès');
}
 
                            public function edit($id) { 
                                $produit = Produit::findOrFail($id); 
                                return view('admin.produits.edit', compact('produit')); 
                                }
                                 public function update(Request $request, $id) {
                                     $request->validate(
                                        [ 'reference' => 'required|string|max:255|unique:produits,reference', 
                                        'nom' => 'required|string|max:255', 
                                        'prix' => 'required|numeric', 
                                        'stock' => 'required|integer', 
                                        'sizes' => 'nullable|array', 
                                        'image' => 'nullable|image|max:2048', 
                                        ]); $produit = Produit::findOrFail($id); 
                                        $produit->update($request->only('reference','nom','prix','stock')); 
                                        return redirect()->route('produits.index')->with('success','Produit mis à jour avec succès'); 
                                        } 
                                        public function destroy($id) {
                                             Produit::destroy($id); 
                                             return redirect()->route('produits.index'); 
                                             } 
                                             protected $fillable = ['nom', 'description', 'prix']; 
                                             public function commandes() { 
                                                return $this->belongsToMany(Commande::class, 'commande_produit') ->withPivot('quantite', 'prix', 'size'); } }