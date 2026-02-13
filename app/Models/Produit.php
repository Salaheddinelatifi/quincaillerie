<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'reference',
        'nom',
        'prix',
        'stock',
        'sizes',
        'sizes_prices',
        'image',
        'carton',
        'pack',
    ];

    protected $casts = [
        'sizes' => 'array',
        'sizes_prices' => 'array',
    ];


    public function commandes()
    {
        return $this->belongsToMany(
        Commande::class,
        'commande_produit',
        'produit_id',
        'commande_id'
    )->withPivot(['quantite','prix','size','carton','pack'])
     ->withTimestamps();
    }
}
