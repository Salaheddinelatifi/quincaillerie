@extends('store.layout')

@section('title','Store Client')

@section('content')

<h1 class="page-title">🛒 Store Client</h1>

<form method="POST" action="{{ route('store.store') }}">
@csrf

{{-- ================= CLIENT ================= --}}
<section class="card">
    <h2>👤 Informations Client</h2>
    <input type="text" name="client_nom" placeholder="Nom complet" required>
    <input type="text" name="client_telephone" placeholder="Téléphone" required>
</section>

{{-- ================= PRODUITS ================= --}}
<h2 class="section-title">🧰 Produits</h2>

<div class="products">
@foreach($produits as $p)
<div class="product-card" data-product-id="{{ $p->id }}">

    @if($p->image)
        <img src="{{ asset('storage/'.$p->image) }}">
    @endif

    <h3>{{ $p->nom }}</h3>
    <small>Ref: {{ $p->reference }}</small>

    {{-- 💚 PRIX PRINCIPAL --}}
    <div class="price fw-bold text-success"
         data-default-price="{{ $p->prix }}">
        {{ number_format($p->prix,2) }} DH
    </div>

    <div class="product-lines">

        {{-- ===== LIGNE ===== --}}
        <div class="product-line d-flex gap-2 align-items-center mt-2">

            {{-- SIZE --}}
            @if(is_array($p->sizes) && count($p->sizes))
            <select name="produits[{{ $p->id }}][size][]" class="size-select">
                <option value="">-- Taille --</option>
                @foreach($p->sizes as $s)
                    <option value="{{ $s }}" data-price="{{ $p->sizes_prices[$s] ?? $p->prix }}">
                        {{ $s }} ({{ $p->sizes_prices[$s] ?? $p->prix }} DH)
                    </option>
                @endforeach
            </select>
            @endif

            {{-- QUANTITÉ --}}
            <input type="number"
                   name="produits[{{ $p->id }}][quantite][]"
                   class="qty-input"
                   min="1"
                   max="{{ $p->stock }}"
                   placeholder="Qté"
                   data-pack="{{ $p->pack ?? 0 }}"
                   data-carton="{{ $p->carton ?? 0 }}">

        </div>
    </div>

    {{-- ADD LINE --}}
    <button type="button" class="btn-primary btn-sm add-line mt-2">
        + Ajouter taille
    </button>

    {{-- INFO --}}
    <div class="mt-2">
        <small>Carton: {{ $p->carton ?? '-' }}</small> |
        <small>Pack: {{ $p->pack ?? '-' }}</small>
    </div>

    <span class="stock">Stock : {{ $p->stock }}</span>

</div>
@endforeach
</div>

{{-- ================= PAIEMENT ================= --}}
<section class="card mt-4">
    <h2>💳 Mode de paiement</h2>
    <label><input type="radio" name="mode_paiement" value="espece" required> Espèce</label>
    <label><input type="radio" name="mode_paiement" value="cheque"> Chèque</label>
</section>

{{-- ================= TOTAL PRICE ================= --}}
<div class="card mt-3">
    <h2>Total: <span id="total-price">0.00</span> DH</h2>
</div>

<div class="center mt-3">
    <button class="btn-primary big">✔ Valider la commande</button>
</div>

</form>

{{-- ================= JS ================= --}}
<script>
document.addEventListener('change', function(e){

    /* 🔥 CHANGE PRICE ON SIZE */
    if(e.target.classList.contains('size-select')){
        const option = e.target.selectedOptions[0];
        if(!option) return;

        const price = option.dataset.price;
        const card  = e.target.closest('.product-card');

        if(price && card){
            card.querySelector('.price').innerText =
                parseFloat(price).toFixed(2) + ' DH';
        }
        updateTotal();
        checkStock();
    }

    /* 🔒 PACK / CARTON */
    if(e.target.classList.contains('qty-input')){
        let val = parseInt(e.target.value) || 0;
        const pack = parseInt(e.target.dataset.pack);
        const carton = parseInt(e.target.dataset.carton);

        if(pack > 0){
            val = Math.floor(val / pack) * pack;
        }else if(carton > 0){
            val = Math.floor(val / carton) * carton;
        }

        e.target.value = val;
        updateTotal();
        checkStock();
    }
});

/* ➕ ADD NEW LINE */
document.addEventListener('click', function(e){
    if(e.target.classList.contains('add-line')){
        const card = e.target.closest('.product-card');
        const baseLine = card.querySelector('.product-line');
        const clone = baseLine.cloneNode(true);

        // reset values
        clone.querySelectorAll('input').forEach(i => i.value = '');
        clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);

        card.querySelector('.product-lines').appendChild(clone);

        setTimeout(() => {
            updateTotal();
            checkStock();
        }, 50);
    }
});

/* ================= TOTAL CALC ================= */
function updateTotal() {
    let total = 0;

    document.querySelectorAll('.product-card').forEach(card => {
        const priceElem = card.querySelector('.price');
        const price = parseFloat(priceElem.innerText) || 0;

        card.querySelectorAll('.qty-input').forEach(qtyInput => {
            const qty = parseInt(qtyInput.value) || 0;
            total += price * qty;
        });
    });

    document.getElementById('total-price').innerText = total.toFixed(2);
}

/* ================= STOCK CHECK ================= */
function checkStock() {
    document.querySelectorAll('.product-card').forEach(card => {
        card.querySelectorAll('.qty-input').forEach(input => {
            const val = parseInt(input.value) || 0;
            const stock = parseInt(card.querySelector('.stock').innerText.replace('Stock : ','')) || 0;

            if(val > stock) {
                input.style.borderColor = 'red';
                input.title = 'Quantity non disponible';
            } else {
                input.style.borderColor = '';
                input.title = '';
            }
        });
    });
}

// تحديث أول مرة عند تحميل الصفحة
updateTotal();
checkStock();
</script>

@endsection
    