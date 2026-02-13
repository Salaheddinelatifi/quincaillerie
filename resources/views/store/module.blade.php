@extends('store.layout')

@section('title',' Modules')

@section('content')
<div class="gallery-container">

    <h1 class="page-title">tous
     les Modules</h1>

    @forelse($modules ?? [] as $module)
        <article class="module-post">

            <div class="module-image magnifier-container">
                <img
                    src="{{ asset('img/modules/'.$module->image) }}"
                    alt="{{ $module->nom }}"
                    class="magnifier-image"
                >
                <div class="magnifier-glass"></div>
            </div>

        </article>
    @empty
        <p class="empty">Aucun module disponible</p>
    @endforelse

</div>
@endsection
 


