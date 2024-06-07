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
                                <h5 class="mb-0">KPI Direktorat</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="kpi_direktoratTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama</th>
										<th>Tahun</th>
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
                                    <input type="hidden" name="id_kpi_direktorat" id="id_kpi_direktorat">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nm_kpi_direktorat" id="nm_kpi_direktorat">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <select class="form-control select2" name="tahun" id="tahun" style="width: 100%;">
                                            <?php foreach($combobox_tahun as $tahun): ?>
                                                <option value="<?= $tahun ?>" <?= $tahun==date("Y") ? "selected" : "" ?>><?= $tahun ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Active</label>
                                        <select name="active" id="active" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="2">Not Active</option>
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
    var kpi_direktoratTable = $('#kpi_direktoratTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>kpi_direktorat/ax_data_kpi_direktorat",
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
                    data: "id_kpi_direktorat",
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
                {data: "id_kpi_direktorat"},
                {data: "nm_kpi_direktorat"},
                {data: "tahun"},
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

    function ViewData(id_kpi_direktorat){
        if (id_kpi_direktorat == 0) {
            $('#id_kpi_direktorat').val(0);
            $('#nm_kpi_direktorat').val('');
            // $('#tahun').val(0);
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add KPI Direktorat');
        }else{
            var url = "<?= base_url() ?>kpi_direktorat/ax_data_kpi_direktorat_by_id";
            var data = {
            id_kpi_direktorat : id_kpi_direktorat,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kpi_direktorat').val(data['id_kpi_direktorat']);
                $('#nm_kpi_direktorat').val(data['nm_kpi_direktorat']);
                $('#tahun').val(data['tahun']).trigger('change');
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit KPI Direktorat');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        if ($('#nm_kpi_direktorat').val() == "" || $('#nm_kpi_direktorat').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Nama wajib diisi.",
                icon: "error"
            });
        }else if ($('#tahun').val() == "" || $('#tahun').val() == 0) {
            Swal.fire({
                title: "Failed!",
                text: "Bobobt level 2 wajib diisi.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>kpi_direktorat/ax_save_data";
            var data = {
               id_kpi_direktorat: $('#id_kpi_direktorat').val(),
               nm_kpi_direktorat: $('#nm_kpi_direktorat').val(),
               tahun: $('#tahun').val(),
               active: $('#active').val(),
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                console.log(data);
                $('#addModal').modal('hide');
                kpi_direktoratTable.ajax.reload();
            });
        }


    });

    function DeleteData(id_kpi_direktorat){
        var url = "<?= base_url() ?>kpi_direktorat/ax_delete_data";
        var data = {
           id_kpi_direktorat: id_kpi_direktorat
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            kpi_direktoratTable.ajax.reload();
        });
    }
</script>

<?= $this->endSection() ?>
