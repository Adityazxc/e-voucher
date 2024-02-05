<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">E-Voucher </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <style>
        
        .link_active {
            background-color: #E9F5FE;
            margin: 10px;
            border-radius: 0.35rem;
            transition: background-color 0.3s;
        }

        .link_active a,
        .link_active a span,
        .link_active a i {
            color: #0C7FDA;
        }


    </style>
    <?php if ($role == 'CCC'): ?>
        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'ccc' && $this->uri->segment(2) == '') ? 'link_active' : ''; ?>">
            <div>
                <a class="nav-link" href="<?php echo base_url('ccc'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </li>
        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'ccc' && $this->uri->segment(2) == 'view_add_data') ? 'link_active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('ccc/view_add_data'); ?>">
                <i class="bi bi-plus-lg"></i>
                <span>Add Data</span>
            </a>
        </li>

        <!-- Redeem Voucher Link -->
    <?php endif; ?>

    <?php if ($role == 'Agen'): ?>
        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'agen' && $this->uri->segment(2) == '') ? 'link_active' : ''; ?>">
            <div>
                <a class="nav-link" href="<?php echo base_url('agen'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </li>

        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'agen' && $this->uri->segment(2) == 'redeem') ? 'link_active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('agen/redeem'); ?>">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Reedem Voucher</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($role == 'Marketing'): ?>
        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'marketing' && $this->uri->segment(2) == '') ? 'link_active' : ''; ?>">
            <div>
                <a class="nav-link" href="<?php echo base_url('marketing'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </li>

        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'marketing' && $this->uri->segment(2) == 'send_email') ? 'link_active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('marketing/send_email'); ?>">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Send Email</span>
            </a>
        </li>
        <!-- Redeem Voucher Link -->
    <?php endif; ?>
    <?php if ($role == 'Finance'): ?>
        <li
            class="nav-item <?php echo ($this->uri->segment(1) == 'finance' && $this->uri->segment(2) == '') ? 'link_active' : ''; ?>">
            <div>
                <a class="nav-link" href="<?php echo base_url('finance'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </li>    
        <!-- Redeem Voucher Link -->
    <?php endif; ?>
    <!-- Redeem Voucher Link -->



    <!-- Add Data Link -->
    <li class="nav-item" style="margin:10px">
        <a role="button" style="width: 100%;"class="btn btn-danger logout-btn" style="color:#FFFF; decoration:none;" href="<?php echo base_url('auth/logout'); ?>">Logout</a>
    </li>

</ul>