<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>@yield('title','Admin')</title>
    <link rel="website icon" type="png" href="img/logo-bg.png">
{{-- Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

{{-- Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

<style>
body { background:#f4f6f9; }

.sidebar { min-height:100vh; background:#000000; }
.sidebar a { color:#fff; text-decoration:none; display:block; padding:10px; }
.sidebar a:hover { background:#374151; }

/* Notifications */
#notifDropdown { 
    display:none; 
    position:absolute; 
    right:0; 
    top:3rem; 
    width:24rem; 
    background:#fff; 
    border-radius:0.75rem; 
    box-shadow:0 10px 25px rgba(0,0,0,.15); 
    z-index:1000; 
}
#notifDropdown.active { display:block; }

.notif-item { padding:0.75rem 1rem; border-bottom:1px solid #eee; }
.notif-item:hover { background:#f8fafc; cursor:pointer; }
.notif-time { font-size:0.75rem; color:#6b7280; }
</style>
</head>
<body>
<br>
<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-2 sidebar">
            <h4 class="text-white text-center mt-3">
    <img src="{{ asset('img/logo-bg.png') }}" 
         alt="AB QUINCAILLERIE"
         class="mx-auto h-20">
</h4> <br>

            <hr class="text-white">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('produits.index') }}">Produits</a>
            <a href="{{ route('commandes.index') }}">Commandes</a>
            <a href="{{ route('admin.orders') }}">Mes Orders</a>
        </div>

        {{-- CONTENT --}}
        <div class="col-10 p-4">

            {{-- NAVBAR --}}
            @auth
            <div class="d-flex justify-content-end mb-4 position-relative">
                <button id="notifBtn" class="btn btn-outline-primary position-relative">
                    🔔
                    <span id="notifCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none"></span>
                </button>
                <div id="notifDropdown">
                    <div class="px-3 py-2 fw-bold border-bottom bg-gray-50">📢 Notifications</div>
                    <div id="notifList" class="max-h-80 overflow-auto">
                        <div class="notif-item text-muted text-center">لا توجد إشعارات</div>
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
const notifList = document.getElementById('notifList');
const notifCount = document.getElementById('notifCount');

notifBtn?.addEventListener('click', () => {
    notifDropdown.classList.toggle('active');
});

document.addEventListener('click', (e) => {
    if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.remove('active');
    }
});

// 🔁 Fetch notifications every 5 seconds
async function fetchNotifications() {
    try {
        const res = await fetch('/admin/notifications/fetch');
        const data = await res.json();

        notifList.innerHTML = '';

        // Only pending orders
        const pendingOrders = data.filter(n => n.data.status === 'en_attente');

        if (pendingOrders.length > 0) {
            notifCount.textContent = pendingOrders.length;
            notifCount.classList.remove('d-none');

            pendingOrders.forEach(n => {
                notifList.innerHTML += `
                    <div class="notif-item">
                        <div class="fw-bold text-gray-800">📦 Nouvelle commande</div>
                        <div class="text-sm">
                            👤 ${n.data.client} | 📞 ${n.data.telephone}<br>
                            💰 ${parseFloat(n.data.total).toFixed(2)} DH
                        </div>
                        <div class="notif-time">${new Date(n.created_at).toLocaleString()}</div>
                    </div>
                `;
            });
        } else {
            notifCount.classList.add('d-none');
            notifList.innerHTML = `<div class="notif-item text-muted text-center">لا توجد إشعارات</div>`;
        }
    } catch(err) {
        console.error('Erreur fetch notifications:', err);
    }
}

setInterval(fetchNotifications, 5000);
fetchNotifications();
</script>

</body>
</html>
