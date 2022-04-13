<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Services</title>
</head>

<body>
    <?php $this->load->view('provider/navbar') ?>
    <section>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline">My Services</h4>
                    <div class="d-inline float-end">
                        <a href="<?php echo site_url('provider/add_service') ?>" type="button" class="btn btn-primary">New Service</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php $this->load->view('alert'); ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($services) :
                                foreach ($services as $item) :
                            ?>
                                    <tr>
                                        <td><?php echo $item->name; ?></td>
                                        <td><?php echo $item->description; ?></td>
                                        <td>$<?php echo $item->price; ?></td>
                                        <td>
                                            <?php if ($item->status) : ?>
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            <?php else : ?>
                                                <span class="badge rounded-pill bg-warning">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span><a type="button" class="btn btn-info" href="<?php echo site_url('provider/edit_service/' . $item->id) ?>">Edit</a></span>
                                            <span><a type="button" class="btn btn-danger" href="<?php echo site_url('provider/delete_service/' . $item->id) ?>">Delete</a></span>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <tr>
                                    <td colspan="5">No Records Found</td>
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
        var page = document.getElementById('service');
        page.classList.add('active');
    </script>
</body>

</html>