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
                                <h5 class="mb-0">Level</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                
                                <!-- <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-printer"></i>Print</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" onclick="cetak(1)">PDF</a></li>
                                    <li><a class="dropdown-item" onclick="cetak(2)">Excel</a></li>
                                </ul> -->
                                
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                                <!-- <button type="button" onclick="tes()" class="btn btn-success"><i class="bx bx-plus mr-1"></i>Sweet Alert</button> -->
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="levelTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th width='5%'>Action</th>
										<th>#</th>
										<th>Nama Level</th>
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
                                    <input type="hidden" name="id_level" id="id_level">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Level</label>
                                        <input class="form-control" type="text" name="nm_level" id="nm_level">
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

    //CKEDITOR
    // $(function(){
    //     CKEDITOR.replace('area');
    // })
    
    var levelTable = $('#levelTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>level/ax_data_level",
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
                    data: "id_level",
                    render: function(data, type, full, meta){
                        var str = '';
                        str += '<div class="dropdown">'
						str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
						str += '<ul class="dropdown-menu" style="">'
						str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                        str += '<li><a class="dropdown-item" href="<?= base_url() ?>level/groups_access/'+data+'"><i class="bx bx-group"></i> Groups Access</a></li>'
						str += '<li><a class="dropdown-item" href="<?= base_url() ?>level/details_access/'+data+'"><i class="bx bx-user"></i> Details Access</a></li>'
						str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
						str += '</ul>'
						str += '</div>'

                        return str;
                    } 
                },
                {data: "id_level"},
                {data: "nm_level"},
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

    function ViewData(id_level){
        if (id_level == 0) {
            $('#id_level').val(0);
            $('#nm_level').val('');
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Level');
        }else{
            var url = "<?= base_url() ?>level/ax_data_level_by_id";
            var data = {
            id_level : id_level,
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_level').val(data['id_level']);
                $('#nm_level').val(data['nm_level']);
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Level');
                
            });
        }
    }

    $('#btn_save').on('click', function (){
        var url = "<?= base_url() ?>level/ax_save_data";
        var data = {
           id_level: $('#id_level').val(),
           nm_level: $('#nm_level').val(),
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
            levelTable.ajax.reload();
        });
    });

    function DeleteData(id_level){
        var url = "<?= base_url() ?>level/ax_delete_data";
        var data = {
           id_level: id_level
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            levelTable.ajax.reload();
        });
    }

    function tes(){
        //VALIDATION SWEET ALERT

        // Swal.fire({
        // title: "Are you sure?",
        // text: "You won't be able to revert this!",
        // icon: "warning",
        // showCancelButton: true,
        // confirmButtonColor: "#3085d6",
        // cancelButtonColor: "#d33",
        // confirmButtonText: "Yes, delete it!"
        // }).then((result) => {
        // if (result.isConfirmed) {
        //     Swal.fire({
        //     title: "Deleted!",
        //     text: "Your file has been deleted.",
        //     icon: "success"
        //     });
        // }
        // });

        //SUCCESS ALERT
        // Swal.fire({
        //     title: "Deleted!",
        //     text: "Your file has been deleted.",
        //     icon: "success"
        // });


        //LOADER
        // $('.loader').show();
    }


    function cetak(id){
        var url = "<?= base_url() ?>level/cetak";
        // var id_divre = $("#id_divre").val();
        // var id_bu = $("#id_bu").val();
        // var id_divisi = $("#id_divisi").val();
        // var tahun = $("#tahun").val();
        var jenis = id;
        if (id == 1) {
            window.open(url + "?jenis=" + id, '_blank');
        }else{
            window.open(url + "?jenis=" + id);
        }

        window.focus();
    }
</script>

<?= $this->endSection() ?>
