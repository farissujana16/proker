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
                                <h5 class="mb-0">Perpsektif | <?= $perspektif['nm_perspektif'] ?></h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="table-responsive">
                            <table id="perspektifTableDetails" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width='5%'>Action</th>
                                        <th>#</th>
                                        <th>Divisi</th>
                                        <th>Sub Divisi</th>
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
                                    <input type="hidden" name="id_perspektif_details" id="id_perspektif_details">
                                    <div class="mb-3">
                                        <label class="form-label">Divisi</label>
                                        <select name="id_divisi" id="id_divisi" class="form-control select2" style="width: 100%;">
                                            <option value="0">--Divisi--</option>
                                            <?php foreach ($combobox_divisi as $divisi) : ?>
                                                <option value="<?= $divisi['id_divisi'] ?>"><?= $divisi['nm_divisi'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="id_divisi_sub_h" id="id_divisi_sub_h">
                                        <label class="form-label">Sub Divisi</label>
                                        <select name="id_divisi_sub" id="id_divisi_sub" class="form-control select2" style="width: 100%;">

                                        </select>
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
    var perspektifTableDetails = $('#perspektifTableDetails').DataTable({
        "ordering": false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        // oLanguage: {sProcessing: $('.loader').hide()},
        ajax: {
            url: "<?= base_url() ?>perspektif/ax_data_perspektif_details",
            type: 'POST',
            data: function(d) {
                return $.extend({}, d, {
                    "id_perspektif": <?= $perspektif['id_perspektif'] ?>
                });
            }
        },
        columns: [{
                data: "id_perspektif_details",
                render: function(data, type, full, meta) {
                    var str = '';
                    str += '<div class="dropdown">'
                    str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                    str += '<ul class="dropdown-menu" style="">'
                    str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                    str += '<li><a class="dropdown-item" onclick="DeleteData(' + data + ')"><i class="bx bx-trash"></i> Delete</a></li>'
                    str += '</ul>'
                    str += '</div>'

                    return str;
                }
            },
            {
                data: "id_perspektif_details"
            },
            {
                data: "nm_divisi"
            },
            {
                data: "nm_divisi_sub"
            },
            {
                data: "bobot"
            },
            {
                data: "active",
                render: function(data, type, full, meta) {
                    var str;
                    if (data == 1) {
                        str = '<span class="badge bg-success rounded-pill">Active</span>'
                    } else {
                        str = '<span class="badge bg-danger rounded-pill">Not Active</span>'
                    }
                    return str;
                }
            },
        ]
    });

    function ViewData(id_perspektif_details) {
        if (id_perspektif_details == 0) {
            $('#id_perspektif').val(<?= $perspektif['id_perspektif'] ?>);
            $('#id_perspektif_details').val(0);
            $('#id_divisi').val(0).trigger('change');
            $('#id_divisi_sub_h').val(0);
            $('#bobot').val();
            $('#active').val(1);
            $('#addModal').modal('show');
            $('#addModalLabel').html('Add Perspektif Details');
        } else {
            var url = "<?= base_url() ?>perspektif/ax_data_perspektif_by_id_details";
            var data = {
                id_perspektif_details: id_perspektif_details,
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_perspektif').val(<?= $perspektif['id_perspektif'] ?>);
                $('#id_perspektif_details').val(data['id_perspektif_details']);
                $('#id_divisi').val(data['id_divisi']).trigger('change');
                $('#id_divisi_sub_h').val(data['id_divisi_sub']);
                $('#bobot').val(data['bobot']);
                $('#active').val(data['active']);
                $('#addModal').modal('show');
                $('#addModalLabel').html('Edit Perspektif Details');
            });
        }
    }

    $('#btn_save').on('click', function() {
        if ($('#id_divisi').val() == 0 || $('#id_divisi').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Divisi wajib diisi.",
                icon: "error"
            });
        } else if ($('#id_divisi_sub').val() == 0 || $('#id_divisi_sub').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Divisi wajib diisi.",
                icon: "error"
            });
        } else if ($('#bobot').val() == "" || $('#bobot').val() == null) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Divisi wajib diisi.",
                icon: "error"
            });
        } else {
            var url = "<?= base_url() ?>perspektif/ax_save_data_details";
            var data = {
                id_perspektif: <?= $perspektif['id_perspektif'] ?>,
                id_perspektif_details: $('#id_perspektif_details').val(),
                id_divisi: $('#id_divisi').val(),
                id_divisi_sub: $('#id_divisi_sub').val(),
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
                perspektifTableDetails.ajax.reload();
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil disimpan.",
                    icon: "success"
                });
            });
        }


    });

    function DeleteData(id_perspektif) {
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
            perspektifTableDetails.ajax.reload();
        });
    }


    //ONCHANGE

    $('#id_divisi').on('change', function() {
        var url = "<?= base_url() ?>perspektif/combobox_divisi_sub";
        var data = {
            id_divisi: $(this).val()
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            var str = '<option value="0">--Sub Divisi--</option>';
            $.each(data, function(index, value) {
                str += '<option value="' + value['id_divisi_sub'] + '">' + value['nm_divisi_sub'] + '</option>';
            })
            $('#id_divisi_sub').html(str);
            $('#id_divisi_sub').val($('#id_divisi_sub_h').val()).trigger('change');
        });
    })
</script>

<?= $this->endSection() ?>