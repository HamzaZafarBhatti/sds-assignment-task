<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Orders</title>
</head>

<body>
    <?php $this->load->view('customer/navbar') ?>
    <section>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline">My Orders</h4>
                </div>
                <div class="card-body">
                    <?php $this->load->view('alert'); ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($orders) :
                                foreach ($orders as $item) :
                            ?>
                                    <tr>
                                        <td><?php echo $item->service_name; ?></td>
                                        <td>$<?php echo $item->price; ?></td>
                                        <td>
                                            <?php if ($item->status == 1) : ?>
                                                <span class="badge rounded-pill bg-success">Paid</span>
                                            <?php elseif ($item->status == 2) : ?>
                                                <span class="badge rounded-pill bg-warning">Rejected</span>
                                            <?php else : ?>
                                                <span class="badge rounded-pill bg-warning">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <tr>
                                    <td colspan="3">No Records Found</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        var page = document.getElementById('order');
        page.classList.add('active');
    </script>
</body>

</html>