<?php
$uri = service('uri');
$currentSegment = $uri->getSegment(2);
?>
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">T Shop Inventory</span>
    </a>
    <h6 class="text-uppercase mb-3">Management</h6>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('admin') ?>" class="nav-link text-white <?= ($currentSegment == '') ? 'active' : '' ?>" aria-current="page">
                <img src="<?= base_url('include/admin_asset/svg/Home.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Home
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/products') ?>" class="nav-link text-white <?= ($currentSegment == 'products') ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/productal.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Products
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/addnewproduct') ?>" class="nav-link text-white <?= ($currentSegment == 'addnewproduct') ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/icons8-plus.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Add Product
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/sell/view/iteams') ?>" class="nav-link text-white <?= ($currentSegment == "sell") ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/buy.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Sell Product
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/sellbulk') ?>" class="nav-link text-white <?= ($currentSegment == "sellbulk") ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/buy.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Sell Bulk Product
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/invoice-list') ?>" class="nav-link text-white <?= ($currentSegment == "invoice-list") ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/buy.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Invoice List
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/expenses') ?>" class="nav-link text-white <?= ($currentSegment == "expenses") ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/buy.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                Extra Expenses
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/reports') ?>" class="nav-link text-white <?= ($currentSegment == 'reports') ? 'active' : '' ?>">
                <img src="<?= base_url('include/admin_asset/svg/static.svg') ?>" alt="product add icon" width="20"
                    height="20" class="me-2">
                </svg>
                reports
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= base_url('include/admin_asset/svg/user.svg') ?>" alt="" width="32" height="32"
                class="rounded-circle me-2">
            <strong><?= $user_name ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="<?= base_url('admin/user') ?>">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Sign out</a></li>
        </ul>
    </div>
</div>
<div class="b-example-divider"></div>

<!-- Page content -->