<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — {{ $catalog['store_name'] ?? 'Java Computer Seller' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.ico' }}">
    <link rel="icon" type="image/svg+xml" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.svg' }}">
    <link rel="apple-touch-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/apple-touch-icon.png' }}">
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;700&amp;family=Space+Grotesk:wght@600;700&amp;family=Work+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fcf9f3;
            color: #1c1c18;
            font-family: 'Work Sans', sans-serif;
            min-height: 100vh;
        }
        h1, .font-headline { font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; }
        .brutal-card {
            background-color: #ffffff;
            border: 2.5px solid #111111;
            box-shadow: 4px 4px 0px #111111;
            border-radius: 0;
        }
        .brutal-input {
            background-color: #F3ECE1;
            border: 2px solid #111111;
            border-radius: 0;
        }
        .brutal-input:focus {
            background-color: #ffffff;
            border-color: #111111;
            box-shadow: 3px 3px 0px #111111;
        }
        .brutal-btn {
            background-color: #d49b55;
            color: #1A1A1A;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            border: 2.5px solid #111111;
            box-shadow: 3px 3px 0px #111111;
            border-radius: 0;
        }
        .brutal-btn:hover {
            background-color: #E5AC67;
            color: #1A1A1A;
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0px #111111;
        }
    </style>
</head>
<body class="d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="brutal-card p-4">
                <div class="d-inline-block px-2 py-1 mb-2 fw-bold small border border-dark" style="background:#E5AC67;font-family:'JetBrains Mono',monospace;">PANEL WORKSHOP</div>
                <h1 class="h4 fw-bold mb-1">Login Admin</h1>
                <p class="text-secondary small mb-4">Kelola isi konten landing page Java Computer Seller.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small rounded-0 border-2 border-dark">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/admin/login">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase" style="font-family:'JetBrains Mono',monospace;">Password Admin</label>
                        <input type="password" name="password" class="form-control brutal-input" required autofocus>
                    </div>
                    <button type="submit" class="btn brutal-btn w-100 py-2">Masuk ke Dashboard</button>
                </form>

                <div class="text-center mt-3">
                    <a href="/" class="small fw-semibold text-dark text-decoration-none">← Kembali ke Landing Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
