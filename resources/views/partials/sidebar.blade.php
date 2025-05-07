<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="{{ config('app.name', 'Laravel') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Administrator</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>{{ config('app.name', 'Laravel') }}</h3>
      </div>

      <ul class="list-unstyled components">
        <li>
          <a href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('products.index') }}">
            <i class="fas fa-shopping-cart"></i> Produse
          </a>
        </li>
        <li>
          <a href="{{ route('orders.index') }}">
            <i class="fas fa-file-invoice"></i> Comenzi
          </a>
        </li>
        <li>
          <a href="{{ route('settings') }}">
            <i class="fas fa-cog"></i> Setări
          </a>
        </li>
        <li>
          <a href="{{ route('reports') }}">
            <i class="fas fa-chart-bar"></i> Rapoarte
          </a>
        </li>
        <li>
          <a href="{{ route('profile') }}">
            <i class="fas fa-user"></i> Profil
          </a>
        </li>
      </ul>

      <div class="px-4 mt-5">
        <div class="card bg-primary text-white shadow">
          <div class="card-body">
            <div class="small">Spațiu utilizat:</div>
            <div class="progress mt-2" style="height: 8px;">
              <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="small mt-2">75% din 1GB</div>
          </div>
        </div>
      </div>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside> 