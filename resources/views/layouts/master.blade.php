<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hobi Platformu')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/css/star-rating.min.css" />
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('communities.index') }}">Hobi Platformu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('communities.index') }}">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="/communities">Topluluklar</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Etkinlikler</a></li>
                <li class="nav-item"><a class="nav-link" href="/profile">Profil</a></li>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Kullanıcılar</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Çıkış Yap</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/login">Giriş Yap</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Kayıt Ol</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


<!-- Content -->
<div class="container mt-4">
    @yield('content')

</div>

<!-- Footer -->
<footer class="footer bg-light py-3 mt-auto">
    <div class="container text-center">
        <span>&copy; 2024 Hobi Platformu. Tüm Hakları Saklıdır.</span>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/js/star-rating.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('scripts')


<!-- Bootstrap JS -->


</body>
</html>
