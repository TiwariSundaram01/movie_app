<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Movie App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .main-content {
            min-height: 70vh;
        }
    </style>
    @yield('css')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">MovieApp</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form method="GET" action="{{ route('auth.logout') }}">
                        <button class="btn btn-sm btn-success" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container main-content">
    @yield('content')
</div>

<footer class="bg-dark text-white pt-4 pb-2">
    <div class="container">
        <div class="row">

            <!-- About Section -->
            <div class="col-md-4 mb-3">
                <h5>MovieApp</h5>
                <p>Your go-to place for the latest movie ratings, reviews, and more!</p>
            </div>

            <!-- Navigation Links -->
            <div class="col-md-4 mb-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/home" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="/movies" class="text-white text-decoration-none">All Movies</a></li>
                    <li><a href="/profile" class="text-white text-decoration-none">Profile</a></li>
                    <li><a href="/contact" class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 mb-3">
                <h5>Follow Us</h5>
                <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center">
            <p class="mb-0">&copy; {{ date('Y') }} MovieApp. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap Icons CDN (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Notify.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
@yield('js')

</body>
</html>