<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Strathmore Parking') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #0f766e;
            --accent-color: #f59e0b;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
            --border-color: #e2e8f0;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
        }
        
        .navbar {
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color) !important;
        }
        
        .navbar-brand img {
            height: 40px;
            margin-right: 12px;
        }
        
        .nav-link {
            color: var(--dark-text) !important;
            font-weight: 500;
            transition: color 0.3s ease;
            margin-left: 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-link {
            color: var(--dark-text) !important;
            text-decoration: none;
            padding: 0.5rem 1rem;
        }
        
        .btn-link:hover {
            color: var(--primary-color) !important;
        }
        
        main {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
    </style>
    
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-lg">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Strathmore University Logo" style="height: 40px; margin-right: 0.75rem;">
                <span>{{ config('app.name', 'Strathmore Parking') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link"><i class="fas fa-user-circle"></i> {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container-lg">
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
