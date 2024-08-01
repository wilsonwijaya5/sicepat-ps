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
                    <label for="no_resi<?= $index ?>">Nomor Resi</label>
                    <input type="text" class="form-control" id="no_resi<?= $index ?>" name="no_resi[]" value="<?= $detail['no_resi'] ?>" required>

                    <label for="tanggal_pengantaran<?= $index ?>">Tanggal Pengantaran</label>
                    <input type="date" class="form-control" id="tanggal_pengantaran<?= $index ?>" name="tanggal_pengantaran[]" value="<?= $detail['tanggal_pengantaran'] ?>" required>

                    <label for="nama_penerima<?= $index ?>">Nama Penerima</label>
                    <input type="text" class="form-control" id="nama_penerima<?= $index ?>" name="nama_penerima[]" value="<?= $detail['nama_penerima'] ?>" required>

                    <label for="nohp<?= $index ?>">Nomor HP Penerima</label>
                    <input type="text" class="form-control" id="nohp<?= $index ?>" name="nohp[]" value="<?= $detail['nohp'] ?>" required>

                    <label for="alamat_penerima<?= $index ?>">Alamat Penerima</label>
                    <input type="text" class="form-control" id="alamat_penerima<?= $index ?>" name="alamat_penerima[]" value="<?= $detail['alamat_penerima'] ?>" required>

                    <label for="status<?= $index ?>">Status</label>
                    <input type="text" class="form-control" id="status<?= $index ?>" name="status[]" value="<?= $detail['status'] ?>" readonly>

                    <input type="hidden" id="latitude<?= $index ?>" name="latitude[]" value="<?= $detail['latitude'] ?>">
                    <input type="hidden" id="longitude<?= $index ?>" name="longitude[]" value="<?= $detail['longitude'] ?>">

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

            // Initialize maps for each detail pengantaran
            <?php foreach($detailPengantaran as $index => $detail): ?>
                initMap('map<?= $index ?>', 'latitude<?= $index ?>', 'longitude<?= $index ?>', 'alamat_penerima<?= $index ?>');
            <?php endforeach; ?>
        });

        function initMap(mapId, latId, lngId, addressId) {
            var map;
            var marker;
            var geocoder;

            var lat = parseFloat(document.getElementById(latId).value);
            var lng = parseFloat(document.getElementById(lngId).value);
            var location = { lat: lat, lng: lng };

            map = new google.maps.Map(document.getElementById(mapId), {
                center: location,
                zoom: 15
            });

            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById(latId).value = event.latLng.lat();
                document.getElementById(lngId).value = event.latLng.lng();
                updateAddress(latId, lngId, addressId, event.latLng);
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById(latId).value = event.latLng.lat();
                document.getElementById(lngId).value = event.latLng.lng();
                updateAddress(latId, lngId, addressId, event.latLng);
            });

            geocoder = new google.maps.Geocoder();

            // Add event listener for address input
            var addressInput = document.getElementById(addressId);
            addressInput.addEventListener('blur', function() {
                geocodeAddress(addressInput.value, map, marker, latId, lngId);
            });
        }

        function updateAddress(latId, lngId, addressId, latLng) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'location': latLng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById(latId).value = latLng.lat();
                        document.getElementById(lngId).value = latLng.lng();
                        document.getElementById(addressId).value = results[0].formatted_address;
                    } else {
                        window.alert('Alamat tidak ditemukan');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }

        function geocodeAddress(address, map, marker, latId, lngId) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    document.getElementById(latId).value = results[0].geometry.location.lat();
                    document.getElementById(lngId).value = results[0].geometry.location.lng();
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&libraries=places&callback=initMap">
    </script>
<?= $this->endSection() ?>
