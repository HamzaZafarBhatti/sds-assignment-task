<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url('provider/dashboard') ?>">Sigma Digital Solutions</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" id="service" aria-current="page" href="<?php echo site_url('provider/services') ?>">My Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order" aria-current="page" href="<?php echo site_url('provider/orders') ?>">Orders</a>
                </li>
            </ul>
            <div class="d-flex" style="gap: 10px">
                <a class="btn btn-outline-success" id="profile" type="button" aria-current="page" href="<?php echo site_url('provider/profile') ?>">Profile</a>
                <a class="btn btn-outline-success" type="button" aria-current="page" href="<?php echo site_url('provider/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</nav>