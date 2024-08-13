<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Bukti List</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal Terima</th>
            <th>Waktu</th>
            <th>Keterangan</th>
            <th>Kordinat</th>
            <th>Gambar</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bukti as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal_terima'] ?></td>
                <td><?= $row['waktu'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td><?= $row['coordinate'] ?></td>
                <td>
                    <!-- Display image from Cloudinary -->
                    <img src="https://res.cloudinary.com/huajcm9nv/image/upload/<?= $row['gambar'] ?>" alt="Gambar Bukti" style="max-width: 150px;">
                </td>
                <td>
                    <a href="/bukti/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/bukti/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
