<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','AB Quincaillerie')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="website icon" type="png" href="{{ asset('img/logo-bg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules.css') }}">
    <style>
        /* ========================= */
        /* NAVBAR BASE */
        /* ========================= */
        .navbar{
            background:#111;
            padding:10px 20px;
            position:relative;
            color:white;
            z-index:999;
        }

        .nav-container{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            font-weight:bold;
            font-size:18px;
        }

        .brand img{
            height:40px;
        }

        .nav-links{
            display:flex;
            gap:20px;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            font-weight:500;
        }

        .nav-actions{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .menu-toggle{
            display:none;
            font-size:28px;
            cursor:pointer;
            background:none;
            border:none;
            color:white;
        }

        /* ========================= */
        /* MOBILE RESPONSIVE */
        /* ========================= */
        @media(max-width:768px){
            .nav-links{
                display:none;
                flex-direction:column;
                background:#111;
                position:absolute;
                top:70px;
                left:0;
                width:100%;
                text-align:center;
                z-index:999;
            }

            .nav-links.active{
                display:flex;
            }

            .nav-links a{
                padding:15px;
                border-bottom:1px solid #333;
            }

            .menu-toggle{
                display:block;
            }
        }

        /* ========================= */
        /* FOOTER */
        /* ========================= */
        .footer{
            background:#f5f5f5;
            text-align:center;
            padding:20px;
            margin-top:auto;
        }

        .footer img.footer-detailviss{
            height:40px;
            margin-bottom:10px;
        }

        /* ========================= */
        /* DARK MODE */
        /* ========================= */
        body.dark{
            background:#121212;
            color:#eee;
        }

        body.dark .navbar{
            background:#222;
        }

        body.dark .nav-links{
            background:#222;
        }

        body.dark .nav-links a{
            color:white;
        }

        body.dark .footer{
            background:#1a1a1a;
            color:#eee;
        }
    </style>
</head>

<body style="display:flex; flex-direction:column; min-height:100vh;padding-top: 10px;">

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">

            <!-- LOGO -->
            <div class="brand">
                <img src="{{ asset('img/logo-bg.png') }}" alt="AB QUINCAILLERIE">
                <span>AB QUINCAILLERIE</span>
            </div>

            <!-- LINKS -->
            <div class="nav-links" id="navMenu">
                <a href="{{ route('store.index') }}">Accueil</a>
                <a href="#produits">Produits</a>
                <a href="{{ route('store.modules') }}">Module</a>
                <a href="{{ route('store.tracking') }}">Tracking</a>
                <a href="{{ route('store.contact') }}">Contact</a>
                <a href="{{ route('store.cartevisite') }}">Carte Visite</a>
            </div>

            <!-- ACTIONS -->
            <div class="nav-actions">
                <!-- DARK MODE -->
                <button id="darkToggle" class="dark-btn" title="Dark mode">🌙</button>

                <!-- BURGER MENU -->
                <button class="menu-toggle" id="menuToggle">☰</button>
            </div>

        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="container" style="flex:1; display:flex; justify-content:center; align-items:center; flex-direction:column;">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <hr>
        <img src="{{ asset('img/logo-bg.png') }}" class="footer-detailviss">
        <p>© {{ date('Y') }} AB Quincaillerie</p>
        <p><strong>WhatsApp: </strong> 06 41 61 84 64</p>
        <p><strong>Téléphone:</strong> 05 22 31 71 14</p>
    </footer>

    <!-- ========================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================= -->
    <script>
        // DARK MODE
        const darkToggle = document.getElementById('darkToggle');
        if(localStorage.getItem('dark') === 'on'){
            document.body.classList.add('dark');
        }
        darkToggle.addEventListener('click', ()=>{
            document.body.classList.toggle('dark');
            localStorage.setItem(
                'dark',
                document.body.classList.contains('dark') ? 'on' : 'off'
            );
        });

        // BURGER MENU
        const menuBtn = document.getElementById('menuToggle');
        const menu = document.getElementById('navMenu');

        menuBtn.addEventListener('click', ()=>{
            menu.classList.toggle('active');
        });

        // CLOSE MENU WHEN CLICK LINK (MOBILE)
        document.querySelectorAll('#navMenu a').forEach(link=>{
            link.addEventListener('click', ()=>{
                menu.classList.remove('active');
            });
        });

        // OPTIONAL: REVEAL ANIMATION
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('active');
                }
            });
        },{ threshold:0.15 });
        reveals.forEach(r=> observer.observe(r));
    </script>

</body>
</html>
