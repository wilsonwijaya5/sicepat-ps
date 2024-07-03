<!DOCTYPE html>
<html>
<head>
    <title>Edit Kurir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('partials/navbar') ?>
    <div class="container mt-4">
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
                <input type="text" class="form-control" name="region" value="<?= $kurir['region'] ?>" required>
            </div>
            <div class="form-group">
                <label for="no_polisi">No Polisi</label>
                <input type="text" class="form-control" name="no_polisi" value="<?= $kurir['no_polisi'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
