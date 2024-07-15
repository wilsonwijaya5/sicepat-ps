<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Edit Data Pengantaran</h1>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/pengantaran/update/<?= $pengantaran['id'] ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="region">Region</label>
            <input type="text" class="form-control" id="region" name="region" value="<?= old('region', esc($pengantaran['region'] ?? '')) ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_kurir">Nama Kurir</label>
            <select class="form-control" id="nama_kurir" name="kurir_id" required>
                <?php foreach ($kurirs as $kurir): ?>
                    <option value="<?= $kurir['id'] ?>" <?= ($pengantaran['kurir_id'] == $kurir['id']) ? 'selected' : '' ?>>
                        <?= esc($kurir['nama_lengkap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_paket">Jumlah Paket</label>
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= old('jumlah_paket', esc($pengantaran['jumlah_paket'] ?? '')) ?>" required>
        </div>

        <h2>Detail Pengantaran</h2>
        <?php foreach ($detail_pengantaran as $index => $detail): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <input type="hidden" name="detail_pengantaran[<?= $index ?>][id]" value="<?= $detail['id'] ?>">
                    <div class="form-group">
                        <label for="no_resi">No. Resi</label>
                        <input type="text" class="form-control" id="no_resi" name="detail_pengantaran[<?= $index ?>][no_resi]" value="<?= old("detail_pengantaran.${index}.no_resi", esc($detail['no_resi'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_penerima">Nama Penerima</label>
                        <input type="text" class="form-control" id="nama_penerima" name="detail_pengantaran[<?= $index ?>][nama_penerima]" value="<?= old("detail_pengantaran.${index}.nama_penerima", esc($detail['nama_penerima'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nohp">No. HP</label>
                        <input type="text" class="form-control" id="nohp" name="detail_pengantaran[<?= $index ?>][nohp]" value="<?= old("detail_pengantaran.${index}.nohp", esc($detail['nohp'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_penerima">Alamat Penerima</label>
                        <input type="text" class="form-control" id="alamat_penerima" name="detail_pengantaran[<?= $index ?>][alamat_penerima]" value="<?= old("detail_pengantaran.${index}.alamat_penerima", esc($detail['alamat_penerima'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengantaran">Tanggal Pengantaran</label>
                        <input type="date" class="form-control" id="tanggal_pengantaran" name="detail_pengantaran[<?= $index ?>][tanggal_pengantaran]" value="<?= old("detail_pengantaran.${index}.tanggal_pengantaran", esc($detail['tanggal_pengantaran'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="detail_pengantaran[<?= $index ?>][status]" value="<?= old("detail_pengantaran.${index}.status", esc($detail['status'] ?? '')) ?>" required>
                    </div>
                    <div id="map<?= $index ?>" style="height: 200px; margin-bottom: 10px;"></div>

                </div>
            </div>

            <!-- Inisialisasi peta untuk detail pengantaran -->
            <script>
                function initializeMap<?= $index ?>() {
                    var location = { lat: <?= esc($detail['latitude'] ?? '0') ?>, lng: <?= esc($detail['longitude'] ?? '0') ?> };
                    var map = new google.maps.Map(document.getElementById('map<?= $index ?>'), {
                        center: location,
                        zoom: 15
                    });
                    var marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });
                }
                initializeMap<?= $index ?>();
            </script>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Update Pengantaran</button>
    </form>

    <!-- Load Google Maps API dengan kunci API Anda -->
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&callback=initMap">
    </script>
<?= $this->endSection() ?>
