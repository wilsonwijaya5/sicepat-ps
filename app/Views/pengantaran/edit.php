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
            <select class="form-control" id="region" name="region" required>
                <option value="Payung Sekaki" <?= $pengantaran['region'] == 'Payung Sekaki' ? 'selected' : '' ?>>Payung Sekaki</option>
                <option value="Rumbai" <?= $pengantaran['region'] == 'Rumbai' ? 'selected' : '' ?>>Rumbai</option>
                <option value="Sukajadi" <?= $pengantaran['region'] == 'Sukajadi' ? 'selected' : '' ?>>Sukajadi</option>
                <option value="Senapelan" <?= $pengantaran['region'] == 'Senapelan' ? 'selected' : '' ?>>Senapelan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nama_kurir">Nama Kurir</label>
            <select class="form-control" id="nama_kurir" name="kurir_id" required>
                <!-- Options will be populated dynamically -->
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_paket">Jumlah Paket</label>
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" value="<?= count($detailPengantaran) ?>" required readonly>
        </div>
        <div id="detail-pengantaran">
            <?php foreach($detailPengantaran as $index => $detail): ?>
                <div class="form-group">
                    <h4>Detail Pengantaran Paket <?= $index + 1 ?></h4>  
                    <input type="hidden" name="detail_pengantaran[<?= $index ?>][id]" value="<?= $detail['id'] ?>">
                    
                    <label for="no_resi<?= $index ?>">Nomor Resi</label>
                    <input type="text" class="form-control" id="no_resi<?= $index ?>" name="detail_pengantaran[<?= $index ?>][no_resi]" value="<?= $detail['no_resi'] ?>" required>

                    <label for="tanggal_pengantaran<?= $index ?>">Tanggal Pengantaran</label>
                    <input type="date" class="form-control" id="tanggal_pengantaran<?= $index ?>" name="detail_pengantaran[<?= $index ?>][tanggal_pengantaran]" value="<?= $detail['tanggal_pengantaran'] ?>" required>

                    <label for="nama_penerima<?= $index ?>">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penerima<?= $index ?>" name="detail_pengantaran[<?= $index ?>][nama_penerima]" value="<?= $detail['nama_penerima'] ?>" required>

                    <label for="nohp<?= $index ?>">Nomor HP Penerima</label>
                    <input type="text" class="form-control" id="nohp<?= $index ?>" name="detail_pengantaran[<?= $index ?>][nohp]" value="<?= $detail['nohp'] ?>" required>

                    <label for="alamat_penerima<?= $index ?>">Alamat Penerima</label>
                    <input type="text" class="form-control" id="alamat_penerima<?= $index ?>" name="detail_pengantaran[<?= $index ?>][alamat_penerima]" value="<?= $detail['alamat_penerima'] ?>" required>

                    <label for="status<?= $index ?>">Status</label>
                    <input type="text" class="form-control" id="status<?= $index ?>" name="detail_pengantaran[<?= $index ?>][status]" value="<?= $detail['status'] ?>" readonly>

                    <input type="hidden" id="latitude<?= $index ?>" name="detail_pengantaran[<?= $index ?>][latitude]" value="<?= $detail['latitude'] ?>">
                    <input type="hidden" id="longitude<?= $index ?>" name="detail_pengantaran[<?= $index ?>][longitude]" value="<?= $detail['longitude'] ?>">

                    <label for="map<?= $index ?>">Pilih Lokasi pada Peta</label>
                    <div id="map<?= $index ?>" style="height: 300px;"></div>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateKurirOptions(region) {
                $.ajax({
                    url: '/pengantaran/getKurirsByRegion/' + region,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var kurirSelect = $('#nama_kurir');
                        kurirSelect.empty(); // Clear existing options
                        $.each(data, function(index, kurir) {
                            kurirSelect.append(new Option(kurir.nama_lengkap, kurir.id));
                        });
                        // Set the current kurir as selected
                        kurirSelect.val(<?= $pengantaran['kurir_id'] ?>);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching kurirs:", error);
                    }
                });
            }

            $('#region').change(function() {
                var selectedRegion = $(this).val();
                updateKurirOptions(selectedRegion);
            });

            // Initialize kurir options based on current region
            updateKurirOptions($('#region').val());
        });

        function initMap() {
            <?php foreach($detailPengantaran as $index => $detail): ?>
                initializeMap<?= $index ?>();
            <?php endforeach; ?>
        }

        <?php foreach($detailPengantaran as $index => $detail): ?>
        function initializeMap<?= $index ?>() {
            var latitude = parseFloat(document.getElementById('latitude<?= $index ?>').value) || -6.2088;
            var longitude = parseFloat(document.getElementById('longitude<?= $index ?>').value) || 106.8456;
            var location = { lat: latitude, lng: longitude };

            var map = new google.maps.Map(document.getElementById('map<?= $index ?>'), {
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
        }
        <?php endforeach; ?>

        function updateLatLngInputs(lat, lng, index) {
            document.getElementById('latitude' + index).value = lat;
            document.getElementById('longitude' + index).value = lng;
        }

        function geocodePosition(pos, index) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: pos
            }, function(responses, status) {
                if (status === 'OK' && responses && responses.length > 0) {
                    document.getElementById('alamat_penerima' + index).value = responses[0].formatted_address;
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                    document.getElementById('alamat_penerima' + index).value = 'Cannot determine address at this location.';
                }
            });
        }

        function geocodeAddress(geocoder, resultsMap, resultsMarker, index) {
            var address = document.getElementById('alamat_penerima' + index).value;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    resultsMarker.setPosition(results[0].geometry.location);
                    updateLatLngInputs(results[0].geometry.location.lat(), results[0].geometry.location.lng(), index);
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&libraries=places&callback=initMap">
    </script>
<?= $this->endSection() ?>
