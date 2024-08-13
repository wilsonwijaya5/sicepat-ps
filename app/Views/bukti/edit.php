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
        <?php if (!empty($bukti['gambar'])): ?>
            <?php
            // Construct the Cloudinary URL
            $imageUrl = 'https://res.cloudinary.com/huajcm9nv/image/upload/' . esc($bukti['gambar']);
            ?>
            <input type="hidden" name="gambar_lama" value="<?= esc($bukti['gambar']) ?>">
            <div class="mt-2">
                <img src="<?= esc($imageUrl) ?>" alt="Current Gambar" style="max-width: 200px;">
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="timestamp">Timestamp</label>
        <input type="datetime-local" class="form-control" id="timestamp" name="timestamp" value="<?= esc(date('Y-m-d\TH:i', strtotime($bukti['timestamp'] ?? ''))) ?>" required>
    </div>
    <div class="form-group">
        <label for="coordinate">Coordinate</label>
        <input type="text" class="form-control" id="coordinate" name="coordinate" value="<?= esc($bukti['coordinate'] ?? '') ?>" placeholder="Enter coordinates (e.g., latitude,longitude)">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->endSection() ?>
