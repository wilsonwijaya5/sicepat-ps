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
            <input type="text" class="form-control" id="nama_kurir" name="nama_kurir" value="<?= old('nama_kurir', esc($pengantaran['nama_kurir'] ?? '')) ?>" required>
        </div>
        <div class="form-group">
            <label for="jumlah_paket">Jumlah Paket</label>
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= esc($pengantaran['jumlah_paket'] ?? '') ?>" readonly>
        </div>

        <!-- Container untuk detail pengantaran -->
        <div id="detail_pengantaran_container">
            <!-- JavaScript akan menambahkan input fields di sini -->
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>

    <script>
        // Fungsi untuk menambahkan input fields untuk detail pengantaran
        function addDetailPengantaranFields() {
            var detailPengantaran = <?= json_encode($detail_pengantaran) ?>; // Ambil detail pengantaran dari PHP ke JavaScript
            var container = document.getElementById('detail_pengantaran_container');
            container.innerHTML = ''; // Bersihkan container sebelum menambahkan fields baru

            detailPengantaran.forEach(function(detail, index) {
                var div = document.createElement('div');
                div.classList.add('form-group');

                div.innerHTML = `
                    <h4>Detail Pengantaran Paket ${index + 1}</h4>
                    <label for="tanggal_pengantaran_${index}">Tanggal Pengantaran</label>
                    <input type="date" class="form-control" id="tanggal_pengantaran_${index}" name="tanggal_pengantaran[]" value="<?= old('tanggal_pengantaran[]', esc($detail['tanggal_pengantaran'] ?? '')) ?>" required>

                    <label for="nama_penerima_${index}">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penerima_${index}" name="nama_penerima[]" value="<?= old('nama_penerima[]', esc($detail['nama_penerima'] ?? '')) ?>" required>

                    <label for="nohp_${index}">Nomor HP Penerima</label>
                    <input type="text" class="form-control" id="nohp_${index}" name="nohp[]" value="<?= old('nohp[]', esc($detail['nohp'] ?? '')) ?>" required>

                    <label for="alamat_penerima_${index}">Alamat Penerima</label>
                    <textarea class="form-control" id="alamat_penerima_${index}" name="alamat_penerima[]" rows="3" required><?= old('alamat_penerima[]', esc($detail['alamat_penerima'] ?? '')) ?></textarea>

                    <input type="hidden" id="latitude_${index}" name="latitude[]" value="<?= esc($detail['latitude'] ?? '') ?>">
                    <input type="hidden" id="longitude_${index}" name="longitude[]" value="<?= esc($detail['longitude'] ?? '') ?>">

                    <label for="map_${index}">Pilih Lokasi pada Peta</label>
                    <div id="map_${index}" style="height: 300px;"></div>
                    <hr>
                `;

                container.appendChild(div);

                // Initialize maps and markers here for each field
                initMap(index, detail['latitude'], detail['longitude']);
            });
        }

        // Panggil fungsi untuk menambahkan fields saat halaman dimuat
        document.addEventListener('DOMContentLoaded', addDetailPengantaranFields);

        // Initialize maps and markers
        function initMap(index, latitude, longitude) {
            var map;
            var marker;
            var geocoder;

            // Set default location or fetch from existing data if available
            var defaultLocation = { lat: parseFloat(latitude) || 0, lng: parseFloat(longitude) || 0 }; // Default location

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
