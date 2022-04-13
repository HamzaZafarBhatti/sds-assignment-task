<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Service</title>
</head>

<body>
    <?php $this->load->view('provider/navbar') ?>
    <section>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h4>Add Service</h4>
                </div>
                <div class="card-body">
                    <?php $this->load->view('alert'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?php echo site_url('provider/store_service') ?>" method="post">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" cols="30" rows="3" class="form-control" required></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" name="price" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="submit" value="Add" class="btn btn-primary float-end">
                                </div>
                            </form>
                        </div>
                    </div>
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