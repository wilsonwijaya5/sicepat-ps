<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <title>Edit Kurir</title>
    <?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <h2>Edit Kurir</h2>
    <form action="/kurir/update/<?= $kurir['id'] ?>" method="post">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="<?= $kurir['nama_lengkap'] ?>" required>
        </div>
        <div class="form-group">
            <label for="nohp">No HP</label>
            <input type="text" class="form-control" name="nohp" value="<?= $kurir['nohp'] ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $kurir['username'] ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="region">Region</label>
            <select class="form-control" name="region" required>
                <option value="Payung Sekaki" <?= ($kurir['region'] == 'Payung Sekaki') ? 'selected' : '' ?>>Payung Sekaki</option>
                <option value="Rumbai" <?= ($kurir['region'] == 'Rumbai') ? 'selected' : '' ?>>Rumbai</option>
                <option value="Sukajadi" <?= ($kurir['region'] == 'Sukajadi') ? 'selected' : '' ?>>Sukajadi</option>
                <option value="Senapelan" <?= ($kurir['region'] == 'Senapelan') ? 'selected' : '' ?>>Senapelan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="no_polisi">No Polisi</label>
            <input type="text" class="form-control" name="no_polisi" value="<?= $kurir['no_polisi'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
<?= $this->endSection() ?>
