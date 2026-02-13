@extends('store.layout')

@section('title','Confirmation')

@section('content')

<div class="confirm-container reveal">

    <div class="checkmark">
        ✓
    </div>

    <h1>Commande envoyée avec succès</h1>
    <p>
        .شكراً لثقتك بنا 🙏     سيتم تأكيد طلبك من طرف الإدارة في أقرب وقت
    </p>

    <a href="{{ route('store.index') }}" class="btn-primary big">
        🛒 Retour au store
    </a>

</div>

@endsection
