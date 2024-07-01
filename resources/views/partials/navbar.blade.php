<div class="row align-items-center justify-content-between">
    <div class="col-6 col-md-2 order-md-1 text-start">
        <img src="{{ asset('assets/imgs/Ferwafalogo.png') }}" style="width: 60px;" class="img-thumbnail">
    </div>
    <div class="col-12 col-md-8 order-md-2 text-center">
        <h1>RWANDA PRIMUS NATIONAL LEAGUE</h1>
    </div>
    <div class="col-6 col-md-2 order-md-3 text-end">
        <img src="{{ asset('assets/imgs/primuslogo.png') }}" style="width: 60px;" class="img-thumbnail">
    </div>
</div>
<hr>
<header class="p-3 text-bg-dark mx-1">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/home" class="nav-link px-2 text-secondary">Home</a></li>
            <li class="nav-item"><a href="/fixtures" class="nav-link">Fixitures</a></li>
            {{-- <li class="nav-item"><a href="#" class="nav-link">Results</a></li> --}}
            <li class="nav-item"><a href="/teams" class="nav-link">Teams/Standing</a></li>
            <li class="nav-item"><a href="/players" class="nav-link">Players</a></li>
            <li class="nav-item"><a href="{{ route('top_scorers') }}" class="nav-link">Top Scores</a></li>
        </ul>
        @auth
        <a href="{{ route('registration') }}" class="nav-link mx-2 text-primary">Add user</a>
        <div class="text-end">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('images/' . Auth::user()->picture) }}" style="width: 40px; border-radius: 50px;"
                    class="img-thumbnail rounded-8">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">{{ Auth::user()->fullname }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                <a class="dropdown-item" href="{{ route('password.change') }}">Change Password</a>
                <a class="dropdown-item" href="#" onclick="confirmLogout(event);">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        @endauth
        @guest
        </ul>
        <div class="text-end">
            <a href="/login" class="btn btn-outline-warning me-2">Login</a>
        </div>
        @endguest

        <script>
            function confirmLogout(event) {
                event.preventDefault();
                if (confirm('Are you sure you want to logout?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>
    </div>
</header>
