<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="/dashboard" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('vendor/img/OCT-LogoG2.png') }}" alt="RODTHBAL KCN Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">RODTHBAL KCN</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item menu-open">
                    <a href="/dashboard" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./generate/theme.html" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Theme Generate</p>
                    </a>
                </li>
                <li class="nav-header">USERS MANAGEMENT</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user-gear"></i>
                        <p>
                            Users Accounts
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/user-accounts" class="nav-link">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>Users Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dashboard/requested-users" class="nav-link">
                                <i class="nav-icon fa-solid fa-user-plus"></i>
                                <p>Request Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.public-users') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>Public Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.suspended-users') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-user-lock"></i>
                                <p>Suspended Accounts</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.user-departments.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-building"></i>
                        <p>User Departments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.user-permissions.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-key"></i>
                        <p>User Permissions</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
