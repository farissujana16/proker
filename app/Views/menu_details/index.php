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
                                <h5 class="mb-0">Menu Details</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="menu_detailsTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Menu Details</th>
										<th>Kode Menu Details</th>
										<th>URL</th>
										<th>Menu Groups</th>
										<th>Position</th>
										<th>Active</th>
									</tr>
								</thead>
								<tbody></tbody>
								
							</table>
						</div>
                    </div>
                    <div class="modal fade" id="addModal" tabindex="-1"  aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_menu_details" id="id_menu_details">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Menu Details</label>
                                        <input class="form-control" type="text" name="nm_menu_details" id="nm_menu_details">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kode Menu Details</label>
                                        <input class="form-control" type="text" name="kd_menu_details" id="kd_menu_details">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">URL</label>
                                        <input class="form-control" type="text" name="url" id="url">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Menu Groups</label>
                                        <select class="form-select select2" name="id_menu_groups" id="id_menu_groups">
                                            <option value="0">--Menu Groups--</option>
                                            <?php foreach($combobox_menu_groups as $menu_groups): ?>
                                                <option value="<?= $menu_groups['id_menu_groups'] ?>"><?= $menu_groups['nm_menu_groups'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Position</label>
                                        <input class="form-control" type="text" name="position" id="position">
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
    var menu_detailsTable = $('#menu_detailsTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>menu_details/ax_data_menu_details",
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
                    data: "id_menu_details",
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
                {data: "id_menu_details"},
                {data: "nm_menu_details"},
                {data: "kd_menu_details"},
                {data: "url"},
                {data: "nm_menu_groups"},
                {data: "position"},
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

    function ViewData(id_menu_details){
        if (id_menu_details == 0) {
            $('#id_menu_details').val(0);
            $('#nm_menu_details').val('');
            $('#kd_menu_details').val('');
            $('#url').val('');
            $('#position').val('');
            $('#id_menu_groups').val(0).trigger('change');
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Menu Details');
        }else{
            var url = "<?= base_url() ?>menu_details/ax_data_menu_details_by_id";
            var data = {
            id_menu_details : id_menu_details,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_menu_details').val(data['id_menu_details']);
                $('#nm_menu_details').val(data['nm_menu_details']);
                $('#kd_menu_details').val(data['kd_menu_details']);
                $('#url').val(data['url']);
                $('#position').val(data['position']);
                $('#id_menu_groups').val(data['id_menu_groups']).trigger('change');
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Menu Details');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        var url = "<?= base_url() ?>menu_details/ax_save_data";
        var data = {
           id_menu_details: $('#id_menu_details').val(),
           nm_menu_details: $('#nm_menu_details').val(),
           kd_menu_details: $('#kd_menu_details').val(),
           url: $('#url').val(),
           position: $('#position').val(),
           id_menu_groups: $('#id_menu_groups').val(),
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
            menu_detailsTable.ajax.reload();
        });
    });

    function DeleteData(id_menu_details){
        var url = "<?= base_url() ?>menu_details/ax_delete_data";
        var data = {
           id_menu_details: id_menu_details
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            menu_detailsTable.ajax.reload();
        });
    }
</script>

<?= $this->endSection() ?>
