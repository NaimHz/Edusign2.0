<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>QR Code - {{ $session->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 text-center">
    <h1 class="mb-4">QR Code pour {{ $session->name }}</h1>
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $session->course->name }}</h5>
            <p class="card-text">
                Début: {{ $session->start_time->format('d/m/Y H:i') }}<br>
                Fin: {{ $session->end_time->format('d/m/Y H:i') }}
            </p>
            <div class="mb-4">
                <img src="{{ route('admin.sessions.qrcode', $session) }}" alt="QR Code" class="img-fluid">
            </div>
            <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
</body>
</html>
