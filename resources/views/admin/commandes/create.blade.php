@extends('admin.layout')
@section('title','Nouvelle commande')

@section('content')
<div class="container">
    <div class="card shadow-lg p-4">

        <h3 class="mb-4 text-center">Créer Nouvelle Commande 🧾</h3>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


        
        <form method="POST" action="{{ route('commandes.store') }}">
            @csrf

            <!-- Clients -->
            <div class="mb-4">
                <label class="fw-bold">Mes Clients</label>
                <select name="client_id" class="form-control mb-2">
                    <option value="">Choisir client</option>
                    @foreach(\App\Models\Client::all() as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                    @endforeach
                </select>
                <input type="text" name="new_client" class="form-control mt-2" placeholder="Ajouter client automatiquement">
            </div>

            <hr>

            <!-- Produits -->
            <h5 class="mb-3">Les Produits 📦</h5>

            @foreach($produits as $index => $produit)
            <div class="border rounded p-3 mb-3 produit-block" data-produit="{{ $produit->id }}">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>{{ $produit->nom }} - {{ $produit->reference }}</strong> 
                    <span class="badge bg-black">{{ number_format($produit->prix,2) }} DH</span>
                </div>

                <input type="hidden" name="produits[{{ $index }}][id]" value="{{ $produit->id }}">

                <div class="produit-rows">

                    <div class="produit-row mb-2 d-flex gap-2 align-items-center">
                        <input type="number" name="produits[{{ $index }}][qte][]" value="0" min="0" max="{{ $produit->stock }}" class="form-control" style="width:80px" placeholder="Qté">

                        @if(is_array($produit->sizes) && count($produit->sizes) > 0)
                        <select name="produits[{{ $index }}][size][]" class="form-control" style="width:150px">
                            <option value="">Choisir size</option>
                            @foreach($produit->sizes as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        @endif

                        <button type="button" class="btn btn-sm btn-secondary add-row">+</button>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-2">
                    <p class="mb-0">Carton: {{ $produit->carton }}</p>
                    <p class="mb-0">Pack: {{ $produit->pack }}</p>
                </div>

            </div>
            @endforeach

            <div class="text-end mt-4">
                <button class="btn btn-success px-4">Enregistrer Commande 💾</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for dynamic rows -->
<script>
document.querySelectorAll('.produit-block').forEach(block => {
    block.querySelector('.add-row').addEventListener('click', function(){
        const row = block.querySelector('.produit-row');
        const clone = row.cloneNode(true);
        clone.querySelector('input').value = 0; // reset quantity

        // Add remove button if it doesn't exist
        let removeBtn = clone.querySelector('.remove-row');
        if(!removeBtn){
            removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger ms-1 remove-row';
            removeBtn.textContent = '−';
            clone.appendChild(removeBtn);
        }

        block.querySelector('.produit-rows').appendChild(clone);

        removeBtn.addEventListener('click', function(){
            clone.remove();
        });
    });
});
</script>

@endsection
