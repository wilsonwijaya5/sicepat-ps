<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Data Pengantaran</h1>
    <a href="/pengantaran/create" class="btn btn-primary mb-3">Tambah Data Pengantaran</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Region</th>
                <th scope="col">Nama Kurir</th>
                <th scope="col">Jumlah Paket</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengantaran as $pengantar): ?>
                <tr>
                    <td><?= $pengantar['id'] ?></td>
                    <td><?= $pengantar['region'] ?></td>
                    <td><?= $pengantar['nama_lengkap'] ?></td> <!-- Memperbaiki untuk menggunakan 'nama_lengkap' dari 'kurir' -->
                    <td><?= $pengantar['jumlah_paket'] ?></td>
                    <td>
                        <a href="/pengantaran/edit/<?= $pengantar['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/pengantaran/delete/<?= $pengantar['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
