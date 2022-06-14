<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="<?= base_url('/dashboard') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <?php
    if(ableUpload($_SESSION['user']['role'])) {
        ?>
        <li class="nav-item">
            <a href="<?= base_url('/file-upload') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'file-upload' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-upload"></i>
                <p>File Upload</p>
            </a>
        </li>
        <?php
    }
    ?>

    <li class="nav-item">
        <a href="<?= base_url('/manual-capture') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'manual-capture' ? 'active' : '' ?>">
            <i class="nav-icon fa fa-keyboard" aria-hidden="true"></i>
            <p>Manual Capture</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= base_url('/schedule-payments') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'schedule-payments' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-pie" aria-hidden="true"></i>              
            <p>Schedule Payments</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= base_url('/payment-activity') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'payment-activity' ? 'active' : '' ?>">
            <i class="nav-icon fa fa-industry" aria-hidden="true"></i>
            <p>Payment Activity</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= base_url('/participants') ?>" class="nav-link <?php echo isset($sub_page) && $sub_page == 'participants' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-university"></i>
            <p>Participants</p>
        </a>
    </li>

    <li class="nav-item separator"></li>

    <li class="nav-item mt-4">
        <a target="_blank" href="<?= base_url('/payconnectfaq.pdf') ?>" class="nav-link">
            <i class="nav-icon fa fa-question-circle" aria-hidden="true"></i>
            <p>FAQ</p>
        </a>
    </li>

</ul>