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

        #notif-count {
            position: absolute;
            top: -10px;
            right: 10px;
            font-size: 10px;
            padding: 4px;
            border-radius: 50%;
        }

        #notifDropdown {
            position: relative;
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
            <li class="nav-item dropdown" style="list-style: none">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                    🔔 <span id="notif-count" class="badge bg-danger"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                    <li><h6 class="dropdown-header">Notifications</h6></li>
                    <div id="notif-list"></div>
                </ul>
            </li>


            @if(!empty(userData()))
                <strong class="mx-3">
                    <i class="bi bi-person-fill"></i> {{ userData()['name'] ?? ''}}
                </strong>
            @endif
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

@if (session('error'))
    <script>
        $(document).ready(function() {
            $.notify("{{ session('error') }}", {
                className: 'error',
                globalPosition: 'top right'
            });
        });
    </script>
@endif
<script>
    function loadNotifications() {
        $.get('/notifications', function(notifs) {
            $('#notif-count').text(notifs.length);

            let list = '';
            notifs.forEach(function(notif) {
                const description = notif.data.description.length > 50 
                    ? notif.data.description.substring(0, 50) + '...' 
                    : notif.data.description;

                list += `<li>
                            <a href="${notif.data.url}" class="dropdown-item">
                                <strong>${notif.data.title}</strong><br>
                                ${description}
                            </a>
                         </li>
                         <li><hr class="dropdown-divider"></li>`;
            });

            if(notifs.length === 0){
                list = '<span class="dropdown-item">No new notifications</span>';
            }

            $('#notif-list').html(list);
        });
    }

    loadNotifications()
    setInterval(loadNotifications, 10000); // Refresh every 10 seconds
</script>
</body>
</html>