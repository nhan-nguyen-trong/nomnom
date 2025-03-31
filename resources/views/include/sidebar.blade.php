<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset( 'adminlte/dist/assets/img/AdminLTELogo.png' ) }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false"
            >
                <li class="nav-item">
                    <a href="{{ url('/ingredients') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Quản lý nguyên liệu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/packagings') }}" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>Quản lý bao bì</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/recipes') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Quản lý công thức</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/produce-cake') }}" class="nav-link">
                        <i class="nav-icon fas fa-birthday-cake"></i>
                        <p>Sản xuất bánh</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/sell-cake') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Bán bánh</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/reports') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Báo cáo doanh thu</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
