<li class="sidebar-main-title" style="padding-top: 0; padding-bottom: 0;">
    <div style="background-color: transparent">
        <h6 class="mb-0">MENU UTAMA</h6>
    </div>
</li>
<li class="sidebar-list">
    <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i data-feather="activity"></i><span>Dashboard</span>
    </a>
</li>
<li class="sidebar-list">
    <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('menu.aby') ? 'active' : '' }}" href="{{ route('menu.aby') }}">
        <i data-feather="home"></i><span>Menu Aby</span>
    </a>
</li>