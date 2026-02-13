@extends('admin.layout')
@section('title','Modifier produit')

@section('content')
<h3>Modifier produit</h3>

<form method="POST" action="{{ route('produits.update', $produit->id) }}" class="card p-4 shadow" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Référence -->
    <label>Référence</label>
    <input class="form-control mb-2 @error('reference') is-invalid @enderror" 
           name="reference" 
           placeholder="Référence" 
           value="{{ old('reference', $produit->reference) }}">
    @error('reference')
        <div class="text-danger mb-2">{{ $message }}</div>
    @enderror

    <!-- Nom -->
    <label>Nom</label>
    <input class="form-control mb-2 @error('nom') is-invalid @enderror" 
           name="nom" 
           placeholder="Nom" 
           value="{{ old('nom', $produit->nom) }}">
    @error('nom')
        <div class="text-danger mb-2">{{ $message }}</div>
    @enderror

    <!-- Prix -->
    <label>Prix</label>
    <input class="form-control mb-2 @error('prix') is-invalid @enderror" 
           name="prix" 
           placeholder="Prix" 
           value="{{ old('prix', $produit->prix) }}">
    @error('prix')
        <div class="text-danger mb-2">{{ $message }}</div>
    @enderror

    <!-- Stock -->
    <label>Stock</label>
    <input class="form-control mb-2 @error('stock') is-invalid @enderror" 
           name="stock" 
           placeholder="Stock" 
           value="{{ old('stock', $produit->stock) }}">
    @error('stock')
        <div class="text-danger mb-2">{{ $message }}</div>
    @enderror

    {{-- IMAGE --}}
    <label class="fw-bold mt-2">صورة المنتج</label>
    <input type="file" name="image" class="form-control mb-3" accept="image/*">
    @if($produit->image)
        <img src="{{ asset('storage/'.$produit->image) }}" width="120" class="mt-2 mb-3">
    @endif

    {{-- Sizes --}}
    <label class="fw-bold">المقاسات المتاحة + الثمن</label>

    {{-- Check All --}}
    <div class="d-flex align-items-center gap-2 mb-2">
        <input type="checkbox" id="checkAllSizes">
        <label class="fw-bold">All</label>
    </div>

    @php
    $sizesList = [
        '4*10','4*16','4*20','4*25','4*30','4*40','4*50','4*60','4*70','4*80','4*100',
        '5*10','5*16','5*20','5*30','5*40','5*50','5*60','5*70','5*80','5*100',
        '6*10','6*16','6*20','6*30','6*40','6*50','6*60','6*70','6*80','6*100'
    ];
    @endphp

    @foreach($sizesList as $s)
    @php
        $isChecked = in_array($s, $produit->sizes ?? []);
        $priceValue = $produit->sizes_prices[$s] ?? '';
    @endphp
    <div class="d-flex align-items-center gap-2 mb-1">
        <input type="checkbox" name="sizes[]" value="{{ $s }}" class="size-checkbox" {{ $isChecked ? 'checked' : '' }}>
        <label class="me-2">{{ $s }}</label>
        <input type="number" step="0.01"
               name="sizes_prices[{{ $s }}]"
               class="form-control w-25"
               placeholder="Prix {{ $s }}"
               value="{{ old('sizes_prices.'.$s, $priceValue) }}">
    </div>
    @endforeach

    {{-- Carton & Pack --}}
    <div class="row mt-3">
        <div class="col-md-6">
            <label class="fw-bold">C (Carton)</label>
            <input type="number" min="0" class="form-control" name="carton" 
                   value="{{ old('carton', $produit->carton) }}">
        </div>
        <div class="col-md-6">
            <label class="fw-bold">P (Pack)</label>
            <input type="number" min="0" class="form-control" name="pack" 
                   value="{{ old('pack', $produit->pack) }}">
        </div>
    </div>

    <button class="btn btn-success mt-3">Enregistrer</button>
</form>

{{-- JS: Check All functionality --}}
<script>
document.getElementById('checkAllSizes').addEventListener('change', function(){
    const allChecked = this.checked;
    document.querySelectorAll('.size-checkbox').forEach(cb => {
        cb.checked = allChecked;
    });
});
</script>

@endsection
