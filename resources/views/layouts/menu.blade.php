<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home" style="color: green;"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shopping-cart" style="color: green;"></i>
        <p>Products</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('departments.index') }}" class="nav-link {{ Request::is('departments*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users" style="color: green;"></i>
        <p>Departments</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('clients.index') }}" class="nav-link {{ Request::is('clients*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-address-book" style="color: green;"></i>
        <p>Clients</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('employees.index') }}" class="nav-link {{ Request::is('employees*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user" style="color: green;"></i>
        <p>Employees</p>
    </a>
</li>

@if(!auth()->user()->hasRole('super admin'))
<li class="nav-item">
    <a href="{{ route('daily_reports.index') }}" class="nav-link">
        <i class="nav-icon fas fa-file-alt" style="color: green;"></i>
        <p>Employee Reports</p>
    </a>
</li>
@endif

<li class="nav-item">
    <a href="{{ route('interactions.index') }}" class="nav-link {{ Request::is('interactions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tasks" style="color: green;"></i>
        <p>Interactions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('leads.index') }}" class="nav-link {{ Request::is('leads*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-address-book" style="color: green;"></i>
        <p>Leads</p>
    </a>
</li>

@if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('financial accountant'))
<li class="nav-item">
    <a href="{{ route('orders.index') }}" class="nav-link {{ Request::is('orders*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shopping-basket" style="color: green;"></i>
        <p>Orders</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-credit-card" style="color: green;"></i>
        <p>Transactions</p>
    </a>
</li>
@endif

@if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('head of department'))
    <li class="nav-item">
        <a href="{{ route('reports.index') }}" class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar" style="color: green;"></i>
            <p>Daily Reports</p>
        </a>
    </li>
@endif

<li class="nav-item">
    <a href="{{ route('enquiries.index') }}" class="nav-link {{ Request::is('enquiries*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope" style="color: green;"></i>
        <p>Enquiries</p>
    </a>
</li>

@if(auth()->user()->hasRole('super admin'))
    <li class="nav-item has-treeview {{ Request::is('roles*') || Request::is('permissions*') || Request::is('user*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('roles*') || Request::is('permissions*') || Request::is('user*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users-cog" style="color: green;"></i>
            <p>
                Users and Controls
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users-cog" style="color: green;"></i>
                    <p>Roles</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-key" style="color: green;"></i>
                    <p>Permissions</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users" style="color: green;"></i>
                    <p>Users</p>
                </a>
            </li>
        </ul>
    </li>
@endif





