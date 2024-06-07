<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                             <label for="tahun">Tahun</label>
                             <select name="tahun" id="tahun" class="form-control select2" style="width: 100%;">
                                 <?php foreach($tahun as $thn): ?>
                                    <option value="<?= $thn ?>" <?= $thn==date('Y')? "selected" : "" ?>><?= $thn ?></option>
                                 <?php endforeach ?>
                             </select>
                        </div>
                       <div class="col-md-4">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control select2" style="width: 100%;">
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
                       <div class="col-md-4">
                            <label for="id_user">Pegawai</label>
                            <select name="id_user" id="id_user" class="form-control select2" style="width: 100%;">
                                    <option value="0">--Pegawai--</option>
                                    <?php if(session()->get('level')): ?>
                                        <?php foreach($combobox_pegawai as $pegawai): ?>
                                            <option value="<?= $pegawai['id_user'] ?>" data-divisi="<?= $pegawai['id_divisi'] ?>" data-sub="<?= $pegawai['id_divisi_sub'] ?>"><?= $pegawai['nm_pegawai'] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                            </select>
                       </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">AKHLAK</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewParameter()" class="btn btn-warning"><i class="bx bx-error-circle mr-1"></i>Lihat Parameter</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
							<table id="evaluasi_akhlakTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<!-- <th width='5%'>Action</th> -->
										<th>Akhlak</th>
                                        <th width="70%">Parameter</th>
										<th width="20%">Nilai</th>
										<th></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <img style="width: 100%;" src="<?= base_url() ?>/assets/images/parameter.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    // CKEDITOR
    // $(function(){
    //     CKEDITOR.replace('deskripsi');
    // })


    var groupColumn = 0;
    var evaluasi_akhlakTable = $('#evaluasi_akhlakTable').DataTable({
            "columnDefs": [{
					visible: false,
					targets: groupColumn
				}],
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [500],
            oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>evaluasi_akhlak/ax_data_evaluasi_akhlak",
                type: 'POST',
                data: function(d) {
                    return $.extend({}, d, {
                        "bulan": $('#bulan').val(),
                        "tahun": $('#tahun').val(),
                        "id_user" : $('#id_user').val()

                    });
                }
            },
            columns: [
                // {
                //     data: "id_evaluasi_akhlak",
                //     render: function(data, type, full, meta){
                //         var str = '';
                //         if (full.jenis_kpi == 2) {
                //             str += '<div class="dropdown">'
                //             str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                //             str += '<ul class="dropdown-menu" style="">'
                //             // str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                //             str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
                //             str += '</ul>'
                //             str += '</div>'
                //         }

                //         return str;
                //     } 
                // },
                {data: "nm_akhlak"},
                {data: "nm_akhlak_detail"},
                {
                    data: 'nilai',
                    render: function(data, type, full, meta){
                        var str = "";
                        if (data == undefined) {
                            // str = '<input class="form-control form-control-sm" type="text" name="akhlak_'+full.id_akhlak+'" id="akhlak_'+full.id_akhlak+'">'
                            str += '<select class="form-control form-control-sm select2" style="width: 100%;" name="akhlak_'+full.id_akhlak+'" id="akhlak_'+full.id_akhlak+'">'
                            str += '<option value="0">--Nilai--</option>'
                            str += '<option value="1">Tidak Pernah</option>'
                            str += '<option value="2">Jarang</option>'
                            str += '<option value="3">Kadang-kadang</option>'
                            str += '<option value="4">Sering</option>'
                            str += '<option value="5">Selalu</option>'
                            str += '</select>'
                        }else{
                            str = data
                        }
                        return str;
                    }
                },
                {
                    data: 'id_evaluasi_akhlak',
                    render: function(data, type, full, meta){
                        var str = "";
                        var nm_akhlak = "'"+full.nm_akhlak+"'";
                        if (data == 0) {
                            if ($('#id_user').val() == 0) {
                                str = "";
                            }else{
                                str = '<button onclick="saveNilai('+data+', '+full.id_akhlak+','+full.id_akhlak_detail+')" class="btn btn-sm btn-primary"><i class="bx bx-save me-0"></i></button>'
                            }
                        }else{
                            if ($('#id_user').val() == 0) {
                                str = "";
                            }else{
                                str = '<button onclick="DeleteData('+data+')" class="btn btn-sm btn-danger"><i class="bx bx-trash me-0"></i></button>'
                            }
                        }

                        // str += '<button onclick="seeDetail('+full.id_akhlak+','+nm_akhlak+')" class="btn btn-sm btn-info ms-2"><i class="bx bx-search me-0"></i></button>'
                        return str;
                    }
                },
            ],
            columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 1
                }
            ],
            drawCallback: function(settings) {
				var api = this.api();
				var rows = api.rows({
					page: 'current'
				}).nodes();
				var last = null;

				api.column(groupColumn, {
						page: 'current'
					})
					.data()
					.each(function(group, i) {
						if (last !== group) {
							$(rows)
								.eq(i)
								.before('<tr class="group"><td colspan="4" style="background: #a8dede;"><b>' + group + '</b></td></tr>');

							last = group;
						}
					});
			}
    });

    function ViewParameter(){
        $('#addModal').modal('show');
        $('#addModalLabel').html('Parameter Penilaian');
    }

    $('#btn_save').on('click', function (){
        if ($('#id_bu').val() == 0 || $('#id_bu').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Cabang wajib dipilih.",
                icon: "error"
            });
        }
        else if ($('#id_divisi').val() == 0 || $('#id_divisi').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Divisi wajib dipilih.",
                icon: "error"
            });
        }else if ($('#id_divisi_sub').val() == 0 || $('#id_divisi_sub').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Divisi wajib dipilih.",
                icon: "error"
            });
        }else if ($('#tahun').val() == 0 || $('#tahun').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Tahun wajib dipilih.",
                icon: "error"
            });
        }else{
            var url = "<?= base_url() ?>evaluasi_akhlak/ax_save_data";
            var data = {
               id_evaluasi_akhlak: $('#id_evaluasi_akhlak').val(),
               kpi_wajib: $('#kpi_wajib').val(),
               kpi_custom: $('#kpi_custom').val(),
               id_bu: $('#id_bu').val(),
               id_divisi: $('#id_divisi').val(),
               id_divisi_sub: $('#id_divisi_sub').val(),
               tahun: $('#tahun').val(),
               deskripsi: $('#deskripsi').val(),
               active: $('#active').val(),
            };
    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#addModal').modal('hide');
                evaluasi_akhlakTable.ajax.reload();
            });
        }
    });

    function DeleteData(id_evaluasi_akhlak){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                
                var url = "<?= base_url() ?>evaluasi_akhlak/ax_delete_data";
                var data = {
                id_evaluasi_akhlak: id_evaluasi_akhlak
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Nilai sudah terhapus.",
                        icon: "success"
                    });
                    evaluasi_akhlakTable.ajax.reload();
                });
            }
        });
    }

    function saveNilai(id_evaluasi_akhlak, id_akhlak, id_akhlak_detail){
        const d = new Date();
        var month = (d.getMonth() + 1);

        

        if (month % 3 == 0 && month == $('#bulan').val()) {
            if ($('#akhlak_'+id_akhlak).val() == 0) {
                Swal.fire({
                    title: "Warning!",
                    text: "Harap Isi nilai terlebih dahulu.",
                    icon: "warning"
                });
            }else{
                var url = "<?= base_url() ?>evaluasi_akhlak/ax_save_data";
                var data = {
                    id_evaluasi_akhlak: id_evaluasi_akhlak,
                    id_akhlak: id_akhlak,
                    id_akhlak_detail: id_akhlak_detail,
                    nilai: $('#akhlak_'+id_akhlak).val(),
                    id_user: $('#id_user').val(),
                    id_divisi : $('#id_user').find(":selected").data('divisi'),
                    id_divisi_sub : $('#id_user').find(":selected").data('sub'),
                    bulan: $('#bulan').val(),
                    tahun: $('#tahun').val(),
                };
        
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    Swal.fire({
                        title: "Saved!",
                        text: "Nilai tersimpan.",
                        icon: "success"
                    });
                    evaluasi_akhlakTable.ajax.reload();
                });
            }
        }else{
            Swal.fire({
                    title: "Warning!",
                    text: "Belum memasuki waktu input nilai.",
                    icon: "warning"
                });
        }
    }



    //DETAIL AKHLAK
    // function seeDetail(id_akhlak, nm_akhlak){

    //     var url = "<?= base_url() ?>evaluasi_akhlak/ax_get_detail";
    //     var data = {
    //         id_akhlak: id_akhlak,
    //     };


    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         data: data
    //     }).done(function(data, textStatus, jqXHR) {
    //         var data = JSON.parse(data);
    //         var str = '<li style="font-size: 14pt;" class="list-group-item active" aria-current="true">'+nm_akhlak+'</li>';
    //         $.each(data, function(index, value){
    //             str += '<li class="list-group-item">'+value['nm_akhlak_detail']+'</li>'
    //         })
    //         $('#list_akhlak').html(str);
    //         $('#addModal').modal('show');
    //     });
    // }




    //ONCHANGE FILTER
    $('#bulan').on('change', function(){
        evaluasi_akhlakTable.ajax.reload();
    });

    $('#tahun').on('change', function(){
        evaluasi_akhlakTable.ajax.reload();
    });

    $('#id_user').on('change', function(){
        evaluasi_akhlakTable.ajax.reload();
    });

    

</script>

<?= $this->endSection() ?>
