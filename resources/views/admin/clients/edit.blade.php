@extends('admin.layout')
@section('title','Modifier client')

@section('content')
<h3>Modifier client</h3>

<form method="POST" action="{{ route('clients.update',$client->id) }}" class="card p-4 shadow">
@csrf
<input class="form-control mb-2" name="nom" value="{{ $client->nom }}">
<input class="form-control mb-2" name="telephone" value="{{ $client->telephone }}">
<button class="btn btn-primary">Modifier</button>
</form>
@endsection

