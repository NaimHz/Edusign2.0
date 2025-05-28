<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>QR Code de {{ $student->first_name }} {{ $student->last_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 text-center">
    <h1 class="mb-4">QR Code de {{ $student->first_name }} {{ $student->last_name }}</h1>
    <div class="mb-4">{!! $qrCode !!}</div>
    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
</body>
</html>
