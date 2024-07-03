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
            <input type="text" class="form-control" id="region" name="region" value="<?= old('region', esc($pengantaran['region'])) ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_kurir">Nama Kurir</label>
            <input type="text" class="form-control" id="nama_kurir" name="nama_kurir" value="<?= old('nama_kurir', esc($pengantaran['nama_kurir'])) ?>" required>
        </div>
        <div class="form-group">
            <label for="jumlah_paket">Jumlah Paket</label>
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= esc($pengantaran['jumlah_paket']) ?>" readonly>
        </div>

        <!-- Container untuk detail pengantaran -->
        <div id="detail_pengantaran_container">
            <!-- JavaScript akan menambahkan input fields di sini -->
        </div>

        <div class="form-group">
            <label for="tanggal_pengantaran">Tanggal Pengantaran</label>
            <input type="date" class="form-control" id="tanggal_pengantaran" name="tanggal_pengantaran" value="<?= old('tanggal_pengantaran', esc($pengantaran['tanggal_pengantaran'])) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <script>
        // Fungsi untuk menambahkan input fields untuk detail pengantaran
        function addDetailPengantaranFields() {
            var jumlahPaket = <?= $pengantaran['jumlah_paket'] ?>;
            var container = document.getElementById('detail_pengantaran_container');
            container.innerHTML = ''; // Bersihkan container sebelum menambahkan fields baru

            <?php foreach ($detail_pengantaran as $i => $detail): ?>
                var div = document.createElement('div');
                div.classList.add('form-group');

                div.innerHTML = `
                    <h4>Detail Pengantaran Paket ${<?= $i ?> + 1}</h4>
                    <label for="nama_penerima_${<?= $i ?>}">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penerima_${<?= $i ?>}" name="nama_penerima[]" value="<?= old('nama_penerima[]', esc($detail['nama_penerima'])) ?>" required>

                    <label for="nohp_${<?= $i ?>}">Nomor HP Penerima</label>
                    <input type="text" class="form-control" id="nohp_${<?= $i ?>}" name="nohp[]" value="<?= old('nohp[]', esc($detail['nohp'])) ?>" required>

                    <label for="alamat_penerima_${<?= $i ?>}">Alamat Penerima</label>
                    <textarea class="form-control" id="alamat_penerima_${<?= $i ?>}" name="alamat_penerima[]" rows="3" required><?= old('alamat_penerima[]', esc($detail['alamat_penerima'])) ?></textarea>

                    <input type="hidden" id="latitude_${<?= $i ?>}" name="latitude[]" value="<?= esc($detail['latitude']) ?>">
                    <input type="hidden" id="longitude_${<?= $i ?>}" name="longitude[]" value="<?= esc($detail['longitude']) ?>">

                    <label for="map_${<?= $i ?>}">Pilih Lokasi pada Peta</label>
                    <div id="map_${<?= $i ?>}" style="height: 300px;"></div>
                    <hr>
                `;

                container.appendChild(div);

                // Initialize maps and markers here for each field
                initMap(<?= $i ?>);
            <?php endforeach; ?>
        }

        // Panggil fungsi untuk menambahkan fields saat halaman dimuat
        document.addEventListener('DOMContentLoaded', addDetailPengantaranFields);

        // Initialize maps and markers
        function initMap(index) {
            var map;
            var marker;
            var geocoder;

            // Set default location or fetch from existing data if available
            var defaultLocation = { lat: <?= esc($detail_pengantaran[$i]['latitude'] ?? 0) ?>, lng: <?= esc($detail_pengantaran[$i]['longitude'] ?? 0) ?> }; // Default location

            // Create map and marker for each field
            map = new google.maps.Map(document.getElementById('map_' + index), {
                center: defaultLocation,
                zoom: 15
            });

            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude_' + index).value = event.latLng.lat();
                document.getElementById('longitude_' + index).value = event.latLng.lng();
                updateAddress(index, event.latLng);
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude_' + index).value = event.latLng.lat();
                document.getElementById('longitude_' + index).value = event.latLng.lng();
                updateAddress(index, event.latLng);
            });

            // Geocoder instance
            geocoder = new google.maps.Geocoder();

            // Get address based on initial coordinates
            geocoder.geocode({ 'location': defaultLocation }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima_' + index).value = results[0].formatted_address;
                    } else {
                        alert('Alamat tidak ditemukan');
                    }
                } else {
                    alert('Geocoder gagal: ' + status);
                }
            });
        }

        // Update address based on new coordinates
        function updateAddress(index, latLng) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'location': latLng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima_' + index).value = results[0].formatted_address;
                    } else {
                        alert('Alamat tidak ditemukan');
                    }
                } else {
                    alert('Geocoder gagal: ' + status);
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=addDetailPengantaranFields" async defer></script>
<?= $this->endSection() ?>
