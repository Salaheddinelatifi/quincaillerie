<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carte de Visite AB Quincaillerie</title>

<style>
body{
    font-family: 'Segoe UI', Arial, sans-serif;
    background:#ffffff;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* ===== 3D container ===== */
.card-container{
    perspective:2200px;
}

.card{
    width:700px;
    height:460px;
    position:relative;
    transform-style:preserve-3d;
    transition:transform .9s ease;
    cursor:pointer;
}

.card-container:hover .card{
    transform:rotateY(180deg);
}

.card-face{
    position:absolute;
    width:100%;
    height:100%;
    backface-visibility:hidden;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 12px 25px rgba(0,0,0,.25);
}

/* ===== FRONT ===== */
.card-front{
    background:linear-gradient(135deg,#0f172a,#064e3b);
    color:#ffffff;
    padding:18px 20px;
}

/* header */
.card-header{
    display:flex;
    align-items:center;
    gap:14px;
    border-bottom:1px solid rgba(255,255,255,.15);
    padding-bottom:10px;
}

.card-header img{
    width:120px;
}

.card-header h2{
    margin:0;
    font-size:2.35em;
    letter-spacing:2px;
    color:#22c55e;
}

/* slogan */
.slogan{
    margin:8px 0 14px 150px;
    font-size:1.1em;
    color:#60a5fa;
    font-weight:600;
}

/* products */
.images{
    display:flex;
    justify-content:space-between;
    margin:22px 20px;
}

.images img{
    width:118px;
    height:78px;
    background:#ffffff1e;
    padding:4px;
    border-radius:8px;
    box-shadow:0 3px 6px rgba(10, 255, 2, 0.514);
}

/* contact box */
.contact{
    background:rgba(255,255,255,.08);
    padding:30px;
    border-radius:26px;
    font-size:.95em;
    line-height:1.5;
}

/* ===== BACK ===== */
.card-back{
    background:linear-gradient(135deg,#0b3a2a,#0f172a);
    transform:rotateY(180deg);
    padding:22px;
    color:#ffffff;
}


.card-back h3{
    margin:0 0 8px;
    color:#1ab854; /* نفس أخضر اللوغو */
    font-size:2em;
    letter-spacing:1px;
}

.card-back p{
    margin:5px 3px;
    font-size:1.4em;
    color:#e5e7eb; /* أبيض مكسور */
}


.card-back .tag{
    background:#00ff15;
    color:#0f172a;
    font-weight:900;
}


/* back layout */
.back-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
}

.back-text{
    width:60%;
}

.back-qr{
    width:80%;
    text-align:center;
}


.back-qr img{
    width:100%;
    max-width:200px;
    background:#00000065;
    padding:6px;
    border-radius:10px;
    border:2px solid #f8f8f867;
    box-shadow:0 6px 12px rgba(0, 0, 0, 0);
}

    .tiitle h1{
    margin:30px;
    font-size:2em;
    letter-spacing:1.5px;
    color: var(--title-color-light);
}

</style>
</head>

<body>
    
<div class="tiitle">
    <h1 >Welcome Chez Youssef</h1></div>
<div class="card-container">
    <div class="card">

        <!-- FRONT -->
        <div class="card-face card-front">

            <div class="card-header">
                <img src="{{ asset('img/logo-bg.png') }}">
                <h2>AB QUINCAILLERIE</h2>
            </div>

            <div class="slogan">
                Visserie • Boulonnerie • Fixation industrielle
            </div>

            <div class="images">
                <img src="{{ asset('img/spaxbg.png') }}">
                <img src="{{ asset('img/rivetbg.png') }}">
                <img src="{{ asset('img/boulonnebg.png') }}">
                <img src="{{ asset('img/ecroubg.png') }}">
                <img src="{{ asset('img/foretbg.png') }}">
            </div>

            <div class="contact">
                📍 59, Rue de Bazas Résidence Listikrar La Gironde– Casablanca<br>
                📧 cap4vis@gmail.com<br>
                📞 06 41 61 84 64<br>
                💬 WhatsApp : 06 41 61 84 64
            </div>
        </div>

        <!-- BACK -->
        <!-- BACK -->
<div class="card-face card-back">

    <span class="tag">Professionnel</span>

    <div class="back-content">
        <!-- TEXT -->
        <div class="back-text">
            <h3>AB QUINCAILLERIE</h3>
            <p>✔ Visserie & Fixation industrielle</p>
            <p>✔ Qualité – Stock – Prix compétitifs</p>
            <br>
            <p>📧 cap4vis@gmail.com</p>
            <p>📞 06 41 61 84 64</p>
            <p>🌐 www.abquincaillerie.ma</p>
        </div>

        <!-- QR -->
        <div class="back-qr">
            <img src="{{ asset('img/qrmaps.png') }}" alt="AB QUINCAILLERIE maps">
        </div>
    </div>

</div>

</body>
</html>
