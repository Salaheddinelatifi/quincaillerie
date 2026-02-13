@extends('layouts.app')
@section('title','Mes Orders')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">📦 Mes Orders</h1>

{{-- EN ATTENTE --}}
<h2 class="text-xl font-semibold text-yellow-700 mb-3">En Attente</h2>
@forelse($pending as $o)
<div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4 mb-4 shadow hover:shadow-lg transition">
    <div class="flex justify-between mb-2">
        <div>
            <p class="font-semibold text-gray-700">{{ $o->client->nom }} | 📞 {{ $o->client->telephone }}</p>
            <small class="text-gray-500">{{ $o->created_at->format('d/m/Y H:i') }}</small>
        </div>
        <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full font-bold text-sm">En Attente</span>
    </div>

    <table class="w-full text-sm mb-2">
        <thead class="bg-yellow-100">
            <tr><th>Produit</th><th>Réf</th><th>Qté</th><th>Prix</th></tr>
        </thead>
        <tbody>
            @foreach($o->produits as $p)
            <tr class="border-b border-yellow-200">
                <td>
                    <div class="font-medium">{{ $p->nom }}</div>

                    @if($p->pivot->size)
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                            {{ $p->pivot->size }}
                        </span>
                    @endif
                    
                    @if($p->pivot->carton > 0)
                        <span class="text-xs text-gray-500 ml-1">
                            {{ $p->pivot->carton }} carton
                        </span>
                    @endif
                    
                    @if($p->pivot->pack > 0)
                        <span class="text-xs text-gray-500 ml-1">
                            {{ $p->pivot->pack }} pack
                        </span>
                    @endif
                </td>

                <td>{{ $p->reference }}</td>
                <td>{{ $p->pivot->quantite }}</td>
                <td>{{ number_format($p->pivot->prix,2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex gap-2 mt-2">
        <form method="POST" action="{{ route('admin.orders.accept',$o) }}">@csrf
            <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-500 transition">✅ Accepter</button>
        </form>
        <form method="POST" action="{{ route('admin.orders.reject',$o) }}">@csrf
            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 transition">❌ Rejeter</button>
        </form>
    </div>
</div>
@empty
<p class="text-gray-500 mb-4">Aucune commande en attente.</p>
@endforelse

{{-- HISTORIQUE --}}
<h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Historique des Commandes</h2>
@forelse($history as $o)
<div class="bg-gray-50 rounded-lg p-4 mb-3 shadow hover:shadow-lg transition">
    <div class="flex justify-between mb-2">
        <div>
            <p class="font-semibold text-gray-700">{{ $o->client->nom }} | 📞 {{ $o->client->telephone }}</p>
            <small class="text-gray-500">{{ $o->created_at->format('d/m/Y H:i') }}</small>
        </div>
        @if($o->status=='acceptée')
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-sm">Acceptée</span>
        @elseif($o->status=='rejetée')
            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-bold text-sm">Rejetée</span>
        @endif
    </div>

    <table class="w-full text-sm mb-2">
        <thead class="bg-gray-200"><tr><th>Produit</th><th>Réf</th><th>Qté</th><th>Prix</th></tr></thead>
        <tbody>
            @foreach($o->produits as $p)
            <tr class="border-b border-gray-200">
                <td>{{ $p->nom }}</td><td>{{ $p->reference }}</td>
                <td>{{ $p->pivot->quantite }}</td>
                <td>{{ number_format($p->pivot->prix,2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($o->history && is_array($o->history))
    <div class="bg-gray-100 rounded p-2 border border-gray-200 mt-2">
        <h4 class="font-semibold text-gray-700 mb-1">Historique</h4>
        <ul class="list-disc list-inside text-gray-600">
            @foreach($o->history as $h)
                <li>
                    <span class="@if($h['status']=='acceptée') text-green-600 @elseif($h['status']=='rejetée') text-red-600 @else text-yellow-600 @endif font-bold">
                        {{ ucfirst($h['status']) }}
                    </span> le {{ $h['changed_at'] }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@empty
<p class="text-gray-500">Aucune commande traitée pour l'instant.</p>
@endforelse

@endsection
