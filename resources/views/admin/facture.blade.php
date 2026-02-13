<img src="{{ public_path('logo.png') }}" width="120">

<h2>Facture #{{ $commande->id }}</h2>
<p>Client: {{ $commande->client->nom }}</p>

<table border="1" width="100%">
<tr><th>Produit</th><th>Qte</th><th>Prix</th></tr>
@foreach($commande->produits as $p)
<tr>
<td>{{ $p->nom }} ({{ $p->pivot->size }})</td>
<td>{{ $p->pivot->quantite }}</td>
<td>{{ $p->pivot->prix }}</td>
</tr>

@endforeach
</table>

<h3>Total: {{ $commande->total }} DH</h3>
