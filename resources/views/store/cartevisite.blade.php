@extends('store.layout')

@section('title','Carte Visite AB Quincaillerie')

@section('content')

<!-- Title -->
<h1 class="page-title" style="text-align:center; margin-top:20px;"></h1>

<!-- Carte wrapper -->
<div class="cartevisite-wrapper" style="
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:500px;  /* باش تبقى في الوسط vertical */
    padding:20px;
">
    @include('store.partials.cartevisite')
</div>

@endsection
