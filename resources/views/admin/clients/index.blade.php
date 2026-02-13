@extends('admin.layout')
@section('title','Clients')
@section('icon.layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Clients</h3>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">+ Ajouter</a>
</div>

<table class="table table-bordered table-striped shadow">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Téléphone</th>
        <th>Actions</th>
    </tr>
    @foreach($clients as $client)
    <tr>
        <td>{{ $client->id }}</td>
        <td>{{ $client->nom }}</td>
        <td>{{ $client->telephone }}</td>
        <td>
            <a href="{{ route('clients.edit',$client->id) }}" class="btn btn-warning btn-sm">✏️</a>
            <a href="{{ route('clients.delete',$client->id) }}" class="btn btn-danger btn-sm">🗑️</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection
