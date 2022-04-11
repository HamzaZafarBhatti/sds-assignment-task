<?php
if (isset($_SESSION['success'])) {
?>
    <div class="alert alert-success" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php
}
if (isset($_SESSION['error'])) {
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php
}
?>