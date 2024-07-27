<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Edit Bukti</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/bukti/update/<?= $bukti['id'] ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="tanggal_terima">Tanggal Terima</label>
        <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" value="<?= esc($bukti['tanggal_terima']) ?>" required>
    </div>
    <div class="form-group">
        <label for="waktu">Waktu</label>
        <input type="time" class="form-control" id="waktu" name="waktu" value="<?= esc($bukti['waktu']) ?>" required>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?= esc($bukti['keterangan']) ?></textarea>
    </div>
    <div class="form-group">
        <label for="gambar">Gambar</label>
        <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
        <?php if (!empty($bukti['gambar'])): ?>
            <?php
            // Construct the Cloudinary URL
            $imageUrl = 'https://res.cloudinary.com/hv4fjb6q8/image/upload/' . esc($bukti['gambar']);
            ?>
            <input type="hidden" name="gambar_lama" value="<?= esc($bukti['gambar']) ?>">
            <div class="mt-2">
                <p>Image URL: <?= esc($imageUrl) ?></p>
                <img src="<?= esc($imageUrl) ?>" alt="Current Gambar" style="max-width: 200px;">
            </div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?= $this->endSection() ?>
