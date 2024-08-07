<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <title>Add Kurir</title>
    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <h2>Add Kurir</h2>
    <form action="/kurir/store" method="post">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" required>
        </div>
        <div class="form-group">
            <label for="nohp">No HP</label>
            <input type="text" class="form-control" name="nohp" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="region">Region</label>
            <select class="form-control" name="region" required>
                <option value="Payung Sekaki">Payung Sekaki</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Senapelan">Senapelan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="no_polisi">No Polisi</label>
            <input type="text" class="form-control" name="no_polisi" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
<?= $this->endSection() ?>
