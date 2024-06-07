<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-4 col-md-4 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">Tambah KPI</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <input type="text" name="id_kpi" id="id_kpi" value="0" hidden>
                            <div class="mb-2">
                                <label for="">KPI</label>
                                <input type="text" class="form-control" name="nm_kpi" id="nm_kpi">
                            </div>
                            <div class="mb-2">
                                <label for="">Perspektif</label>
                                <select class="form-control select2" name="id_perspektif" id="id_perspektif" style="width: 100%;">
                                    <option value="0">--Perspektif--</option>
                                    <?php foreach($combobox_perspektif as $perspektif):?>
                                        <option value="<?= $perspektif['id_perspektif'] ?>"><?= $perspektif['nm_perspektif'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">Sub Bobot</label>
                                    <input type="number" class="form-control" name="sub_bobot" id="sub_bobot" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Tahun</label>
                                <select class="form-control select2"  name="tahun" id="tahun" style="width: 100%;">
                                    <?php foreach($combobox_tahun as $tahun):?>
                                        <option value="<?= $tahun ?>" <?= $tahun==date('Y')?"selected":"" ?>><?= $tahun ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">Target</label>
                                    <input type="text" class="form-control" name="target" id="target">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="">Polaritas</label>
                                <select class="form-control select2" name="polaritas" id="polaritas" style="width: 100%;">
                                    <option value="0">--Polaritas--</option>
                                    <option value="1">Minimize</option>
                                    <option value="2">Maximize</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="">Divisi</label>
                                <select class="form-control select2" name="id_divisi" id="id_divisi" style="width: 100%;">
                                    <option value="0">--Divisi--</option>
                                    <?php foreach($combobox_divisi as $divisi):?>
                                        <option value="<?= $divisi['id_divisi'] ?>"><?= $divisi['nm_divisi'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="">Sub Divisi</label>
                                <select class="form-control select2" name="id_divisi_sub" id="id_divisi_sub" style="width: 100%;">
                        
                                </select>
                            </div>
                            <br>
                            <div class="mb-5">
                                <div class="float-end">
                                    <button class="btn btn-primary" id="btn_save">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 col-md-8 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">KPI</h5>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="kpiTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama KPI</th>
										<th>Tahun</th>
										<th>Cabang</th>
										<th>Divisi</th>
										<th>Sub Divisi</th>
										<th>Active</th>
									</tr>
								</thead>
								<tbody></tbody>
								
							</table>
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
    // CKEDITOR
    // $(function(){
    //     CKEDITOR.replace('deskripsi');
    // })


    var kpiTable = $('#kpiTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>kpi/ax_data_kpi/",
                type: 'POST',
                // data: function(d) {
                //     return $.extend({}, d, {
                //         "id_permohonan": 1,
                //         "bidang": $('#bidang').val(),
                //         "kategori" : $('#kategori').val()

                //     });
                // }
            },
            columns: [
                {
                    data: "id_kpi",
                    render: function(data, type, full, meta){
                        var str = '';
                        str += '<div class="dropdown">'
						str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
						str += '<ul class="dropdown-menu" style="">'
						str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
						str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
						str += '</ul>'
						str += '</div>'

                        return str;
                    } 
                },
                {data: "id_kpi"},
                {data: "nm_kpi"},
                {data: 'tahun'},
                {data: 'nm_bu'},
                {data: 'nm_divisi'},
                {
                    data: 'nm_divisi_sub',
                    render: function(data, type, full, meta){
                        var str;
                        if(data == undefined){
                            str = full.nm_divisi
                        }else{
                            str = data
                        }
                        return str;
                    }
                },
                {
                    data: "active",
                    render: function(data, type, full, meta){
                        var str;
                        if(data == 1){
                            str = '<span class="badge bg-success rounded-pill">Active</span>'
                        }else{
                            str = '<span class="badge bg-danger rounded-pill">Active</span>'
                        }
                        return str;
                    }
                },
            ]
    });

    function ViewData(id_kpi){
            var url = "<?= base_url() ?>kpi/ax_data_kpi_by_id";
            var data = {
            id_kpi : id_kpi,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kpi').val(data['id_kpi']);
                $('#nm_kpi').val(data['nm_kpi']);
                $('#id_perspektif').val(data['id_perspektif']).trigger('change');
                $('#tahun').val(data['tahun']).trigger('change');
                $('#polaritas').val(data['polaritas']);
                $('#id_divisi').val(data['id_divisi']).trigger('change');
                $('#sub_bobot').val(data['sub_bobot']);
                $('#satuan').val(data['satuan']);
                $('#target').val(data['target']);
                
            });
    }

    $('#btn_save').on('click', function (){
        if ($('#nm_kpi').val() == "" || $('#nm_kpi').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Nama KPI wajib diisi.",
                icon: "error"
            });
        }else if ($('#id_perspektif').val() == 0 || $('#id_perspektif').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Perspektif wajib dipilih.",
                icon: "error"
            });
        }else if ($('#sub_bobot').val() == 0 || $('#sub_bobot').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Bobot wajib diisi.",
                icon: "error"
            });
        }else if ($('#tahun').val() == 0 || $('#tahun').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Tahun wajib dipilih.",
                icon: "error"
            });
        }else if ($('#satuan').val() == 0 || $('#satuan').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Satuan wajib diisi.",
                icon: "error"
            });
        }else if ($('#target').val() == "" || $('#target').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Target wajib diisi.",
                icon: "error"
            });
        }else if ($('#polaritas').val() == 0 || $('#polaritas').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Polaritas wajib dipilih.",
                icon: "error"
            });
        }else if ($('#id_divisi').val() == 0 || $('#id_divisi').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Divisi wajib dipilih.",
                icon: "error"
            });
        }else if ($('#id_divisi_sub').val() == 0 || $('#id_divisi_sub').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Divisi wajib dipilih.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>kpi/ax_save_data";
            var data = {
               id_kpi : $('#id_kpi').val(),
               nm_kpi : $('#nm_kpi').val(),
               id_perspektif : $('#id_perspektif').val(),
               tahun : $('#tahun').val(),
               polaritas : $('#polaritas').val(),
               id_divisi : $('#id_divisi').val(),
               id_divisi_sub : $('#id_divisi_sub').val(),
               sub_bobot : $('#sub_bobot').val(),
               satuan : $('#satuan').val(),
               target : $('#target').val(),
               active : 1
            };

            // console.log(data);
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                // $('#addModal').modal('hide');
                kpiTable.ajax.reload();
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil disimpan.",
                    icon: "success"
                });

                $('#id_kpi').val(0);
                $('#nm_kpi').val("");
                $('#id_perspektif').val(0).trigger('change');
                $('#polaritas').val(0).trigger('change');
                $('#id_divisi').val(0).trigger('change');
                $('#id_divisi_sub').val("").trigger('change'),
                $('#sub_bobot').val("");
                $('#satuan').val("");
                $('#target').val("");
            });
        }
    });

    function DeleteData(id_kpi){
        var url = "<?= base_url() ?>kpi/ax_delete_data";
        var data = {
           id_kpi: id_kpi
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            kpiTable.ajax.reload();
        });
    }







    //ONCHANGE FILTER
    $('#id_divisi').on('change', function(){
        if ($('#id_divisi').val() == 0) {
            $('#id_divisi_sub').html('');
        }else{
            var url = "<?= base_url() ?>kpi/combobox_divisi_sub";
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
                var str = '';
                $.each(data, function(index, value){
                    str += '<option value="'+value['id_divisi_sub']+'">'+value['nm_divisi_sub']+'</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_divisi_sub').html(str);
                $('#id_divisi_sub').val(0).trigger('change');
            });
        }
    });
</script>

<?= $this->endSection() ?>
