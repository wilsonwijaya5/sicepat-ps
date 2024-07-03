<!DOCTYPE html>
<html>
<head>
    <title>Add Kurir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('partials/navbar') ?>
    <div class="container mt-4">
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
                <input type="text" class="form-control" name="region" required>
            </div>
            <div class="form-group">
                <label for="no_polisi">No Polisi</label>
                <input type="text" class="form-control" name="no_polisi" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>
