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
                                <h5 class="mb-0">KPI</h5>
                            </div>
                            <div class="dropdown options ms-auto">
                                <?php if (count(session()->get('level')) > 0 && session()->get('id_level') != 21) : ?>
                                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-file-find mr-1"></i>Preview</button>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($jabatan as $level) : ?>
                                            <li><a class="dropdown-item" onclick="preview(<?= $level['id_divisi'] . ',' . $level['id_divisi_sub'] . ',' . $level['level'] ?>)"><?= $level['nm_organisasi'] ?></a></li>
                                        <?php endforeach ?>

                                    </ul>
                                <?php endif ?>
                                <!-- <button type="button" onclick="preview()" class="btn btn-dark"><i class="bx bx-file-find mr-1"></i>Preview</button> -->
                                <?php if (session()->get('level') != 0 || count(session()->get('level')) == 0) { ?>
                                    <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary"><i class="bx bx-plus"></i>Tambah</button> -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Tahun</label>
                                    <select class="form-control select2" style="width: 100%;" name="filter_tahun" id="filter_tahun">
                                        <option value="0">--Tahun--</option>
                                        <?php foreach ($combobox_tahun as $tahun) : ?>
                                            <option value="<?= $tahun ?>" <?= $tahun == date("Y") ? "selected" : "" ?>><?= $tahun ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <?php if (count(session()->get('level')) > 0) : ?>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Pegawai</label>
                                        <select class="form-control select2" style="width: 100%;" name="filter_pegawai" id="filter_pegawai">
                                            <option value="0">--Pegawai--</option>
                                            <?php foreach ($combobox_pegawai as $pegawai) : ?>
                                                <option value="<?= $pegawai['id_user'] ?>" data-bu="<?= $pegawai['id_bu'] ?>" data-divisi="<?= $pegawai['id_divisi'] ?>" data-sub="<?= $pegawai['id_divisi_sub'] ?>" data-level="<?= $pegawai['level'] ?>"><?= strtoupper($pegawai['nm_pegawai'])  ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="table-responsive">
                            <table id="kpiTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width='5%'>Action</th>
                                        <th><input type="checkbox" name="check_all" id="check_all" class="form-check-input"></th>
                                        <th>Status</th>
                                        <th>Perspektif</th>
                                        <th>Bobot</th>
                                        <th>Stategic Objective</th>
                                        <th>KPI</th>
                                        <th>Sub Bobot</th>
                                        <th>Satuan</th>
                                        <th>Jenis Perhitungan</th>
                                        <th>Target</th>
                                        <th>Polaritas</th>
                                        <th>Cabang</th>
                                        <th>Divisi</th>
                                        <th>Sub Divisi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th><button id="btn_approve" class="btn btn-primary btn-sm">Approve</button></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">KPI</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <input type="text" name="id_kpi" id="id_kpi" value="0" hidden>
                                        <div class="mb-2">
                                            <label for="">Tahun</label>
                                            <select class="form-control select2" name="tahun" id="tahun" style="width: 100%;">
                                                <option value="0">--Tahun--</option>
                                                <?php foreach ($combobox_tahun as $tahun) : ?>
                                                    <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="">Divisi</label>
                                            <select class="form-control select2" name="id_divisi" id="id_divisi" style="width: 100%;">
                                                <option value="0">--Divisi--</option>
                                                <?php foreach ($combobox_divisi as $divisi) : ?>
                                                    <option value="<?= $divisi['id_divisi'] ?>"><?= $divisi['nm_divisi'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <input type="hidden" name="id_divisi_sub_h" id="id_divisi_sub_h">
                                            <label for="">Sub Divisi</label>
                                            <select class="form-control select2" name="id_divisi_sub" id="id_divisi_sub" style="width: 100%;">

                                            </select>
                                        </div>
                                        <?php if (session()->get('id_bu') != 60 && count(array_keys(session()->get('level'), 2)) > 1) : ?>
                                            <div class="mb-2 filter_cabang">
                                                <label for="">Cabang</label>
                                                <select name="id_bu" id="id_bu" class="form-control select2" style="width: 100%">
                                                    <option value="0">--Cabang--</option>
                                                    <?php foreach ($combobox_bu as $bu) : ?>
                                                        <option value="<?= $bu['id_bu'] ?>"><?= $bu['nm_bu'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <?php if (count(session()->get('level')) != 0) : ?>
                                            <div class="mb-2">
                                                <input type="hidden" name="id_inisiatif_h" id="id_inisiatif_h">
                                                <label for="">Inisiatif Strategis</label>
                                                <select class="form-control select2" name="id_inisiatif" id="id_inisiatif" style="width: 100%;">
                                                    <option value="0">--Inisiatif Strategis--</option>
                                                </select>
                                            </div>
                                        <?php endif ?>

                                        <?php if (in_array(2, session()->get('level')) || in_array(3, session()->get('level')) || in_array(4, session()->get('level')) || session()->get('level') == null) : ?>
                                            <div class="mb-2 kpi_atasan">
                                                <label for="">KPI Atasan</label>
                                                <select class="form-control select2" style="width: 100%;" name="id_kpi_atasan" id="id_kpi_atasan">

                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <div class="mb-2">
                                            <label for="">KPI</label>
                                            <input type="text" class="form-control" name="nm_kpi" id="nm_kpi">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="">Sub Bobot</label>
                                                <input type="number" class="form-control" name="sub_bobot" id="sub_bobot" min="0" max="100">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="">Satuan</label>
                                                <select class="form-control select2" style="width: 100%;" name="id_satuan" id="id_satuan">
                                                    <option value="0">--Satuan--</option>
                                                    <?php foreach ($combobox_satuan as $satuan) : ?>
                                                        <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nm_satuan'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="">Target</label>
                                                <input type="text" class="form-control" name="target" id="target">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <label for="">Jenis Perhitungan</label>
                                            <select class="form-control select2" name="jenis_perhitungan" id="jenis_perhitungan" style="width: 100%;">
                                                <option value="0">--Jenis Perhitungan--</option>
                                                <option value="1">Akumulasi</option>
                                                <option value="2">Rata-rata</option>
                                                <option value="3">Progress</option>
                                            </select>
                                        </div>
                                        <?php if (count(session()->get('level')) != 0) : ?>
                                            <div class="mb-2">
                                                <label for="">Polaritas</label>
                                                <select class="form-control select2" name="polaritas" id="polaritas" style="width: 100%;">
                                                    <option value="0">--Polaritas--</option>
                                                    <option value="1">Minimize</option>
                                                    <option value="2">Maximize</option>
                                                    <option value="3">Presize</option>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button id="btn_save" type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- MODAL TARGET KPI BULANAN -->

                    <div class="modal fade" id="bulananModal" tabindex="-1" aria-labelledby="bulananModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bulananModalLabel">Target Bulanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <div class="mb-5">
                                            <div class="float-end">
                                                <button type="button" onclick="ViewDataBulanan(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_kpi_hidden" id="id_kpi_hidden">
                                        <input type="hidden" name="target_tahun_hidden" id="target_tahun_hidden">
                                        <table id="kpiBulananTable" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width='5%'>Action</th>
                                                    <th>#</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Bulan</th>
                                                    <th>Tahun</th>
                                                    <th>Target</th>
                                                    <th>Sub Bobot Bulanan</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- <button id="btn_save" type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL ADD TARGET BULANAN -->

                    <div class="modal fade" id="addbulanModal" tabindex="-1" aria-labelledby="addbulanModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addbulanModalLabel">Target Bulanan</h5>
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_kpi_bulanan" id="id_kpi_bulanan">
                                    <div class="mb-3">
                                        <label for="">Tahun</label>
                                        <select name="thn" id="thn" class="form-control select2" style="width: 100%;">
                                            <?php foreach ($combobox_tahun as $tahun) : ?>
                                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bulan">Bulan</label>
                                        <select name="bln" id="bln" class="form-control select2" style="width: 100%;">
                                            <option value="0">--Bulan--</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Target</label>
                                        <input class="form-control" type="text" name="target_bulanan" id="target_bulanan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Sub Bobot Bulanan</label>
                                        <input class="form-control" type="text" name="sub_bobot_bulanan" id="sub_bobot_bulanan">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button id="close_modal" type="button" class="btn btn-secondary">Close</button>
                                    <button id="btn_save_bulanan" type="button" class="btn btn-primary">Save changes</button>
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
    // CKEDITOR
    // $(function(){
    //     CKEDITOR.replace('deskripsi');
    // })

    $("#target").maskMoney({
        thousands: '.',
        decimal: ',',
        affixesStay: false,
        precision: 2,
        allowZero: true,
        defaultZero: true
    });
    $("#target_bulanan").maskMoney({
        thousands: '.',
        decimal: ',',
        affixesStay: false,
        precision: 2,
        allowNegative: true
    });


    var kpiTable = $('#kpiTable').DataTable({
        "ordering": false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        oLanguage: {
            sProcessing: $('.loader').hide()
        },
        ajax: {
            url: "<?= base_url() ?>kpi/ax_data_kpi",
            type: 'POST',
            data: function(d) {
                return $.extend({}, d, {
                    "filter_tahun": $('#filter_tahun').val(),
                    "filter_pegawai": $('#filter_pegawai').val(),
                    "id_bu": $('#filter_pegawai').find(':selected').data('bu'),
                    "id_divisi": $('#filter_pegawai').find(':selected').data('divisi'),
                    "id_divisi_sub": $('#filter_pegawai').find(':selected').data('sub'),
                    "level": $('#filter_pegawai').find(':selected').data('level')
                });
            }
        },
        columns: [{
                data: "id_kpi",
                render: function(data, type, full, meta) {
                    var str = '';
                    var nm_kpi = "'" + full.nm_kpi + "'"
                    // if (full.jenis_kpi == 2) {
                    str += '<div class="dropdown">'
                    str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                    str += '<ul class="dropdown-menu" style="">'
                    if (<?= session()->get('id_level') ?> != 21) {
                        str += '<li><a class="dropdown-item" onclick="TargetBulan(' + data + ',' + nm_kpi + ',' + full.target + ')"><i class="bx bx-target-lock"></i> Target Bulanan</a></li>'
                    }
                    if (full.cuser == <?= session()->get('id_user') ?> && full.status_approval == 0) {
                        str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                        str += '<li><a class="dropdown-item" onclick="DeleteData(' + data + ')"><i class="bx bx-trash"></i> Delete</a></li>'
                    }
                    if (full.status_approval == 0 && full.cuser != <?= session()->get('id_user') ?>) {
                        // str += '<li><a class="dropdown-item" onclick="ApproveData('+data+',1)"><i class="bx bx-check"></i> Approve</a></li>'
                        str += '<li><a class="dropdown-item" onclick="ApproveData(' + data + ',2)"><i class="bx bx-x"></i> Reject</a></li>'
                    }
                    str += '</ul>'
                    str += '</div>'
                    // }

                    return str;
                }
            },
            {
                data: "id_kpi",
                render: function(data, type, full, meta) {
                    if (full.status_approval == 1 || full.status_approval == 2) {
                        return ""
                    } else {
                        return '<input type="checkbox" class="form-check-input check_kpi_' + full.status_approval + '" id="check_kpi" name="check_kpi" data-kpi="' + data + '"></input>'
                    }
                }
            },
            {
                data: "status_approval",
                render: function(data, type, full, meta) {
                    var str;
                    if (data == 1) {
                        str = '<span class="badge bg-success">Approve</span>'
                    } else if (data == 2) {
                        str = '<span class="badge bg-danger">Reject</span>'
                    } else {
                        str = '<span class="badge bg-secondary">Draft</span>'
                    }
                    return str;
                }
            },
            {
                data: "nm_perspektif"
            },
            {
                data: 'bobot'
            },
            {
                data: 'nm_inisiatif'
            },
            {
                data: 'nm_kpi'
            },
            {
                data: 'sub_bobot'
            },
            {
                data: 'nm_satuan'
            },
            {
                data: 'jenis_perhitungan',
                render: function(data, type, full, meta) {
                    if (data == 1) {
                        return "Akumulasi";
                    } else if (data == 2) {
                        return "Rata-rata";
                    } else {
                        return "Progress";
                    }
                }
            },
            {
                data: 'target',
                render: function(data, type, full, meta) {
                    return addKoma(data);
                }
            },
            {
                data: 'polaritas',
                render: function(data, type, full, meta) {
                    if (data == 1) {
                        return "Minimize";
                    } else if (data == 2) {
                        return "Maximize";
                    } else {
                        return "Presize";
                    }
                }
            },
            {
                data: 'nm_bu'
            },
            {
                data: 'nm_divisi'
            },
            {
                data: 'nm_divisi_sub'
            },
            // {
            //     data: "active",
            //     render: function(data, type, full, meta){
            //         var str;
            //         if(data == 1){
            //             str = '<span class="badge bg-success rounded-pill">Active</span>'
            //         }else{
            //             str = '<span class="badge bg-danger rounded-pill">Active</span>'
            //         }
            //         return str;
            //     }
            // },
        ]
    });

    function ViewData(id_kpi) {
        if (id_kpi == 0) {
            $('#id_kpi').val(0);
            // $('#id_kpi_atasan').val(0).trigger('change');
            $('#nm_kpi').val("");
            $('#tahun').val(<?= date('Y') ?>).trigger('change');
            $('#id_inisiatif').val(0).trigger('change');
            $('#polaritas').val(0).trigger('change');
            $('#jenis_perhitungan').val(0).trigger('change');
            $('#id_divisi').val(0).trigger('change');
            $('#id_divisi_sub_h').val(0);
            <?php if (session()->get('id_bu') != 60 && count(array_keys(session()->get('level'), 2)) > 1) : ?>
                $('#id_bu').val(0).trigger('change');
            <?php endif ?>
            $('#id_inisiatif_h').val(0);
            $('#sub_bobot').val("");
            $('#id_satuan').val(0).trigger('change');
            $('#target').val(0);

            var url = "<?= base_url() ?>kpi/combobox_kpi_atasan";
            // var data = {
            //    id_divisi : $('#id_divisi').val()
            // };

            $.ajax({
                url: url,
                method: 'POST',
                // data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--KPI Atasan--</option>';
                $.each(data, function(index, value) {
                    str += '<option value="' + value['id_kpi'] + '" data-emp="">' + value['nm_kpi'] + '</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_kpi_atasan').html(str);
                $('#id_kpi_atasan').val(0).trigger('change');
            });


            $('#addModal').modal('show');
        } else {

            var url = "<?= base_url() ?>kpi/combobox_kpi_atasan";
            // var data = {
            //    id_divisi : $('#id_divisi').val()
            // };

            $.ajax({
                url: url,
                method: 'POST',
                // data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--KPI Atasan--</option>';
                var str = '';
                $.each(data, function(index, value) {
                    str += '<option value="' + value['id_kpi'] + '" data-emp="">' + value['nm_kpi'] + '</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_kpi_atasan').html(str);
                // $('#id_kpi_atasan').val(0).trigger('change');
            });


            var url_1 = "<?= base_url() ?>kpi/ax_data_kpi_by_id";
            var data_1 = {
                id_kpi: id_kpi,
            };

            $.ajax({
                url: url_1,
                method: 'POST',
                data: data_1
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kpi').val(data['id_kpi']);
                $('#id_kpi_atasan').val(data['id_kpi_atasan']).trigger('change');
                $('#nm_kpi').val(data['nm_kpi']);
                $('#id_inisiatif').val(data['id_inisiatif']).trigger('change');
                $('#tahun').val(data['tahun']).trigger('change');
                $('#polaritas').val(data['polaritas']).trigger('change');
                $('#jenis_perhitungan').val(data['jenis_perhitungan']).trigger('change');
                $('#id_divisi').val(data['id_divisi']).trigger('change');
                $('#id_divisi_sub_h').val(data['id_divisi_sub']);
                $('#id_inisiatif_h').val(data['id_inisiatif']);
                <?php if (session()->get('id_bu') != 60 && count(array_keys(session()->get('level'), 2)) > 1) : ?>
                    $('#id_bu').val(data['id_bu']).trigger('change');
                <?php endif ?>
                // $('#id_divisi_sub').val($('#id_divisi_sub_h').val());
                $('#sub_bobot').val(data['sub_bobot']);
                $('#id_satuan').val(data['id_satuan']).trigger('change');
                $('#target').val((data['target'].toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#addModal').modal('show');

            });
        }
    }

    $('#btn_save').on('click', function() {
        if ($('#nm_kpi').val() == "" || $('#nm_kpi').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Nama KPI wajib diisi.",
                icon: "error"
            });
        } else if ($('#sub_bobot').val() == 0 || $('#sub_bobot').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Bobot wajib diisi.",
                icon: "error"
            });
        } else if ($('#tahun').val() == 0 || $('#tahun').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Tahun wajib dipilih.",
                icon: "error"
            });
        } else if ($('#id_satuan').val() == 0 || $('#id_satuan').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Satuan wajib dipilih.",
                icon: "error"
            });
        } else if (($('#id_inisiatif').val() == 0 || $('#id_inisiatif').val() == undefined) && <?= count(session()->get('level')) ?> != 0) {
            Swal.fire({
                title: "Failed!",
                text: "Inisiatif Strategis wajib dipilih.",
                icon: "error"
            });
        } else if ($('#target').val() == "" || $('#target').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Target wajib diisi.",
                icon: "error"
            });
        } else if (($('#polaritas').val() == 0 || $('#polaritas').val() == undefined) && <?= count(session()->get('level')) ?> != 0) {
            Swal.fire({
                title: "Failed!",
                text: "Polaritas wajib dipilih.",
                icon: "error"
            });
        } else if ($('#id_divisi').val() == 0 || $('#id_divisi').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Divisi wajib dipilih.",
                icon: "error"
            });
        } else if ($('#id_divisi_sub').val() == 0 || $('#id_divisi_sub').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Sub Divisi wajib dipilih.",
                icon: "error"
            });
        } else if ($('#jenis_perhitungan').val() == 0 || $('#jenis_perhitungan').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Jenis Perhitungan wajib dipilih.",
                icon: "error"
            });
        } else if (($('#id_bu').val() == 0 || $('#id_bu').val() == undefined) && (<?= session()->get('id_bu') ?> != 60 && <?= count(array_keys(session()->get('level'), 2)) ?> > 1)) {
            Swal.fire({
                title: "Failed!",
                text: "Cabang wajib dipilih.",
                icon: "error"
            });
        } else {
            $('.loader').show();
            var url = "<?= base_url() ?>kpi/ax_save_data";
            var id_bu = <?= session()->get('id_bu') ?>;
            <?php if (session()->get('id_bu') != 60 && count(array_keys(session()->get('level'), 2)) > 1) : ?>
                id_bu = $('#id_bu').val();
            <?php endif ?>
            var data = {
                id_kpi: $('#id_kpi').val(),
                id_kpi_atasan: $('#id_kpi_atasan').val(),
                nm_kpi: $('#nm_kpi').val(),
                id_inisiatif: $('#id_inisiatif').val(),
                tahun: $('#tahun').val(),
                polaritas: $('#polaritas').val(),
                jenis_perhitungan: $('#jenis_perhitungan').val(),
                id_divisi: $('#id_divisi').val(),
                id_divisi_sub: $('#id_divisi_sub').val(),
                id_bu: id_bu,
                sub_bobot: $('#sub_bobot').val(),
                id_satuan: $('#id_satuan').val(),
                target: $('#target').val().replace(/\s|[.]/g, ''),
                active: 1

            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                if (data['status'] == 'success') {
                    $('#addModal').modal('hide');
                    $('.loader').hide();
                    kpiTable.ajax.reload();
                    Swal.fire({
                        title: "Success!",
                        text: "Data berhasil disimpan.",
                        icon: "success"
                    });
                } else {
                    $('.loader').hide();
                    Swal.fire({
                        title: "Failed!",
                        text: data['message'] + ".",
                        icon: "error"
                    });
                }
                // $('#addModal').modal('hide');
            });
        }
    });

    function DeleteData(id_kpi) {
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
                    Swal.fire({
                        title: "Success!",
                        text: "Data berhasil Dihapus.",
                        icon: "success"
                    });
                    kpiTable.ajax.reload();
                });
            }
        });
    }

    function ApproveData(id_kpi, status) {
        var url = "<?= base_url() ?>kpi/ax_approve_data";
        var data = {
            id_kpi: id_kpi,
            status: status
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            if (status == 1) {
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil Diapprove.",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil Direject.",
                    icon: "success"
                });
            }

            kpiTable.ajax.reload();
        });
    }



    //TARGET BULANAN

    function TargetBulan(id_kpi, nm_kpi, target_tahun) {
        $('#id_kpi_hidden').val(id_kpi);
        $('#target_tahun_hidden').val(target_tahun);
        $('#bulananModal').modal('show');
        $('#bulananModalLabel').html(nm_kpi);
        kpiBulananTable.ajax.reload();
    }


    var kpiBulananTable = $('#kpiBulananTable').DataTable({
        "ordering": false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        oLanguage: {
            sProcessing: $('.loader').hide()
        },
        ajax: {
            url: "<?= base_url() ?>kpi/ax_data_kpi_bulanan",
            type: 'POST',
            data: function(d) {
                return $.extend({}, d, {
                    "id_kpi": $('#id_kpi_hidden').val(),
                });
            }
        },
        columns: [{
                data: "id_kpi_bulanan",
                render: function(data, type, full, meta) {
                    var str = '';
                    if (full.cuser == <?= session()->get('id_user') ?>) {
                        str += '<div class="dropdown">'
                        str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                        str += '<ul class="dropdown-menu" style="">'
                        str += '<li><a class="dropdown-item" onclick="ViewDataBulanan(' + data + ')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                        str += '<li><a class="dropdown-item" onclick="DeleteDataBulanan(' + data + ')"><i class="bx bx-trash"></i> Delete</a></li>'
                        str += '</ul>'
                        str += '</div>'
                    }

                    return str;
                }
            },
            {
                data: "id_kpi_bulanan"
            },
            {
                data: 'bulan',
                render: function(data, type, full, meta) {
                    return namaBulan(data);
                }
            },
            {
                data: 'tahun'
            },
            {
                data: 'target_bulanan',
                render: function(data, type, full, meta) {
                    return addKoma(data);
                }
            },
            {
                data: 'sub_bobot_bulanan'
            },
        ]
    });

    function ViewDataBulanan(id_kpi_bulanan) {
        var d = new Date();

        if (id_kpi_bulanan == 0) {
            $('#id_kpi_bulanan').val(0)
            $('#thn').val(<?= date('Y') ?>).trigger('change')
            $('#bln').val(0).trigger('change')
            $('#target_bulanan').val("0")
            $('#sub_bobot_bulanan').val("")
            $('#addbulanModal').modal('show');
        } else {
            var url = "<?= base_url() ?>kpi/ax_data_kpi_bulanan_by_id";
            var data = {
                id_kpi_bulanan: id_kpi_bulanan,
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#id_kpi_bulanan').val(data['id_kpi_bulanan']);
                $('#thn').val(data['tahun']).trigger('change');
                $('#bln').val(data['bulan']).trigger('change');
                $('#target_bulanan').val((data['target_bulanan'].toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#sub_bobot_bulanan').val(data['sub_bobot_bulanan']);
                $('#id_divisi_sub_h').val(data['id_divisi_sub']);
                $('#addbulanModal').modal('show');
            });
        }
        $('#bulananModal').modal('hide');
    }

    $('#close_modal').on('click', function() {
        $('#bulananModal').modal('show');
        $('#addbulanModal').modal('hide');
    })


    $('#btn_save_bulanan').on('click', function() {
        if ($('#thn').val() == 0 || $('#thn').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Tahun wajib dipilih.",
                icon: "error"
            });
        } else if ($('#bln').val() == 0 || $('#bln').val() == undefined) {
            Swal.fire({
                title: "Failed!",
                text: "Bulan wajib diisi.",
                icon: "error"
            });
        }
        // else if ($('#sub_bobot_bulanan').val() == "" || $('#sub_bobot_bulanan').val() == 0 || $('#sub_bobot_bulanan').val() == undefined) {
        //     Swal.fire({
        //         title: "Failed!",
        //         text: "Sub Bobot wajib diisi.",
        //         icon: "error"
        //     });
        // }
        else {
            $('.loader').show();
            var url = "<?= base_url() ?>kpi/ax_save_data_bulanan";
            var data = {
                id_kpi: $('#id_kpi_hidden').val(),
                id_kpi_bulanan: $('#id_kpi_bulanan').val(),
                tahun: $('#thn').val(),
                bulan: $('#bln').val(),
                target_tahun: $('#target_tahun_hidden').val(),
                target_bulanan: $('#target_bulanan').val().replace(/\s|[.]/g, ''),
                sub_bobot_bulanan: $('#sub_bobot_bulanan').val(),
                active: 1
            };

            // console.log(data);

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                if (data['status'] == "success") {
                    $('#bulananModal').modal('show');
                    $('#addbulanModal').modal('hide');
                    $('.loader').hide();
                    kpiBulananTable.ajax.reload();
                    kpiTable.ajax.reload();
                    Swal.fire({
                        title: "Success!",
                        text: "Data berhasil disimpan.",
                        icon: "success"
                    });
                } else {
                    $('.loader').hide();
                    Swal.fire({
                        title: "Failed!",
                        text: data['message'],
                        icon: "error"
                    });
                }
            });
        }
    });


    function DeleteDataBulanan(id_kpi_bulanan) {
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
                var url = "<?= base_url() ?>kpi/ax_delete_data_bulanan";
                var data = {
                    id_kpi_bulanan: id_kpi_bulanan
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    Swal.fire({
                        title: "Success!",
                        text: "Data berhasil Dihapus.",
                        icon: "success"
                    });
                    kpiBulananTable.ajax.reload();
                });
            }
        });
    }


    //PREVIEW KPI

    function preview(id_divisi, id_divisi_sub, level) {

        // console.log(id_divisi+" dan "+id_divisi_sub+" dan "+level)
        var url = "<?= base_url() ?>kpi/kpi_bulanan";
        var tahun = $('#filter_tahun').val()

        window.open(url + "?id_divisi=" + id_divisi + "&id_divisi_sub=" + id_divisi_sub + "&level=" + level + "&tahun=" + tahun, '_blank');

        window.focus();
    }



    //ONCHANGE FILTER
    $('#tahun').on('change', function() {
        if ($('#tahun').val() == 0) {
            $('#id_inisiatif').html('<option value="0">--Inisiatif Strategis--</option>');
        } else {
            var url = "<?= base_url() ?>kpi/combobox_inisiatif";
            var data = {
                tahun: $('#tahun').val()
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--Inisiatif Strategis--</option>';
                $.each(data, function(index, value) {
                    str += '<option value="' + value['id_inisiatif'] + '">' + value['nm_perspektif'] + ' | ' + value['nm_inisiatif'] + '</option>';
                });
                // $('#id_inisiatif').prop('disabled', false)
                $('#id_inisiatif').html(str);
                $('#id_inisiatif').val($('#id_inisiatif_h').val()).trigger('change');
            });
        }
    });

    $('#id_divisi').on('change', function() {
        if ($('#id_divisi').val() == 0) {
            $('#id_divisi_sub').html('');
        } else {
            var url = "<?= base_url() ?>kpi/combobox_divisi_sub";
            var data = {
                id_divisi: $('#id_divisi').val()
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                var str = '<option value="0">--Sub Divisi--</option>';
                $.each(data, function(index, value) {
                    str += '<option value="' + value['id_divisi_sub'] + '" data-level="' + value['level'] + '">' + value['nm_divisi_sub'] + '</option>';
                });
                // $('#id_divisi_sub').prop('disabled', false)
                $('#id_divisi_sub').html(str);
                $('#id_divisi_sub').val($('#id_divisi_sub_h').val()).trigger('change');
            });
        }
    });

    $('#id_divisi_sub').on('change', function() {
        var level = $(this).find(':selected').data('level');
        if (level == 1) {
            $('.kpi_atasan').hide()
        } else {
            $('.kpi_atasan').show()
        }
    })

    $('#filter_tahun').on('change', function() {
        kpiTable.ajax.reload()
        $('#check_all').prop('checked', false);
    })

    $('#filter_pegawai').on('change', function() {
        kpiTable.ajax.reload()
        $('#check_all').prop('checked', false);
    })

    //CHECKBOX FUNCTION
    var list_kpi = [];
    $('#check_all').on('click', function() {
        if ($(this).is(':checked', true)) {
            $('.check_kpi_0').prop('checked', true);
        } else {
            $('.check_kpi_0').prop('checked', false);
            list_kpi = [];
        }
    })

    $('#btn_approve').on('click', function() {
        $(".check_kpi_0:checked").each(function() {
            list_kpi.push($(this).data('kpi'))
        })

        if ($('#filter_pegawai').val() == 0) {
            $('#check_all').prop('checked', false);
            $('.check_kpi_0').prop('checked', false);
            list_kpi = [];
            Swal.fire({
                title: "Failed!",
                text: "Maaf anda tidak dapat melakukan approve pada diri sendiri.",
                icon: "error"
            });
        } else if (list_kpi.length == 0) {
            Swal.fire({
                title: "Failed!",
                text: "Tidak ada KPI yang terpilih.",
                icon: "warning"
            });
        } else {
            $.each(list_kpi, function(index, value) {
                var url = "<?= base_url() ?>kpi/ax_approve_data";
                var data = {
                    id_kpi: value,
                    status: 1
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);

                });
            })

            kpiTable.ajax.reload();
            Swal.fire({
                title: "Success!",
                text: "Data berhasil Diapprove.",
                icon: "success"
            });
            $('#check_all').prop('checked', false);
            list_kpi = [];
        }
    })



    //FUNCTION
    function namaBulan(index) {
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"
        ];

        return bulan[index - 1]
    }
</script>

<?= $this->endSection() ?>