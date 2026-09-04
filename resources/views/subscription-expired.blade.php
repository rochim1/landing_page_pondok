<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Langganan Belum Aktif | {{ $brandName }}</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at top left, rgba(14, 165, 233, .14), transparent 34%),
                radial-gradient(circle at bottom right, rgba(124, 58, 237, .12), transparent 32%),
                #f8fafc;
        }
        .card {
            width: min(100%, 620px);
            padding: 48px;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
            text-align: center;
        }
        .icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 24px;
            display: grid;
            place-items: center;
            border-radius: 24px;
            background: #fff7ed;
            color: #ea580c;
            font-size: 42px;
            font-weight: 700;
        }
        .eyebrow {
            display: inline-flex;
            margin-bottom: 16px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        h1 { margin: 0 0 16px; font-size: clamp(30px, 6vw, 44px); line-height: 1.1; }
        p { margin: 0 auto 30px; max-width: 480px; color: #64748b; font-size: 17px; line-height: 1.7; }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            padding: 0 24px;
            border-radius: 12px;
            background: #0f172a;
            color: #fff;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease, background .2s ease;
        }
        .button:hover { background: #1e293b; transform: translateY(-1px); }
        .note { margin-top: 22px; color: #94a3b8; font-size: 13px; }
        @media (max-width: 520px) { .card { padding: 34px 22px; border-radius: 20px; } }
    </style>
</head>
<body>
    <main class="card">
        <div class="icon" aria-hidden="true">!</div>
        <div class="eyebrow">Subscription Expired</div>
        <h1>Mohon melakukan pembayaran</h1>
        <p>
            Subscription website ini belum aktif atau pembayaran masih menunggu persetujuan.
            Selesaikan pembayaran agar website dapat diakses kembali.
        </p>
        <a class="button" href="{{ $paymentUrl }}">Buka Halaman Pembayaran</a>
        <div class="note">Jika pembayaran sudah dilakukan, silakan hubungi administrator Pantoo.</div>
    </main>
</body>
</html>
