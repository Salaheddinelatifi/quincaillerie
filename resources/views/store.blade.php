    <link rel="website icon" type="png" href="img/logo-bg.png">@foreach($produits as $p)
<div class="card">
<img src="/storage/{{ $p->image }}">
<h5>{{ $p->nom }}</h5>
<p>{{ $p->prix }} DH</p>
</div>
@endforeach
