<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>

<body>
    <?php $this->load->view('provider/navbar') ?>
    <section>
        <div class="card">
            <div class="card-body">
                <?php $this->load->view('alert'); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-success bg-gradient shadow">
                            <div class="card-body">
                                <h5 class="card-title">My Services</h5>
                                <p class="card-text">Offering <?php echo $services_count ?> service(s)</p>
                                <a type="button" class="btn btn-light" href="<?php echo site_url('provider/services') ?>" class="card-link">See All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info bg-gradient shadow">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>
                                <p class="card-text"><?php echo $orders_count ?> orders(s)</p>
                                <a type="button" class="btn btn-light" href="<?php echo site_url('provider/orders') ?>" class="card-link">See All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-secondary bg-gradient shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title">Balance</h5>
                                <p class="card-text">$<?php echo $provider->balance ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>