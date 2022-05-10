<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="<?= base_url('/dashboard') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('/transactions') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'payment-activity' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-list"></i>
            <p>Transactions</p>
        </a>
    </li>

    <li class="nav-item separator"></li>

    <li class="nav-item">
        <a href="<?= base_url('/participants') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'participants' ? 'active' : '' ?>">
            <i class="nav-icon fa fa-university" aria-hidden="true"></i>
            <p>Participants</p>
        </a>
    </li>

    <li class="nav-item separator"></li>

    <li class="nav-item <?php echo isset($sub_page) && ($sub_page == 'email-server' || $sub_page == 'api-gateways') ? 'menu-is-opening menu-open' : '' ?>">
        <a href="#" class="nav-link <?php echo isset($sub_page) && ($sub_page == 'email-server' || $sub_page == 'api-gateways') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cogs" aria-hidden="true"></i>              
            <p>System Settings <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?= base_url('/email-server') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'email-server' ? 'active' : '' ?>">
                <i class="far fa-envelope nav-icon"></i>
                <p>Email Server</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="<?= base_url('/api-gateways') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'api-gateways' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-inbox"></i>
                <p>API Gateway</p>
            </a>
            </li>
        </ul>
    </li>

    <li class="nav-item separator"></li>

    <li class="nav-item <?php echo isset($sub_page) && ($sub_page == 'users' || $sub_page == 'user-activities') ? 'menu-is-opening menu-open' : '' ?>">
        <a href="#" class="nav-link <?php echo isset($sub_page) && ($sub_page == 'users' || $sub_page == 'user-activities') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user" aria-hidden="true"></i>
            <p>User Management <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?= base_url('/users') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'users' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="<?= base_url('/user-activities') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'user-activities' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>User Activity</p>
            </a>
            </li>

        </ul>
    </li>

    <li class="nav-item separator"></li>

    <li class="nav-item mt-4">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-comment" aria-hidden="true"></i>
            <p>Help</p>
        </a>
    </li>

</ul>