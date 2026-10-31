<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Java Computer Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h1 class="h4 fw-bold mb-1">Login Admin</h1>
                <p class="text-secondary small mb-4">Kelola isi konten landing page Java Computer Seller.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/admin/login">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Admin</label>
                        <input type="password" name="password" class="form-control" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk ke Dashboard</button>
                </form>

                <div class="text-center mt-3">
                    <a href="/" class="small text-secondary text-decoration-none">← Kembali ke Landing Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
