<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    // ✅ Mass assignable fields
    protected $fillable = [
        'client_id', 'total', 'status', 'history'
    ];

    // ➡ تحويل الـ history من JSON ل array تلقائياً
    protected $casts = [
        'history' => 'array',
    ];

    // ➡ علاقة مع Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // ➡ علاقة مع Produits (many-to-many) مع pivot
    public function produits()
    {
        return $this->belongsToMany(
        Produit::class,
        'commande_produit',
        'commande_id',
        'produit_id'
    )->withPivot(['quantite','prix','size','carton','pack'])
     ->withTimestamps();
    }

    // ➡ دالة لإضافة حالة جديدة للتاريخ (history)
    public function addToHistory($status)
    {
        $history = is_array($this->history) ? $this->history : [];
        $history[] = [
            'status' => $status,
            'changed_at' => now()->format('d/m/Y H:i')
        ];
        $this->history = $history;
        $this->save();
    }
}
 