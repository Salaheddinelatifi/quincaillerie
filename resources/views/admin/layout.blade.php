<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin')</title>
        <link rel="website icon" type="png" href="img/logo-bg.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f6f9; }
        .sidebar {
            min-height:100vh;
            background:#000000f5;
        }
        .sidebar a {
            color:#fff;
            text-decoration:none;
            display:block;
            padding:10px;
        }
        .sidebar a:hover {
            background:#374151;
        }

        /* Notifications dropdown */
        #notifDropdown { display: none; position:absolute; right:0; top:2.5rem; width:20rem; background:#fff; border:1px solid #ddd; border-radius:0.5rem; z-index:1000; }
        #notifDropdown.active { display:block; }
        #notifDropdown .notif-item { padding:0.5rem 1rem; border-bottom:1px solid #eee; }
        #notifDropdown .notif-item:hover { background:#f0f0f0; cursor:pointer; }
        #notifDropdown .notif-time { font-size:0.75rem; color:#888; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-2 sidebar">
            <h4 class="text-white text-center mt-3">
    <img src="{{ asset('img/logo-bg.png') }}" 
         alt="AB QUINCAILLERIE"
         class="mx-auto h-20"
          width="80px" ;>
</h4>  

            <hr class="text-white">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('produits.index') }}">Produits</a>
            <a href="{{ route('commandes.index') }}">Commandes</a>
            <a href="{{ route('admin.orders') }}">Mes Orders</a>
        </div>

        <!-- CONTENT -->
        <div class="col-10 p-4">

            <!-- Navbar Notifications -->
            @auth
            <div class="d-flex justify-content-end mb-3 position-relative">
                <button id="notifBtn" class="btn btn-outline-primary position-relative">
                    🔔
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                <div id="notifDropdown">
                    <div class="bg-light px-3 py-2 fw-bold">الإشعارات</div>
                    <div class="max-h-60 overflow-auto">
                        @forelse(auth()->user()->unreadNotifications as $notif)
                            <div class="notif-item">
                                <div>{{ $notif->data['message'] ?? 'Nouvelle commande' }}</div>
                                <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="notif-item text-muted">لا توجد إشعارات جديدة</div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endauth

            @yield('content')

        </div>

    </div>
</div>

<script>
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');

    notifBtn?.addEventListener('click', () => {
        notifDropdown.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
        if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.remove('active');
        }
    });
</script>
        
</body>
</html>
