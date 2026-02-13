@php
    $logoPath = public_path('img/logo.png');
    $logoBase64 = null;

    if (file_exists($logoPath)) {
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        $data = file_get_contents($logoPath);
        $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Facture</title>

<style>
@page {
    size: A4 landscape;
    margin: 10mm;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #13151b;
    margin: 0;
    padding: 0;
}

.page {
    width: 100%;
    height: 100%;
    display: flex;
}

.invoice {
    width: 50%;
    box-sizing: border-box;
    padding: 8px 10px;
}

.invoice:first-child {
    border-right: 1px dashed #000;
}

.top-bar {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    margin-bottom: 6px;
}

.top-bar .logo img {
    width: 70px;
}

.top-bar .phones {
    text-align: center;
    font-weight: bold;
    font-size: 11px;
}

.top-bar .phones p {
    margin: 0;
}

.top-bar .bl {
    text-align: right;
    font-weight: bold;
    font-size: 12px;
}

.header {
    text-align: center;
    margin-bottom: 6px;
}

.client-box {
    border: 2px solid #000;
    padding: 6px 10px;
    margin: 6px auto;
    display: inline-block;
    min-width: 70%;
}

.client-box h1 {
    font-size: 20px;
    margin: 0;
}

.header p {
    margin: 2px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 6px;
}

th {
    background: #13151b;
    color: #fff;
    padding: 5px;
    font-size: 11px;
    text-align: left;
}

td {
    padding: 5px;
    border-bottom: 1px solid #000;
}

tr:nth-child(even) {
    background: #37df4d2c;
}

tfoot th, tfoot td {
    border-top: 2px solid #000;
}

.totals {
    margin-top: 10px;
    display: flex;
    justify-content: flex-end;
}

.total-box {
    border: 2px solid #000;
    padding: 8px 14px;
    min-width: 220px;
}

.total-box table {
    width: 100%;
    border-collapse: collapse;
}

.total-box td {
    padding: 4px 0;
    border: none;
    font-size: 12px;
}

.total-box .label {
    text-align: left;
    font-weight: bold;
}

.total-box .amount {
    text-align: right;
    font-size: 16px;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="page">

@for($i = 1; $i <= 2; $i++)
<div class="invoice">

    <!-- TOP BAR: LOGO LEFT | PHONE CENTER | BL RIGHT -->
    <div class="top-bar">
        <div class="logo">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}">
            @endif
        </div>

        <div class="phones">
            <p>05 22 31 71 14</p>
            <p>06 41 61 84 64</p>
        </div>

        <div class="bl">
            BL N° {{ $commande->id }}
        </div>
    </div>

    <!-- HEADER CLIENT -->
    <div class="header">
        <div class="client-box">
            <h1>{{ $commande->client->nom ?? 'Client' }}</h1>
        </div>

        <p>
            Casa, le
            <strong>{{ $commande->created_at->format('d/m/Y') }}</strong>
            <small>{{ $commande->created_at->format(' H:i') }}</small>
        </p>
    </div>

    <!-- TABLE PRODUITS -->
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Size</th> <!-- new -->
                <th>Qté</th>
                <th>PU</th>
                <th>C</th> <!-- Carton -->
                <th>P</th> <!-- Pack -->
                <th>R</th> <!-- Reste -->
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalCarton = 0;
            $totalPack = 0;
            $totalReste  = 0;
        @endphp
        @foreach($commande->produits as $p)
            @php
                $size = $p->pivot->size ?? '-';
                $qte = $p->pivot->quantite;
                    
                $countC = (int) $p->pivot->carton;
                $countP = (int) $p->pivot->pack;
                $countR = (int) $p->pivot->reste;
                $totalCarton += $countC;
                $totalPack   += $countP;
                $totalReste  += $countR;
            @endphp



            <tr>
                <td>{{ $p->nom }}</td>
                <td>{{ $size }}</td> <!-- new -->
                <td>{{ $p->pivot->quantite }}</td>
                <td>{{ number_format($p->pivot->prix, 2) }} DH</td>
                <td>{{ $countC > 0 ? $countC : '-' }}</td>
                <td>{{ $countP > 0 ? $countP : '-' }}</td>
                <td>{{ $p->pivot->reste > 0 ? $p->pivot->reste : '-' }}</td>
                <td><strong>{{ number_format($p->pivot->prix * $p->pivot->quantite, 2) }} DH</strong></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">CARTON / PACK / RESTE:</th>
                <th>{{ $totalCarton }}</th>
                <th>{{ $totalPack }}</th>
                <th>{{ $totalReste }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <!-- TOTAL PROFESSIONNEL DH -->
    <div class="totals">
        <div class="total-box">
            <table>
                <tr>
                    <td class="label">TOTAL À PAYER</td>
                    <td class="amount">{{ number_format($commande->total, 2) }} DH</td>
                </tr>
            </table>
        </div>
    </div>

</div>
@endfor

</div>

</body>
</html>
