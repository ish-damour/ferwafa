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
          <li class="nav-item"><a href="/teams" class="nav-link">Standing</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Players stats</a></li>
          <li class="nav-item"><a href="{{ route('top_scorers') }}" class="nav-link">Top Scores</a></li>

      @auth
           </ul>
    <div class="text-end">
          <a href="/logout" class="btn btn-outline-danger me-2">Logout</a>
      </div>      
      @endauth
      @guest
    </ul>
       <div class="text-end">
      <a href="/login" class="btn btn-outline-warning me-2">Login</a>
  </div>      
      @endguest

     
      
  </div>
</header>
