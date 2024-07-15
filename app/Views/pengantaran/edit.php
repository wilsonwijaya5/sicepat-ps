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
                        <label for="no_resi<?= $index ?>">No. Resi</label>
                        <input type="text" class="form-control" id="no_resi<?= $index ?>" name="detail_pengantaran[<?= $index ?>][no_resi]" value="<?= old("detail_pengantaran.${index}.no_resi", esc($detail['no_resi'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_penerima<?= $index ?>">Nama Penerima</label>
                        <input type="text" class="form-control" id="nama_penerima<?= $index ?>" name="detail_pengantaran[<?= $index ?>][nama_penerima]" value="<?= old("detail_pengantaran.${index}.nama_penerima", esc($detail['nama_penerima'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nohp<?= $index ?>">No. HP</label>
                        <input type="text" class="form-control" id="nohp<?= $index ?>" name="detail_pengantaran[<?= $index ?>][nohp]" value="<?= old("detail_pengantaran.${index}.nohp", esc($detail['nohp'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_penerima<?= $index ?>">Alamat Penerima</label>
                        <input type="text" class="form-control" id="alamat_penerima<?= $index ?>" name="detail_pengantaran[<?= $index ?>][alamat_penerima]" value="<?= old("detail_pengantaran.${index}.alamat_penerima", esc($detail['alamat_penerima'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengantaran<?= $index ?>">Tanggal Pengantaran</label>
                        <input type="date" class="form-control" id="tanggal_pengantaran<?= $index ?>" name="detail_pengantaran[<?= $index ?>][tanggal_pengantaran]" value="<?= old("detail_pengantaran.${index}.tanggal_pengantaran", esc($detail['tanggal_pengantaran'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                    <label for="status<?= $index ?>">Status</label>
                    <select class="form-control" id="status<?= $index ?>" name="detail_pengantaran[<?= $index ?>][status]" required>
                        <option value="Pending" <?= ($detail['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="Delivered" <?= ($detail['status'] == 'Delivered') ? 'selected' : '' ?>>Delivered</option>
                        <option value="Failed" <?= ($detail['status'] == 'Failed') ? 'selected' : '' ?>>Failed</option>
                    </select>
                    </div>
                     </div>
                    <input type="hidden" id="latitude<?= $index ?>" name="detail_pengantaran[<?= $index ?>][latitude]" value="<?= old("detail_pengantaran.${index}.latitude", esc($detail['latitude'] ?? '')) ?>">
                    <input type="hidden" id="longitude<?= $index ?>" name="detail_pengantaran[<?= $index ?>][longitude]" value="<?= old("detail_pengantaran.${index}.longitude", esc($detail['longitude'] ?? '')) ?>">
                    <div id="map<?= $index ?>" style="height: 300px; margin-bottom: 10px;"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Update Pengantaran</button>
    </form>

    <script>
    function initMap() {
        <?php foreach ($detail_pengantaran as $index => $detail): ?>
            initializeMap<?= $index ?>();
        <?php endforeach; ?>
    }

    <?php foreach ($detail_pengantaran as $index => $detail): ?>
    function initializeMap<?= $index ?>() {
        var latitude = parseFloat(document.getElementById('latitude<?= $index ?>').value) || -6.2088;
        var longitude = parseFloat(document.getElementById('longitude<?= $index ?>').value) || 106.8456;
        var location = { lat: latitude, lng: longitude };

        var mapElement = document.getElementById('map<?= $index ?>');
        if (!mapElement) {
            console.error('Map element not found for index <?= $index ?>');
            return;
        }

        var map = new google.maps.Map(mapElement, {
            center: location,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });

        var geocoder = new google.maps.Geocoder();
        var addressInput = document.getElementById('alamat_penerima<?= $index ?>');

        google.maps.event.addListener(marker, 'dragend', function() {
            var latLng = marker.getPosition();
            updateLatLngInputs(latLng.lat(), latLng.lng(), <?= $index ?>);
            geocodePosition(latLng, <?= $index ?>);
        });

        if (addressInput) {
            addressInput.addEventListener('change', function() {
                geocodeAddress(geocoder, map, marker, <?= $index ?>);
            });
        }

        function updateLatLngInputs(lat, lng, index) {
            document.getElementById('latitude<?= $index ?>').value = lat;
            document.getElementById('longitude<?= $index ?>').value = lng;
        }

        function geocodePosition(pos, index) {
            geocoder.geocode({
                latLng: pos
            }, function(responses, status) {
                if (status === 'OK' && responses && responses.length > 0) {
                    addressInput.value = responses[0].formatted_address;
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                    addressInput.value = 'Cannot determine address at this location.';
                }
            });
        }

        function geocodeAddress(geocoder, resultsMap, resultsMarker, index) {
            var address = addressInput.value;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    resultsMarker.setPosition(results[0].geometry.location);
                    updateLatLngInputs(results[0].geometry.location.lat(), results[0].geometry.location.lng(), <?= $index ?>);
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    }
    <?php endforeach; ?>

    // Load Google Maps API
    function loadGoogleMapsAPI() {
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&libraries=places&callback=initMap';
        script.defer = true;
        script.async = true;
        document.head.appendChild(script);
    }

    loadGoogleMapsAPI();
    </script>
<?= $this->endSection() ?>
