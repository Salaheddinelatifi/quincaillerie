@extends('store.layout')

@section('title','Contact')

@section('content')

<h1 class="page-title">📞 Contactez-nous</h1>

<div class="contact-wrapper">

    <!-- LEFT : INFOS -->
    <div class="contact-card">
        <h2>🏪 AB QUINCAILLERIE</h2>

        <div class="contact-item">
            <span>📍</span>
            <p>
                59, Rue Bazas Résidence Listikrar La Gironde – <br>
                Casablanca – Maroc
            </p>
        </div>

        <div class="contact-item">
            <span>📞</span>
            <p>05 22 31 71 14</p>
        </div>

        <div class="contact-item">
            <span>✉</span>
            <p>cap4vis@gmail.com</p>
        </div>

        <div class="contact-item">
            <span>⏰</span>
            <p>
                Lun – Ven : 08:30 → 17:00 <br>
                Samedi : 08:30 → 14:00 <br>
                Dimanche : Fermé
            </p>
        </div>
    </div>

    <!-- RIGHT : MAP -->
    <div class="map-card">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3323.7666237529647!2d-7.603600223554442!3d33.58540817333632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7cdadbdf879af%3A0x6fa4487cc78fd15d!2sAB%20QUINCAILLERIE!5e0!3m2!1sfr!2sma!4v1769520969218!5m2!1sfr!2sma" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</div>

<!-- BOTTOM CONTACT CTA -->
<div class="contact-cta">
    <h2>Besoin d’un devis ou information ?</h2>
    <p>Notre équipe est à votre disposition pour vous accompagner.</p>
    <a href="{{ route('store.index') }}" class="btn-primary big">
        🛒 Accéder au Store
    </a>
</div>

@endsection
