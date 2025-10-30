<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGIES - Radio Sanyo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gray-50: #fafafa;
            --gray-100: #f5f5f5;
            --gray-200: #e5e5e5;
            --gray-300: #d4d4d4;
            --gray-400: #a3a3a3;
            --gray-500: #737373;
            --gray-600: #525252;
            --gray-700: #404040;
            --gray-800: #262626;
            --gray-900: #171717;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--gray-900);
            border-right: 1px solid var(--gray-800);
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            padding: 0;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--gray-800);
        }
        
        .sidebar-logo {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            letter-spacing: -0.02em;
            margin: 0;
        }
        
        .sidebar-subtitle {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
            font-weight: 400;
        }
        
        .sidebar-nav {
            padding: 1.5rem 1rem;
        }
        
        .sidebar-nav .nav-link {
            color: var(--gray-400);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-nav .nav-link:hover {
            background: var(--gray-800);
            color: white;
        }
        
        .sidebar-nav .nav-link.active {
            background: white;
            color: var(--gray-900);
        }
        
        .sidebar-nav .nav-link i {
            font-size: 1.125rem;
            width: 20px;
        }
        
        .sidebar-divider {
            height: 1px;
            background: var(--gray-800);
            margin: 1rem 0;
        }
        
        .sidebar-section {
            color: var(--gray-500);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 1rem;
            margin-top: 1rem;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            margin: 0;
        }
        
        .card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
            border-radius: 12px 12px 0 0 !important;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .btn {
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-primary {
            background: var(--gray-900);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--gray-800);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }
        
        .btn-secondary:hover {
            background: var(--gray-200);
        }
        
        .btn-warning {
            background: var(--gray-600);
            color: white;
        }
        
        .btn-warning:hover {
            background: var(--gray-700);
        }
        
        .btn-danger {
            background: var(--gray-800);
            color: white;
        }
        
        .btn-danger:hover {
            background: var(--gray-900);
        }
        
        .btn-info {
            background: var(--gray-500);
            color: white;
        }
        
        .btn-info:hover {
            background: var(--gray-600);
        }
        
        .btn-sm {
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
        }
        
        .table {
            color: var(--gray-700);
            font-size: 0.875rem;
        }
        
        .table thead th {
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
            padding: 1rem;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: var(--gray-200);
        }
        
        .table-hover tbody tr:hover {
            background: var(--gray-50);
        }
        
        .badge {
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            font-size: 0.75rem;
            border-radius: 6px;
        }
        
        .badge.bg-info {
            background: var(--gray-200) !important;
            color: var(--gray-700);
        }
        
        .badge.bg-success {
            background: var(--gray-700) !important;
            color: white;
        }
        
        .badge.bg-warning {
            background: var(--gray-400) !important;
            color: white;
        }
        
        .badge.bg-danger {
            background: #dc2626 !important;
            color: white;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
        }
        
        .alert-success {
            background: var(--gray-100);
            color: var(--gray-800);
            border-left: 3px solid var(--gray-700);
        }
        
        .alert-danger {
            background: var(--gray-100);
            color: var(--gray-800);
            border-left: 3px solid var(--gray-900);
        }
        
        .form-control, .form-select {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--gray-600);
            box-shadow: 0 0 0 3px rgba(38, 38, 38, 0.1);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0.5rem 0 0 0;
            font-size: 0.875rem;
        }
        
        .breadcrumb-item a {
            color: var(--gray-500);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: var(--gray-700);
        }
        
        .breadcrumb-item.active {
            color: var(--gray-700);
        }
        
        .pagination {
            margin-top: 1.5rem;
        }
        
        .page-link {
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            margin: 0 0.25rem;
            padding: 0.5rem 0.875rem;
        }
        
        .page-link:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
            color: var(--gray-900);
        }
        
        .page-item.active .page-link {
            background: var(--gray-900);
            border-color: var(--gray-900);
            color: white;
        }
        
        code {
            background: var(--gray-100);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8125rem;
            color: var(--gray-800);
        }

        /* Estilos para el dropdown del área de compras */
        .sidebar-nav .dropdown-menu {
            background: var(--gray-800);
            border: 1px solid var(--gray-700);
            border-radius: 8px;
            padding: 0.5rem;
        }
        
        .sidebar-nav .dropdown-item {
            color: var(--gray-400);
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
        }
        
        .sidebar-nav .dropdown-item:hover {
            background: var(--gray-700);
            color: white;
        }
        
        .sidebar-nav .dropdown-toggle::after {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
             <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
            <h1 class="sidebar-logo">SGIES</h1>
                <p class="sidebar-subtitle">Radio Sanyo</p>
            </a>
        </div>
        
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('bodegas*') ? 'active' : '' }}" href="{{ route('bodegas.index') }}">
                        <i class="bi bi-building"></i>
                        <span>Bodegas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('productos*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                        <i class="bi bi-box"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('listados*') ? 'active' : '' }}" href="{{ route('listados.index') }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Listados Contables</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('solicitudes*') ? 'active' : '' }}" href="{{ route('solicitudes.index') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Solicitudes</span>
                    </a>
                </li>
                
                <!-- Divider -->
                <div class="sidebar-divider"></div>
                
                <!-- Área de Compras -->
                <div class="sidebar-section">Área de Compras</div>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('compras/facturas*') ? 'active' : '' }}" href="{{ route('compras.facturas') }}">
                        <i class="bi bi-receipt"></i>
                        <span>Facturas del Día</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('compras/proveedores*') ? 'active' : '' }}" href="{{ route('compras.proveedores') }}">
                        <i class="bi bi-building"></i>
                        <span>Información Proveedores</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('compras/mercancia-lenta*') ? 'active' : '' }}" href="{{ route('compras.mercancia-lenta') }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Mercancía Lenta</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>