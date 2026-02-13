@extends('admin.layout')
@section('title','Commandes')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Commandes</h3>
    <a href="{{ route('commandes.create') }}" class="btn btn-primary">+ Nouvelle</a>
</div>

<table class="table table-bordered shadow">
<tr>
    <th>ID</th><th>Total</th><th>Actions</th>
</tr>
@foreach($commandes as $c)
<tr>
    <td>#{{ $c->id }}</td>
    <td>{{ $c->total }} DH</td>
    <td>
        <a href="{{ route('commandes.show',$c->id) }}" class="btn btn-info btn-sm">👁️</a>
        <a href="{{ route('commandes.facture',$c->id) }}" class="btn btn-secondary btn-sm">🧾</a>
    </td>
</tr>
@endforeach
</table>
@endsection
