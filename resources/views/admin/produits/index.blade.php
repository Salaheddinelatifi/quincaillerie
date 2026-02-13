@extends('admin.layout')
@section('title','Produits')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Produits</h3>
    <a href="{{ route('produits.create') }}" class="btn btn-primary">+ Ajouter</a>
</div>

<table class="table table-hover shadow">
<tr>
    <th>Ref</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Actions</th>
</tr>
@foreach($produits as $p)
<tr>
    <td>{{ $p->reference }}</td>
    <td>{{ $p->nom }}</td>
    <td>{{ $p->prix }} DH</td>
    <td>{{ $p->stock }}</td>
    <td>
        <a href="{{ route('produits.edit',$p->id) }}" class="btn btn-warning btn-sm">✏️</a>
        <a href="{{ route('produits.delete',$p->id) }}" class="btn btn-danger btn-sm">🗑️</a>
    </td>
</tr>
@endforeach
</table>
@endsection
