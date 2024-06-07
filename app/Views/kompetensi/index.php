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
                                <h5 class="mb-0">Kompetensi</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="kompetensiTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama Kompetensi</th>
										<th>Bobot</th>
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
                                    <input type="hidden" name="id_kompetensi" id="id_kompetensi">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nm_kompetensi" id="nm_kompetensi">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bobot</label>
                                        <input class="form-control" type="text" name="bobot" id="bobot">
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
    var kompetensiTable = $('#kompetensiTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>kompetensi/ax_data_kompetensi",
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
                    data: "id_kompetensi",
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
                {data: "id_kompetensi"},
                {data: "nm_kompetensi"},
                {data: "bobot"},
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

    function ViewData(id_kompetensi){
        if (id_kompetensi == 0) {
            $('#id_kompetensi').val(0);
            $('#nm_kompetensi').val('');
            $('#bobot').val('0');
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Kompetensi');
        }else{
            var url = "<?= base_url() ?>kompetensi/ax_data_kompetensi_by_id";
            var data = {
            id_kompetensi : id_kompetensi,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kompetensi').val(data['id_kompetensi']);
                $('#nm_kompetensi').val(data['nm_kompetensi']);
                $('#bobot').val(data['bobot']);
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Kompetensi');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        if ($('#nm_kompetensi').val() == "" || $('#nm_kompetensi').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Nama Kompetensi wajib diisi.",
                icon: "error"
            });
        }else if($('#bobot').val() == "" || $('#bobot').val() == 0){
            Swal.fire({
                title: "Failed!",
                text: "Bobot wajib diisi.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>kompetensi/ax_save_data";
            var data = {
               id_kompetensi: $('#id_kompetensi').val(),
               nm_kompetensi: $('#nm_kompetensi').val(),
               bobot: $('#bobot').val(),
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
                kompetensiTable.ajax.reload();
            });
        }
    });

    function DeleteData(id_kompetensi){
        var url = "<?= base_url() ?>kompetensi/ax_delete_data";
        var data = {
           id_kompetensi: id_kompetensi
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            kompetensiTable.ajax.reload();
        });
    }
</script>

<?= $this->endSection() ?>
