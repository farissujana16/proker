<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-8 col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h5>Laporan AKHLAK</h5>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tahun</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="tahun" id="tahun" style="width: 100%;">
                                    <?php foreach($combobox_tahun as $tahun): ?>
                                        <option value="<?= $tahun ?>" <?= $tahun==date("Y") ? "selected" : "" ?>><?= $tahun ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Bulan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="bulan" id="bulan" style="width: 100%;">
                                    <option value="1" <?= 1 == date('n')? "selected" : "" ?>>Januari</option>
                                    <option value="2" <?= 2 == date('n')? "selected" : "" ?>>Februari</option>
                                    <option value="3" <?= 3 == date('n')? "selected" : "" ?>>Maret</option>
                                    <option value="4" <?= 4 == date('n')? "selected" : "" ?>>April</option>
                                    <option value="5" <?= 5 == date('n')? "selected" : "" ?>>Mei</option>
                                    <option value="6" <?= 6 == date('n')? "selected" : "" ?>>Juni</option>
                                    <option value="7" <?= 7 == date('n')? "selected" : "" ?>>Juli</option>
                                    <option value="8" <?= 8 == date('n')? "selected" : "" ?>>Agustus</option>
                                    <option value="9" <?= 9 == date('n')? "selected" : "" ?>>September</option>
                                    <option value="10" <?= 10 == date('n')? "selected" : "" ?>>Oktober</option>
                                    <option value="11" <?= 11 == date('n')? "selected" : "" ?>>November</option>
                                    <option value="12" <?= 11 == date('n')? "selected" : "" ?>>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Unit Kerja</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="id_bu" id="id_bu" style="width: 100%;">
                                    <option value="0">--Unit Kerja--</option>
                                    <?php foreach($combobox_bu as $bu): ?>
                                        <option value="<?= $bu['id_bu'] ?>"><?= $bu['nm_bu'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Divisi</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="id_divisi" id="id_divisi" style="width: 100%;">
                                    <option value="0">--Divisi--</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sub Divisi</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="id_divisi_sub" id="id_divisi_sub" style="width: 100%;">
                                    <option value="0">--Sub Divisi--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">User</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="id_user" id="id_user" style="width: 100%;">
                                    <option value="0">--Pegawai--</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Jenis</label>
                            <div class="col-sm-9">
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="0">--Jenis--</option>
                                    <option value="1">Tahunan</option>
                                    <option value="1">Bulan</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <button id="cetak_akhlak" class="btn btn-primary">Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    $('.loader').hide();

    
    $('#id_bu').on('change', function(){
        if ($('#id_bu').val() == 0) {
            $('#id_divisi').html('<option value="0">--Divisi--</option>');
        }else{
            var url = "<?= base_url() ?>laporan_spkd/combobox_divisi";
            var data = {
               id_bu : $('#id_bu').val()
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--Divisi--</option>';
                $.each(data, function(index, value){
                    str += '<option value="'+value['id_divisi']+'">'+value['nm_divisi']+'</option>';
                });
                // $('#id_bu').prop('disabled', false)
                $('#id_divisi').html(str);
                $('#id_divisi').val(0).trigger('change');
            });
        }
    });

    $('#id_divisi').on('change', function(){
        if ($('#id_divisi').val() == 0) {
            $('#id_divisi_sub').html('<option value="0">--Sub Divisi--</option>');
        }else{
            var url = "<?= base_url() ?>laporan_spkd/combobox_divisi_sub";
            var data = {
               id_divisi : $('#id_divisi').val()
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--Sub Divisi--</option>';
                $.each(data, function(index, value){
                    str += '<option value="'+value['id_divisi_sub']+'">'+value['nm_divisi_sub']+'</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_divisi_sub').html(str);
                $('#id_divisi_sub').val(0).trigger('change');
            });
        }
    });


    $('#id_divisi_sub').on('change', function(){
        if ($('#id_divisi_sub').val() == 0) {
            $('#id_user').html('<option value="0">--Pegawai--</option>');
        }else{
            var url = "<?= base_url() ?>laporan_spkd/combobox_pegawai";
            var data = {
               id_divisi : $('#id_divisi').val(),
               id_divisi_sub : $('#id_divisi_sub').val()
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--Pegawai--</option>';
                $.each(data, function(index, value){
                    str += '<option value="'+value['id_user']+'">'+value['nik_pegawai']+' | '+value['nm_pegawai']+'</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_user').html(str);
                $('#id_user').val(0).trigger('change');
            });
        }
    });


    $('#cetak_akhlak').on('click', function(){
        const d = new Date();
        var month = (d.getMonth() + 1);

        if ($('#bulan').val() % 3 == 0) {
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var id_bu = $('#id_bu').val();
            var id_divisi = $('#id_divisi').val();
            var id_divisi_sub = $('#id_divisi_sub').val();
            var id_user = $('#id_user').val();
            // var jenis = $('#jenis').val();

            if(id_bu == 0){
                Swal.fire({
                    title: "Failed!",
                    text: "Silahkan Pilih Unit Kerja.",
                    icon: "error"
                });
                return;
            }else if (id_divisi == 0) {
                Swal.fire({
                    title: "Failed!",
                    text: "Silahkan Pilih Divisi.",
                    icon: "error"
                });
                return;
            }else if (id_divisi_sub == 0) {
                Swal.fire({
                    title: "Failed!",
                    text: "Silahkan Pilih Sub Divisi.",
                    icon: "error"
                });
                return;
            }else if (id_user == 0) {
                Swal.fire({
                    title: "Failed!",
                    text: "Silahkan Pilih Pegawai.",
                    icon: "error"
                });
                return;
            }
            // else if (jenis == 0) {
            //     Swal.fire({
            //         title: "Failed!",
            //         text: "Silahkan Pilih Jenis cetak.",
            //         icon: "error"
            //     });
            //     return;
            // }

            var url = "<?= base_url() ?>laporan_spkd/laporan_akhlak";

            window.open(url + "?id_bu=" + id_bu + "&id_divisi=" + id_divisi + "&id_divisi_sub=" + id_divisi_sub + "&id_user=" + id_user + "&bulan=" + bulan + "&tahun=" + tahun, '_blank');

            window.focus();
        }else{
            Swal.fire({
                    title: "Warning!",
                    text: "Tidak terdapat laporan pada bulan ini.",
                    icon: "warning"
                });
        }
        
    });
</script>

<?= $this->endSection() ?>
