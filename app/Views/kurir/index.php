<!DOCTYPE html>
<html>
<head>
    <title>Kurir List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('partials/navbar') ?>
    <div class="container mt-4">
        <h2>Kurir List</h2>
        <a href="/kurir/create" class="btn btn-primary mb-3">Add Kurir</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>No HP</th>
                    <th>Username</th>
                    <th>Region</th>
                    <th>No Polisi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($kurir as $kr): ?>
                <tr>
                    <td><?= $kr['id'] ?></td>
                    <td><?= $kr['nama_lengkap'] ?></td>
                    <td><?= $kr['nohp'] ?></td>
                    <td><?= $kr['username'] ?></td>
                    <td><?= $kr['region'] ?></td>
                    <td><?= $kr['no_polisi'] ?></td>
                    <td>
                        <a href="/kurir/edit/<?= $kr['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/kurir/delete/<?= $kr['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>