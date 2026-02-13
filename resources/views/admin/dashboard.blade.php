@extends('admin.layout')

@section('title','Dashboard')

@section('content')

<h2 class="text-3xl font-bold mb-8 text-gray-800">Dashboard</h2>

<!-- ===== Cards statistiques ===== -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">

    <!-- Clients -->
    <div class="bg-blue-50 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition">
        <h5 class="text-blue-500 font-semibold mb-2">Clients</h5>
        <p class="text-3xl font-bold text-blue-600">{{ $totalClients }}</p>
    </div>

    <!-- Produits -->
    <div class="bg-purple-50 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition">
        <h5 class="text-purple-500 font-semibold mb-2">Produits</h5>
        <p class="text-3xl font-bold text-purple-600">{{ $totalProduits }}</p>
    </div>

    <!-- Commandes -->
    <div class="bg-green-50 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition">
        <h5 class="text-green-500 font-semibold mb-2">Commandes</h5>
        <p class="text-3xl font-bold text-green-600">{{ $totalCommandes }}</p>
    </div>

    <!-- Total Revenue -->
    <div class="bg-yellow-50 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition">
        <h5 class="text-yellow-500 font-semibold mb-2">Total Revenue</h5>
        <p class="text-3xl font-bold text-yellow-600">{{ number_format($totalRevenue,2) }} DH</p>
    </div>

</div>

<!-- ===== Dernières commandes ===== -->
<h3 class="text-2xl font-bold mb-4 text-gray-800">5 Dernières commandes</h3>

<div class="overflow-x-auto">
<table class="min-w-full bg-white rounded-xl shadow divide-y divide-gray-200">
<thead class="bg-gradient-to-r from-blue-100 to-purple-100 text-gray-700">
<tr>
<th class="px-6 py-3 text-left font-medium">ID</th>
<th class="px-6 py-3 text-left font-medium">Client</th>
<th class="px-6 py-3 text-left font-medium">Total</th>
<th class="px-6 py-3 text-center font-medium">Status</th>
<th class="px-6 py-3 text-left font-medium">Date</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100">
@foreach($recentCommandes as $c)
<tr class="hover:bg-gray-50 transition">
<td class="px-6 py-3 font-medium text-gray-700">{{ $c->id }}</td>
<td class="px-6 py-3 text-gray-600">{{ $c->client->nom ?? '-' }}</td>
<td class="px-6 py-3 text-gray-800 font-semibold">{{ number_format($c->total,2) }} DH</td>
<td class="px-6 py-3 text-center">
    @if($c->status == 'acceptée')
        <span class="inline-block px-3 py-1 text-green-600 bg-green-100 font-bold rounded-full text-sm">مقبولة</span>
    @elseif($c->status == 'en_attente')
        <span class="inline-block px-3 py-1 text-yellow-600 bg-yellow-100 font-bold rounded-full text-sm">في الانتظار</span>
    @elseif($c->status == 'rejetée')
        <span class="inline-block px-3 py-1 text-red-600 bg-red-100 font-bold rounded-full text-sm">مرفوضة</span>
    @else
        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ ucfirst($c->status) }}</span>
    @endif
</td>

<td class="px-6 py-3 text-gray-500">{{ $c->created_at->format('d/m/Y') }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

@endsection
