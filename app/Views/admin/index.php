<!DOCTYPE html>
<html>
<head>
    <title>Admin List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('partials/navbar') ?>
    <div class="container mt-4">
        <h2>Admin List</h2>
        <a href="/admin/create" class="btn btn-primary mb-3">Add Admin</a>
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
    </div>
</body>
</html>
