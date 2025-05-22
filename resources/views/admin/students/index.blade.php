<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Liste des étudiants</h1>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Ajouter un étudiant</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">ID Étudiant</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter l'étudiant</button>
            </form>
        </div>
    </div>

    <!-- Liste des étudiants -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des étudiants</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>QR Code</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->last_name }}</td>
                        <td>{{ $student->first_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <a href="{{ route('admin.students.qrcode', $student) }}" class="btn btn-primary btn-sm">Voir QR Code</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
