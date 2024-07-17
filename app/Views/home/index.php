<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <h1>Welcome to the Dashboard</h1>
        <p>This is your admin dashboard. Feel free to explore!</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-info">
                    <div class="card-body text-white">
                        <h5 class="card-title">Pending</h5>
                        <p class="card-text"><?= $pendingCount ?></p>
                    </div>  
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning">
                    <div class="card-body text-white">
                        <h5 class="card-title">On Delivery</h5>
                        <p class="card-text"><?= $onDeliveryCount ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body text-white">
                        <h5 class="card-title">Delivered</h5>
                        <p class="card-text"><?= $deliveredCount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>
