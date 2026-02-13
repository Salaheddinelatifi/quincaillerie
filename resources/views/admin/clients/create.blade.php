@extends('admin.layout')
@section('title','Ajouter client')

@section('content')
<h3>Ajouter client</h3>

<form method="POST" action="{{ route('clients.store') }}" class="card p-4 shadow">
@csrf
<input class="form-control mb-2" name="nom" placeholder="Nom">
<input class="form-control mb-2" name="telephone" placeholder="Téléphone">
<button class="btn btn-success">Enregistrer</button>
</form>
@endsection
