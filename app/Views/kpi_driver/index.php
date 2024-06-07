<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12 col-md-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">KPI Driver</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="">Tahun</label>
                                        <select name="filter_tahun" id="filter_tahun" class="form-control select2" style="width: 100%;">
                                            <?php foreach($combobox_tahun as $tahun):?>
                                                <option value="<?= $tahun ?>" <?= $tahun == date("Y")? "selected" : "" ?>><?= $tahun ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="table-responsive">
							<table id="kpi_driverTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama</th>
										<th>Sub Bobot</th>
										<th>Target</th>
										<th>Target Bulanan</th>
										<th>Tahun</th>
										<th>Satuan</th>
										<th>Active</th>
									</tr>
								</thead>
								<tbody></tbody>
								
							</table>
						</div>
                    </div>
                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_kpi_driver" id="id_kpi_driver">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nm_kpi_driver" id="nm_kpi_driver">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sub Bobot</label>
                                        <input class="form-control" type="number" name="sub_bobot" id="sub_bobot" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Target</label>
                                        <input class="form-control" type="number" name="target" id="target" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Target Bulanan</label>
                                        <input class="form-control" type="number" name="target_bulanan" id="target_bulanan" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-control select2" style="width: 100%;" name="id_satuan" id="id_satuan">
                                            <option value="0">--Satuan--</option>
                                            <?php foreach($combobox_satuan as $satuan): ?>
                                                <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nm_satuan'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <select class="form-control select2" style="width: 100%;" name="tahun" id="tahun">
                                            <?php foreach($combobox_tahun as $tahun):?>
                                                <option value="<?= $tahun ?>" <?= $tahun == date("Y")? "selected" : "" ?>><?= $tahun ?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button id="btn_save" type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
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
    var kpi_driverTable = $('#kpi_driverTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>kpi_driver/ax_data_kpi_driver",
                type: 'POST',
                data: function(d) {
                    return $.extend({}, d, {
                        "tahun": $('#filter_tahun').val(),
                    });
                }
            },
            columns: [
                {
                    data: "id_kpi_driver",
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
                {data: "id_kpi_driver"},
                {data: "nm_kpi_driver"},
                {data: "sub_bobot"},
                {data: "target"},
                {data: "target_bulanan"},
                {data: "tahun"},
                {data: "nm_satuan"},
                {
                    data: "active",
                    render: function(data, type, full, meta){
                        var str;
                        if(data == 1){
                            str = '<span class="badge bg-success rounded-pill">Active</span>'
                        }else{
                            str = '<span class="badge bg-danger rounded-pill">Not Active</span>'
                        }
                        return str;
                    }
                },
            ]
    });

    function ViewData(id_kpi_driver){
        if (id_kpi_driver == 0) {
            $('#id_kpi_driver').val(0);
            $('#nm_kpi_driver').val('');
            $('#sub_bobot').val(0);
            $('#target').val(0);
            $('#target_bulanan').val(0);
            $('#satuan').val(0).trigger('change');
            $('#tahun').val(<?= date("Y") ?>).trigger('change');
            
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add KPI Driver');
        }else{
            var url = "<?= base_url() ?>kpi_driver/ax_data_kpi_driver_by_id";
            var data = {
            id_kpi_driver : id_kpi_driver,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kpi_driver').val(data['id_kpi_driver']);
                $('#nm_kpi_driver').val(data['nm_kpi_driver']);
                $('#sub_bobot').val(data['sub_bobot']);
                $('#target').val(data['target']);
                $('#target_bulanan').val(data['target_bulanan']);
                $('#id_satuan').val(data['id_satuan']).trigger('change');
                $('#tahun').val(data['tahun']).trigger('change');

                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit KPI Driver');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        if ($('#nm_kpi_driver').val() == "" || $('#nm_kpi_driver').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Nama wajib diisi.",
                icon: "error"
            });
        }else if($('#sub_bobot').val() == 0 || $('#sub_bobot').val() == null){
            Swal.fire({
                title: "Failed!",
                text: "Sub Bobot wajib diisi.",
                icon: "error"
            });
        }else if($('#target').val() == 0 || $('#target').val() == null){
            Swal.fire({
                title: "Failed!",
                text: "Target wajib diisi.",
                icon: "error"
            });
        }else if($('#target_bulanan').val() == 0 || $('#target_bulanan').val() == null){
            Swal.fire({
                title: "Failed!",
                text: "Target Bulanan wajib diisi.",
                icon: "error"
            });
        }else if($('#id_satuan').val() == 0 || $('#id_satuan').val() == null){
            Swal.fire({
                title: "Failed!",
                text: "Satuan wajib dipilih.",
                icon: "error"
            });
        }else if($('#tahun').val() == 0 || $('#tahun').val() == null){
            Swal.fire({
                title: "Failed!",
                text: "Tahun wajib diisi.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>kpi_driver/ax_save_data";
            var data = {
                id_kpi_driver : $('#id_kpi_driver').val(),
                nm_kpi_driver : $('#nm_kpi_driver').val(),
                sub_bobot : $('#sub_bobot').val(),
                target : $('#target').val(),
                target_bulanan : $('#target_bulanan').val(),
                id_satuan : $('#id_satuan').val(),
                tahun : $('#tahun').val(),
                active: 1,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                console.log(data);
                Swal.fire({
                    title: "Success!",
                    text: "Data Berhasil Disimpan.",
                    icon: "success"
                });
                $('#addModal').modal('hide');
                kpi_driverTable.ajax.reload();
            });
        }


    });

    function DeleteData(id_kpi_driver){
        var url = "<?= base_url() ?>kpi_driver/ax_delete_data";
        var data = {
           id_kpi_driver: id_kpi_driver
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            kpi_driverTable.ajax.reload();
        });
    }
    

    // FILTER
    $('#filter_tahun').on('change', function(){
        kpi_driverTable.ajax.reload();
    })
</script>

<?= $this->endSection() ?>
