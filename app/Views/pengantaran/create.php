<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Tambah Data Pengantaran</h1>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/pengantaran/store" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="region">Region</label>
            <select class="form-control" id="region" name="region" required>
                <option value="Payung Sekaki">Payung Sekaki</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Senapelan">Senapelan</option>
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
            <input type="number" class="form-control" id="jumlah_paket" name="jumlah_paket" required>
        </div>
        <div id="detail-pengantaran">
            <!-- Dynamic fields will be inserted here -->
        </div>
        <button type="button" class="btn btn-primary" id="add-detail">Tambah Detail Pengantaran</button>
        <hr>
        <button type="submit" class="btn btn-primary">Simpan</button>
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

    // Initialize kurir options based on default selected region
    updateKurirOptions($('#region').val());

            $('#add-detail').click(function() {
                var jumlahPaket = $('#jumlah_paket').val();
                $('#detail-pengantaran').empty(); // Clear previous inputs

                for (var i = 0; i < jumlahPaket; i++) {
                    var detailHtml = `
                        <div class="form-group">
                            <h4>Detail Pengantaran Paket ${i+1}</h4>  
                            <label for="no_resi${i}">Nomor Resi</label>
                            <input type="text" class="form-control" id="no_resi${i}" name="no_resi[]" required>

                            <label for="tanggal_pengantaran${i}">Tanggal Pengantaran</label>
                            <input type="date" class="form-control" id="tanggal_pengantaran${i}" name="tanggal_pengantaran[]" required>

                            <label for="nama_penerima${i}">Nama Penerima</label>
                            <input type="text" class="form-control" id="nama_penerima${i}" name="nama_penerima[]" required>

                            <label for="nohp${i}">Nomor HP Penerima</label>
                            <input type="text" class="form-control" id="nohp${i}" name="nohp[]" required>

                            <label for="alamat_penerima${i}">Alamat Penerima</label>
                            <input type="text" class="form-control" id="alamat_penerima${i}" name="alamat_penerima[]" required>

                            <label for="status${i}">Status</label>
                            <input type="text" class="form-control" id="status${i}" name="status[]" value="pending" readonly>

                            <input type="hidden" id="latitude${i}" name="latitude[]">
                            <input type="hidden" id="longitude${i}" name="longitude[]">

                            <label for="map${i}">Pilih Lokasi pada Peta</label>
                            <div id="map${i}" style="height: 300px;"></div>
                            <hr>
                        </div>
                    `;
                    $('#detail-pengantaran').append(detailHtml);
                    initMap(`map${i}`, `latitude${i}`, `longitude${i}`, `alamat_penerima${i}`); 
                }
            });

            function initMap(mapId, latId, lngId, addressId) {
                var map;
                var marker;
                var geocoder;

                var defaultLocation = { lat: 0.4933, lng: 101.4409 }; // Default location Pekanbaru

                map = new google.maps.Map(document.getElementById(mapId), {
                    center: defaultLocation,
                    zoom: 15
                });

                marker = new google.maps.Marker({
                    position: defaultLocation,
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
        });
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-S0PiFJUQ12lQUmPfg1QWPKzWwLg-JdU&libraries=places&callback=initMap">
    </script>
<?= $this->endSection() ?>
