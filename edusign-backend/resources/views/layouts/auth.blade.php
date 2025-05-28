<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentification') - EduSign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #2c3e50;
            padding: 1rem;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .nav-link:hover {
            color: white !important;
        }
        .nav-link.active {
            color: white !important;
            font-weight: bold;
        }
        .api-routes {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .api-route {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border-radius: 0.25rem;
            background-color: white;
            border: 1px solid #dee2e6;
        }
        .api-route:hover {
            background-color: #e9ecef;
        }
        .method {
            font-weight: bold;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-right: 0.5rem;
        }
        .get { background-color: #d1ecf1; color: #0c5460; }
        .post { background-color: #d4edda; color: #155724; }
        .put { background-color: #fff3cd; color: #856404; }
        .delete { background-color: #f8d7da; color: #721c24; }
        .auth-container {
            max-width: 400px;
            margin: 2rem auto;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('login') }}">
                <i class="fas fa-graduation-cap me-2"></i>EduSign
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="api-routes">
            <h5 class="mb-3"><i class="fas fa-code me-2"></i>Routes API</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-2">Étudiants</h6>
                    <div class="api-route">
                        <span class="method get">GET</span>
                        <code>/api/students</code>
                    </div>
                    <div class="api-route">
                        <span class="method post">POST</span>
                        <code>/api/students</code>
                    </div>
                    <div class="api-route">
                        <span class="method get">GET</span>
                        <code>/api/students/{id}</code>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-2">Séances</h6>
                    <div class="api-route">
                        <span class="method get">GET</span>
                        <code>/api/sessions</code>
                    </div>
                    <div class="api-route">
                        <span class="method post">POST</span>
                        <code>/api/sessions</code>
                    </div>
                    <div class="api-route">
                        <span class="method get">GET</span>
                        <code>/api/sessions/{id}/attendance</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-container">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
