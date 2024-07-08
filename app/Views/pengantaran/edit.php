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
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= esc($pengantaran['jumlah_paket'] ?? '') ?>" readonly>
        </div>

        <!-- Container untuk detail pengantaran -->
        <div id="detail_pengantaran_container">
            <?php foreach ($detail_pengantaran as $index => $detail): ?>
                <div class="form-group">
                    <h4>Detail Pengantaran Paket <?= $index + 1 ?></h4>
                    <label for="tanggal_pengantaran_<?= $index ?>">Tanggal Pengantaran</label>
                    <input type="date" class="form-control" id="tanggal_pengantaran_<?= $index ?>" name="tanggal_pengantaran[]" value="<?= old('tanggal_pengantaran[]', esc($detail['tanggal_pengantaran'] ?? '')) ?>" required>

                    <label for="nama_penerima_<?= $index ?>">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penerima_<?= $index ?>" name="nama_penerima[]" value="<?= old('nama_penerima[]', esc($detail['nama_penerima'] ?? '')) ?>" required>

                    <label for="nohp_<?= $index ?>">Nomor HP Penerima</label>
                    <input type="text" class="form-control" id="nohp_<?= $index ?>" name="nohp[]" value="<?= old('nohp[]', esc($detail['nohp'] ?? '')) ?>" required>

                    <label for="alamat_penerima_<?= $index ?>">Alamat Penerima</label>
                    <textarea class="form-control" id="alamat_penerima_<?= $index ?>" name="alamat_penerima[]" rows="3" required><?= old('alamat_penerima[]', esc($detail['alamat_penerima'] ?? '')) ?></textarea>

                    <input type="hidden" id="latitude_<?= $index ?>" name="latitude[]" value="<?= esc($detail['latitude'] ?? '') ?>">
                    <input type="hidden" id="longitude_<?= $index ?>" name="longitude[]" value="<?= esc($detail['longitude'] ?? '') ?>">

                    <label for="map_<?= $index ?>">Pilih Lokasi pada Peta</label>
                    <div id="map_<?= $index ?>" style="height: 300px;"></div>
                    <hr>
                </div>
            <?php endforeach; ?>
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
                    <label for="no_resi_<?= $index ?>">Nomor Resi</label>
<input type="text" class="form-control" id="no_resi_<?= $index ?>" name="no_resi[]" value="<?= old('no_resi[]', esc($detail['no_resi'] ?? '')) ?>">

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
                initializeMap(index, {lat: parseFloat(detail.latitude), lng: parseFloat(detail.longitude)});
            });
        }

        // Initialize map for each detail pengantaran field
        function initializeMap(index, defaultLocation) {
            var mapOptions = {
                zoom: 15,
                center: defaultLocation
            };
            var map = new google.maps.Map(document.getElementById('map_' + index), mapOptions);
            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });
            marker.addListener('dragend', function(event) {
                document.getElementById('latitude_' + index).value = event.latLng.lat();
                document.getElementById('longitude_' + index).value = event.latLng.lng();
                updateAddress(index, event.latLng);
            });

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'location': defaultLocation }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima_' + index).value = results[0].formatted_address;
                    }
                }
            });
        }

        function updateAddress(index, latLng) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: latLng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('alamat_penerima_' + index).value = results[0].formatted_address;
                    }
                }
            });
        }

        // Panggil fungsi untuk menambahkan fields detail pengantaran saat halaman dimuat
        addDetailPengantaranFields();
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&callback=addDetailPengantaranFields">
    </script>
<?= $this->endSection() ?>
