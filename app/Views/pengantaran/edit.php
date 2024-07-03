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
            <input type="text" class="form-control" id="region" name="region" value="<?= $pengantaran['region'] ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_kurir">Nama Kurir</label>
            <input type="text" class="form-control" id="nama_kurir" name="nama_kurir" value="<?= $pengantaran['nama_kurir'] ?>" required>
        </div>
        <div class="form-group">
            <label for="jumlah_paket">Jumlah Paket</label>
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= $pengantaran['jumlah_paket'] ?>" required>
        </div>
        <div class="form-group">
            <label for="nomor_resi">Nomor Resi</label>
            <input type="text" class="form-control" id="nomor_resi" name="nomor_resi" value="<?= $pengantaran['nomor_resi'] ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_penerima">Nama Penerima</label>
            <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="<?= $pengantaran['nama_penerima'] ?>" required>
        </div>
        <div class="form-group">
            <label for="nohp">Nomor HP Penerima</label>
            <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $pengantaran['nohp'] ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat_penerima">Alamat Penerima</label>
            <textarea class="form-control" id="alamat_penerima" name="alamat_penerima" rows="3" required><?= $pengantaran['alamat_penerima'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="map">Pilih Lokasi pada Peta</label>
            <div id="map" style="height: 400px;"></div>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" value="<?= $pengantaran['latitude'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" value="<?= $pengantaran['longitude'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="tanggal_pengantaran">Tanggal Pengantaran</label>
            <input type="date" class="form-control" id="tanggal_pengantaran" name="tanggal_pengantaran" value="<?= $pengantaran['tanggal_pengantaran'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <script>
        var map;
        var marker;
        var geocoder;

        function initMap() {
            var initialLocation = { lat: <?= $pengantaran['latitude'] ?>, lng: <?= $pengantaran['longitude'] ?> };

            map = new google.maps.Map(document.getElementById('map'), {
                center: initialLocation,
                zoom: 15
            });

            marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true
            });

            // Update marker position saat marker didrag
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                updateAddress(event.latLng);
            });

            // Update marker position saat map diklik
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                updateAddress(event.latLng);
            });

            // Geocoder instance
            geocoder = new google.maps.Geocoder();

            // Ambil alamat berdasarkan koordinat saat ini
            geocodeLatLng(initialLocation);
        }

        // Fungsi untuk mendapatkan alamat berdasarkan koordinat
        function geocodeLatLng(latlng) {
            geocoder.geocode({ 'location': latlng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima').value = results[0].formatted_address;
                    } else {
                        window.alert('Alamat tidak ditemukan');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }

        // Fungsi untuk mengupdate alamat penerima berdasarkan koordinat baru
        function updateAddress(latLng) {
            geocoder.geocode({ 'location': latLng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima').value = results[0].formatted_address;
                    } else {
                        window.alert('Alamat tidak ditemukan');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&callback=initMap">
    </script>
<?= $this->endSection() ?>
