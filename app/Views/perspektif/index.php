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
                                <h5 class="mb-0">Perpsektif</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="perspektifTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama</th>
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
                                    <input type="hidden" name="id_perspektif" id="id_perspektif">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nm_perspektif" id="nm_perspektif">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bobot</label>
                                        <input class="form-control" type="number" name="bobot" id="bobot" min="0" max="100">
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
    var perspektifTable = $('#perspektifTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>perspektif/ax_data_perspektif",
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
                    data: "id_perspektif",
                    render: function(data, type, full, meta){
                        var str = '';
                        str += '<div class="dropdown">'
						str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
						str += '<ul class="dropdown-menu" style="">'
						str += '<li><a class="dropdown-item" href="<?= base_url() ?>perspektif/details/'+data+'"><i class="bx bx-detail"></i> Detail</a></li>'
						str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
						str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
						str += '</ul>'
						str += '</div>'

                        return str;
                    } 
                },
                {data: "id_perspektif"},
                {data: "nm_perspektif"},
                {data: "bobot"},
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

    function ViewData(id_perspektif){
        if (id_perspektif == 0) {
            $('#id_perspektif').val(0);
            $('#nm_perspektif').val('');
            $('#bobot').val(0);
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Perspektif');
        }else{
            var url = "<?= base_url() ?>perspektif/ax_data_perspektif_by_id";
            var data = {
            id_perspektif : id_perspektif,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_perspektif').val(data['id_perspektif']);
                $('#nm_perspektif').val(data['nm_perspektif']);
                $('#bobot').val(data['bobot']);
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Perspektif');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        if ($('#nm_perspektif').val() == "" || $('#nm_perspektif').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Nama wajib diisi.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>perspektif/ax_save_data";
            var data = {
               id_perspektif: $('#id_perspektif').val(),
               nm_perspektif: $('#nm_perspektif').val(),
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
                perspektifTable.ajax.reload();
            });
        }


    });

    function DeleteData(id_perspektif){
        var url = "<?= base_url() ?>perspektif/ax_delete_data";
        var data = {
           id_perspektif: id_perspektif
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            perspektifTable.ajax.reload();
        });
    }
</script>

<?= $this->endSection() ?>
