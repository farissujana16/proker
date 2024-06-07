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
                                <h5 class="mb-0">Bussiness Unit</h5>
                            </div>
                            <!-- <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div> -->
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="buTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama Bussiness Unit</th>
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
                                    <input type="hidden" name="id_bu" id="id_bu">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Bussiness Unit</label>
                                        <input class="form-control" type="text" name="nm_bu" id="nm_bu">
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
    var buTable = $('#buTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>bu/ax_data_bu",
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
                    data: "id_bu",
                    render: function(data, type, full, meta){
                        var str = '';
                        str += '<div class="dropdown">'
						str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
						str += '<ul class="dropdown-menu" style="">'
						// str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
						// str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
						str += '<li><a class="dropdown-item" href="<?= base_url() ?>bu/access/'+data+'"><i class="bx bx-group"></i> Access</a></li>'
						str += '</ul>'
						str += '</div>'

                        return str;
                    } 
                },
                {data: "id_bu"},
                {data: "nm_bu"},
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

    function ViewData(id_bu){
        if (id_bu == 0) {
            $('#id_bu').val(0);
            $('#nm_bu').val('');
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Bussiness Unit');
        }else{
            var url = "<?= base_url() ?>bu/ax_data_bu_by_id";
            var data = {
            id_bu : id_bu,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_bu').val(data['id_bu']);
                $('#nm_bu').val(data['nm_bu']);
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Bussiness Unit');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        var url = "<?= base_url() ?>bu/ax_save_data";
        var data = {
           id_bu: $('#id_bu').val(),
           nm_bu: $('#nm_bu').val(),
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
            buTable.ajax.reload();
        });
    });

    function DeleteData(id_bu){
        var url = "<?= base_url() ?>bu/ax_delete_data";
        var data = {
           id_bu: id_bu
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            buTable.ajax.reload();
        });
    }
</script>

<?= $this->endSection() ?>
