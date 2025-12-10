<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Remenu Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Navegação
    </div>

    <!-- Nav Item - Página Principal -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home2') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Página Principal</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administração
    </div>

    <!-- Nav Item - Usuários -->
    <li class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.usuarios') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuários Administradores</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    

</ul>
<!-- End of Sidebar -->