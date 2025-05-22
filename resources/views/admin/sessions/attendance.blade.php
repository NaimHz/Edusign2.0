<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Présences - {{ $session->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Présences pour {{ $session->name }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $session->course->name }}</h5>
            <p class="card-text">
                Début: {{ $session->start_time->format('d/m/Y H:i') }}<br>
                Fin: {{ $session->end_time->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Liste des présences</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Statut</th>
                            <th>Heure de scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($session->attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : 'danger' }}">
                                        {{ $attendance->status === 'present' ? 'Présent' : 'Absent' }}
                                    </span>
                                </td>
                                <td>{{ $attendance->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucune présence enregistrée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>
</body>
</html>
