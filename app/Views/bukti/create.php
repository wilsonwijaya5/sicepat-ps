<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Create Bukti</h1>

<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/bukti/store" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="tanggal_terima">Tanggal Terima</label>
        <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" required>
    </div>
    <div class="form-group">
        <label for="waktu">Waktu</label>
        <input type="time" class="form-control" id="waktu" name="waktu" required>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="gambar">Gambar</label>
        <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?= $this->endSection() ?>
