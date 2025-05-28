@extends('layouts.admin')

@section('title', 'Liste des séances')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de création de séance -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Créer une nouvelle séance</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sessions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="course_id" class="form-label">Cours</label>
                    <select name="course_id" id="course_id" class="form-select" required>
                        <option value="">Sélectionner un cours</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la séance</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">Heure de début</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="end_time" class="form-label">Heure de fin</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Créer la séance</button>
            </form>
        </div>
    </div>

    <!-- Liste des séances -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Séances</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cours</th>
                        <th>Nom</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>QR Code</th>
                        <th>Présences</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->id }}</td>
                        <td>{{ $session->course->name }}</td>
                        <td>{{ $session->name }}</td>
                        <td>{{ $session->start_time->format('d/m/Y H:i') }}</td>
                        <td>{{ $session->end_time->format('d/m/Y H:i') }}</td>
                        <td>
                            <!-- Bouton pour ouvrir la modale -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal{{ $session->id }}">
                                Voir QR Code
                            </button>
                            <!-- Modale Bootstrap -->
                            <div class="modal fade" id="qrModal{{ $session->id }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $session->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="qrModalLabel{{ $session->id }}">QR Code de la séance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <img src="{{ route('admin.sessions.qrcode', $session) }}" alt="QR Code" style="max-width: 250px;" />
                                  </div>
                                </div>
                              </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-info btn-sm">Voir présences</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS (nécessaire pour les modales) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
