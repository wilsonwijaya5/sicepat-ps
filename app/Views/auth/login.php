<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>Login</h2>
            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
            <?php endif; ?>
            <form action="/loginSubmit" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
