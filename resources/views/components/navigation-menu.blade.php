<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @can('admin.usuarios.index')
                <div class="sb-sidenav-menu-heading">PANEL PRINCIPAL</div>
                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">ADMINISTRACIÓN</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin"
                    aria-expanded="false" aria-controls="collapseAdmin">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog fa-fw"></i></div>
                    GERENCIAL
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAdmin" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a>
                        <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                        <a class="nav-link" href="{{ route('admin.compania.index') }}">Compañia</a>
                        <a class="nav-link" href="{{ route('admin.backup') }}">Backup BD</a>
                    </nav>
                </div>
                @endcan
                @can('admin.venta.index')
                <div class="sb-sidenav-menu-heading">VENTAS Y COMPRAS</div>
                <a class="nav-link" href="{{ route('admin.venta.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    NUEVA VENTA
                </a>
                @endcan
                @can('admin.reservas.index')
                <a class="nav-link" href="{{ route('admin.reservas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    NUEVA RESERVACIÓN
                </a>
                @endcan
                @can('admin.compra.index')
                <a class="nav-link" href="{{ route('admin.compra.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    NUEVA COMPRA
                </a>
                @endcan
                <div class="sb-sidenav-menu-heading">PAGINAS</div>
                @can('admin.habitacion.index')
                <a class="nav-link" href="{{ route('admin.habitacion.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-box"></i></div>
                    HABITACIONES
                </a>
                @endcan
                @can('admin.cajas.index')
                <a class="nav-link" href="{{ route('admin.cajas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-box"></i></div>
                    CAJA
                </a>
                @endcan
                @can('admin.gastos.index')
                <a class="nav-link" href="{{ route('admin.gastos.create') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    GASTOS
                </a>
                @endcan
                @can('admin.clientes.index')
                <a class="nav-link" href="{{ route('admin.clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    CLIENTES
                </a>
                @endcan
                @can('admin.movimientos.index')
                <a class="nav-link" href="{{ route('admin.movimientos.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    MOVIMIENTOS
                </a>
                @endcan
                @can('admin.list')
                <div class="sb-sidenav-menu-heading">LISTADOS</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    REPORTES
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseReportes" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @can('admin.venta.show')
                        <a class="nav-link" href="{{ route('admin.venta.show') }}">Listado de Ventas</a>
                        @endcan
                        @can('admin.productos.index')
                        <a class="nav-link" href="{{ route('admin.productos.index') }}">Listado de Productos</a>
                        @endcan
                        @can('admin.empleados.index')
                        <a class="nav-link" href="{{ route('admin.empleados.index') }}">Listado de Empleados</a>
                        @endcan
                        @can('admin.formas.index')
                        <a class="nav-link" href="{{ route('admin.formas.index') }}">Listado de Formas</a>
                        @endcan
                        @can('admin.categorias.index')
                        <a class="nav-link" href="{{ route('admin.categorias.index') }}">Listado de Categorias</a>
                        @endcan
                        @can('admin.gastos.index')
                        <a class="nav-link" href="{{ route('admin.gastos.index') }}">Listado de Gatos</a>
                        @endcan
                        @can('admin.clientes.index')
                        <a class="nav-link" href="{{ route('admin.clientes.index') }}">Listado de Clientes</a>
                        @endcan
                        @can('admin.compra.show')
                        <a class="nav-link" href="{{ route('admin.compra.show') }}">Listado de Compras</a>
                        @endcan
                    </nav>
                </div>
                @endcan
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido: {{ auth()->user()->name }}</div>
            <hr class="dropdown-divider" />
            <div>
                <a class="dropdown-item backg" href="{{ route('logout') }}">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
</div>