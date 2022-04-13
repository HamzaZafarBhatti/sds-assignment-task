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
                    <h4>Update Service</h4>
                </div>
                <div class="card-body">
                    <?php $this->load->view('alert'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?php echo site_url('provider/update_service/'.$service->id); ?>" method="post">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" value="<?php echo $service->name; ?>" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" cols="30" rows="3" class="form-control" required><?php echo $service->description; ?></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" name="price" value="<?php echo $service->price; ?>" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="1" <?php echo $service->status ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?php echo !$service->status ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="submit" value="Update" class="btn btn-primary float-end ms-3">
                                    <a href="<?php echo site_url('provider/services'); ?>" type="button" class="btn btn-secondary float-end">Back</a>
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