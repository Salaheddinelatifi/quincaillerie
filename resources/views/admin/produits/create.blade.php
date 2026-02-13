@extends('admin.layout')
@section('title','Ajouter produit')
@section('content')
<h3>Ajouter produit</h3>

<form method="POST" action="{{ route('produits.store') }}" class="card p-4 shadow" enctype="multipart/form-data">
    @csrf

    <input class="form-control mb-2" name="reference" placeholder="Référence" required>
    <input class="form-control mb-2" name="nom" placeholder="Nom" required>
    <input type="number" step="0.01" class="form-control mb-2" name="prix" placeholder="Prix de base" required>
    <input type="number" class="form-control mb-2" name="stock" placeholder="Stock" required>

    {{-- IMAGE --}}
    <label class="fw-bold mt-2">صورة المنتج</label>
    <input type="file" name="image" class="form-control mb-3" accept="image/*">

    {{-- Sizes --}}
    <label class="fw-bold">المقاسات المتاحة + الثمن لكل حجم</label>
    @php
        $sizesList = ['1','1.5','2','2.5','2X10','3','3.5','3X8','3X12','3X16','3X20','3X25','3X30','4','4.2','4.5','4X8','4X10','4X12','4X16','4X20','4X20X15','4X25','4X30','4X40','4X50','4X60','4X70','4X80','4X100','5','5.2','5.5','5X8','5X10','5X12','5X16','5X20','5X20X15','5X25','5X30','5X40','5X50','5X60','5X70','5X80','5X100','6','6.5','6X10','6X16','6X20','6X25','6X30','6X40','6X50','6X60','6X65','6X70','6X80','6X90','6X100','6X120','6X150','7','8','8X20X15','8.5','8X20','8X25','8X30','8X40','8X50','8X60','8X65','8X70','8X75','8X80','8X90','8X100','8X115','8X120','8X150','9','10','10.5','10X60','10X70','10X80','10X90','10X100','10X120','10X140','10X150','10X160','10X200','12','12X80','12X90','12X100','12X120','12X140','13','14','14X100','14X120','14X140','14X145','14X150','14X160','14X180','15','16','16X100','16X110','16X125','16X145','16X180','16X200','18','20','20X160','20X200','22','24','25','27','30','40','50'];
    @endphp

    @foreach($sizesList as $s)
    <div class="d-flex align-items-center gap-2 mb-1">
        <input type="checkbox" name="sizes[]" value="{{ $s }}" id="size-{{ $s }}" 
               @if(old('sizes') && in_array($s, old('sizes'))) checked @endif>
        <label for="size-{{ $s }}" class="mb-0">{{ $s }}</label>

        <input type="number" step="0.01" name="sizes_prices[{{ $s }}]" 
               placeholder="Prix pour {{ $s }}" 
               value="{{ old('sizes_prices.'.$s) }}" class="form-control w-auto" 
               style="max-width:120px;" 
               @if(old('sizes') && !in_array($s, old('sizes'))) disabled @endif>
    </div>
    @endforeach

    {{-- Carton & Pack --}}
    <div class="row mt-3">
        <div class="col-md-6">
            <label class="fw-bold">C (Carton)</label>
            <input type="number" min="0" class="form-control" name="carton" placeholder="Nombre de cartons">
        </div>
        <div class="col-md-6">
            <label class="fw-bold">P (Pack)</label>
            <input type="number" min="0" class="form-control" name="pack" placeholder="Nombre de packs">
        </div>
    </div>

    <button class="btn btn-success mt-3">Enregistrer</button>
</form>

{{-- JS: activer/تعطيل input السعر حسب اختيار checkbox --}}
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('input[type=checkbox][name="sizes[]"]').forEach(cb => {
        cb.addEventListener('change', function(){
            const inputPrice = this.closest('div').querySelector('input[name^="sizes_prices"]');
            if(this.checked){
                inputPrice.removeAttribute('disabled');
            } else {
                inputPrice.value = '';
                inputPrice.setAttribute('disabled', true);
            }
        });
    });
});
</script>
@endsection
