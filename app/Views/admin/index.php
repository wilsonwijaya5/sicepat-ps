<!DOCTYPE html>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
        <h2>Admin List</h2>
        <a href="/admin/create" class="btn btn-primary mb-3">Add Admin</a>
        <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php elseif(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>No HP</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($admin as $adm): ?>
                <tr>
                    <td><?= $adm['id'] ?></td>
                    <td><?= $adm['nama_lengkap'] ?></td>
                    <td><?= $adm['nohp'] ?></td>
                    <td><?= $adm['username'] ?></td>
                    <td>
                        <a href="/admin/edit/<?= $adm['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/admin/delete/<?= $adm['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 
<?= $this->endSection() ?>