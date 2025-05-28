@extends('layouts.admin')

@section('title', 'Liste des cours')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de création de cours -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Créer un nouveau cours</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du cours</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Créer le cours</button>
            </form>
        </div>
    </div>

    <!-- Liste des cours -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Cours</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->description }}</td>
                            <td>
                                <a href="{{ route('admin.sessions.index', ['course' => $course->id]) }}" class="btn btn-info btn-sm">Gérer les séances</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun cours enregistré</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
