<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php
        use Illuminate\Support\Facades\Session;
    @endphp
    
    @yield('styles')
    
    @stack('styles')
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        #sidebar {
            min-width: 280px;
            max-width: 280px;
            background: linear-gradient(145deg, #4f46e5, #4338ca);
            color: #fff;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            z-index: 999;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }
        
        #sidebar.active {
            margin-left: -280px;
        }
        
        #sidebar .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        #sidebar ul.components {
            padding: 1.25rem 0;
        }
        
        #sidebar ul li a {
            padding: 0.75rem 1.25rem;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            margin: 0.375rem 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        #sidebar ul li a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        #sidebar ul li a.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
            position: relative;
            margin-left: 280px;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -280px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
            #content.active {
                margin-left: 280px;
            }
        }
        
        .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header p-4 d-flex align-items-center">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-code text-white fa-2x me-3"></i>
                        <div>
                            <h3 class="m-0 text-white fw-bold">{{ config('app.name', 'Laravel') }}</h3>
                            <small class="text-white opacity-75">Admin Dashboard</small>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- User Profile -->
            <div class="user-panel d-flex align-items-center p-3 border-bottom border-white border-opacity-10">
                <div class="image">
                    <img src="https://randomuser.me/api/portraits/men/1.jpg" class="rounded-circle" alt="User Image" style="width: 50px; height: 50px; object-fit: cover; border: 3px solid rgba(255,255,255,0.2);">
                </div>
                <div class="info ms-3">
                    <span class="d-block text-white">Administrator</span>
                    <small class="text-white-50">Admin</small>
                </div>
            </div>
            
            <!-- Sidebar Menu -->
            <ul class="list-unstyled components px-3 mt-3">
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} d-flex align-items-center">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }} d-flex align-items-center">
                        <i class="fas fa-shopping-cart me-2"></i> Produse
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }} d-flex align-items-center">
                        <i class="fas fa-shopping-basket me-2"></i> Coș
                        @php
                            $sidebarCartCount = count(Session::get('cart', []));
                        @endphp
                        @if($sidebarCartCount > 0)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $sidebarCartCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }} d-flex align-items-center">
                        <i class="fas fa-file-invoice me-2"></i> Comenzi
                    </a>
                </li>
            </ul>
            
            <div class="px-4 mt-4">
                <div class="card bg-white bg-opacity-10 text-white border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Spațiu utilizat</span>
                            <span class="badge bg-primary px-2 rounded-pill">75%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="small mt-2 text-white-50">750 MB din 1GB</div>
                    </div>
                </div>
                
                <div class="mt-4 mb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Deconectare
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div id="content" class="w-100 bg-light">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid">
                    <!-- Toggle button -->
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <form action="{{ route('search') }}" method="GET" class="me-3 d-none d-md-flex">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" placeholder="Caută produse sau comenzi..." aria-label="Search" required>
                            <select class="form-select flex-shrink-1" name="type" style="max-width: 120px;">
                                <option value="all">Toate</option>
                                <option value="products">Produse</option>
                                <option value="orders">Comenzi</option>
                            </select>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Coș de cumpărături -->
                        <div class="me-3">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                                @php
                                    $cartCount = count(Session::get('cart', []));
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3+
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-0" aria-labelledby="notificationsDropdown" style="width: 300px;">
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-0">Notificări</h6>
                                </div>
                                <div class="p-2">
                                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-radius-md">
                                        <div class="bg-primary text-white rounded-circle p-1 me-3" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-sm">Utilizator nou înregistrat</h6>
                                            <p class="text-xs text-secondary mb-0">Acum 5 minute</p>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-radius-md">
                                        <div class="bg-success text-white rounded-circle p-1 me-3" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-sm">Comandă nouă #2458</h6>
                                            <p class="text-xs text-secondary mb-0">Acum 2 ore</p>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-radius-md">
                                        <div class="bg-warning text-white rounded-circle p-1 me-3" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-sm">Stoc redus pentru 7 produse</h6>
                                            <p class="text-xs text-secondary mb-0">Acum 1 zi</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="py-2 text-center border-top">
                                    <a href="#" class="text-primary text-sm fw-bold">Vezi toate notificările</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Messages -->
                        <div class="dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-envelope fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                    7
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-0" aria-labelledby="messagesDropdown" style="width: 300px;">
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-0">Mesaje</h6>
                                </div>
                                <div class="p-2">
                                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-radius-md">
                                        <img src="https://randomuser.me/api/portraits/men/41.jpg" class="rounded-circle me-3" width="40" height="40">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-sm">Andrei Popescu</h6>
                                            <p class="text-xs text-secondary text-truncate mb-0" style="max-width: 180px;">Bună ziua, am o întrebare despre comanda mea...</p>
                                        </div>
                                        <span class="text-xs text-primary">5m</span>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-radius-md">
                                        <img src="https://randomuser.me/api/portraits/women/63.jpg" class="rounded-circle me-3" width="40" height="40">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-sm">Maria Ionescu</h6>
                                            <p class="text-xs text-secondary text-truncate mb-0" style="max-width: 180px;">Vă mulțumesc pentru răspunsul rapid!</p>
                                        </div>
                                        <span class="text-xs text-primary">1h</span>
                                    </a>
                                </div>
                                <div class="py-2 text-center border-top">
                                    <a href="#" class="text-primary text-sm fw-bold">Vezi toate mesajele</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" class="rounded-circle me-2" alt="User Avatar" width="32" height="32">
                                <span class="d-none d-lg-inline">Administrator</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" aria-labelledby="userDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Deconectare
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="container-fluid px-4">
                @yield('content')
                
                <!-- Footer -->
                <footer class="footer mt-auto py-3 bg-white rounded shadow-sm mt-4">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-6 small">
                                Copyright &copy; {{ config('app.name', 'Laravel') }} {{ date('Y') }}
                            </div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#" class="text-decoration-none">Politica de Confidențialitate</a>
                                &middot;
                                <a href="#" class="text-decoration-none">Termeni și Condiții</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <!-- Custom script for sidebar toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('active');
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 