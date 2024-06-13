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
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
          <li class="nav-item"><a href="/fixtures" class="nav-link">Fixitures</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Results</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Standing</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Players stats</a></li>

      @auth
        <li class="nav-item"><a href="/teams" class="nav-link">Teams Management</a></li> 
        <li class="nav-item"><a href="/fixtures" class="nav-link">Fixutres Management</a></li> 
        <li class="nav-item"><a href="#" class="nav-link">Players Management</a></li> 
        <li class="nav-item"><a href="#" class="nav-link">Results Management</a></li> 
           </ul>
    <div class="text-end">
          <a href="/login" class="btn btn-outline-warning me-2">Logout</a>
      </div>      
    @elseauth()

    <div class="text-end">
      <a href="/login" class="btn btn-outline-warning me-2">Login</a>
  </div> 
     @endauth
      
  </div>
</header>
