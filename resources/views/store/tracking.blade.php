@extends('store.layout')

@section('title','Tracking Commande')

@section('content')
<h1 class="page-title reveal">📦 Suivi de commande</h1>

<!-- Formulaire de recherche par téléphone -->
<form method="POST" action="{{ route('store.tracking.check') }}" class="tracking-form card reveal">
    @csrf
    <input type="text" name="telephone" placeholder="Téléphone du client" required>
    <button class="btn-primary big">🔍 Suivre</button>
</form>

@if(isset($commandes) && $commandes->count() > 0)
    <div class="tracking-container">
        @foreach($commandes as $commande)
        <div class="order-card reveal">
            <div class="order-left">
                <h3>Commande #{{ $commande->id }}</h3>
                <small>Date: {{ $commande->created_at->format('d/m/Y H:i') }}</small>
                <small>Montant: {{ number_format($commande->total, 2) }} DH</small>
            </div>
            <div class="order-right">
                @if($commande->status == 'en_attente')
                    <span class="status attente">⏳ En attente</span>
                @elseif($commande->status == 'acceptée')
                    <span class="status accepte">✅ Acceptée</span>
                @else
                    <span class="status rejete">❌ Rejetée</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@elseif(isset($commandes))
    <div class="error-box reveal">Aucune commande trouvée pour ce numéro.</div>
@endif
@endsection
