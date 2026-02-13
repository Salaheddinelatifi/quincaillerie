@extends('admin.layout')
@section('title', 'Commande #'.$commande->id)

@section('content')
<div class="card p-4">

    <h4 class="mb-3">Client: {{ $commande->client->nom ?? 'Client inconnu' }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Size</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $p)
            <tr>
                <td>{{ $p->nom }}</td>
                <td>{{ $p->pivot->quantite }}</td>
                <td>{{ number_format($p->pivot->prix,2) }} DH</td>
                <td>{{ $p->pivot->size ?? '-' }}</td>
                <td>{{ number_format($p->pivot->prix * $p->pivot->quantite,2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 fw-bold text-end">
        Total Commande: {{ number_format($commande->total,2) }} DH
    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('commandes.facture', $commande) }}" class="btn btn-primary">
            🧾 مشاهدة الفاتورة
        </a>
    </div>
</div>
@endsection
