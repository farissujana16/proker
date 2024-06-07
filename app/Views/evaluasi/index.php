<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">

        <!--start stepper one-->

        <h6 class="text-uppercase">Evaluasi</h6>
        <hr>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control select2" style="width: 100%;">
                            <?php foreach ($tahun as $thn) : ?>
                                <option value="<?= $thn ?>" <?= $thn == date('Y') ? "selected" : "" ?>><?= $thn ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control select2" style="width: 100%;">
                            <option value="1" <?= 1 == date('n') ? "selected" : "" ?>>Januari</option>
                            <option value="2" <?= 2 == date('n') ? "selected" : "" ?>>Februari</option>
                            <option value="3" <?= 3 == date('n') ? "selected" : "" ?>>Maret</option>
                            <option value="4" <?= 4 == date('n') ? "selected" : "" ?>>April</option>
                            <option value="5" <?= 5 == date('n') ? "selected" : "" ?>>Mei</option>
                            <option value="6" <?= 6 == date('n') ? "selected" : "" ?>>Juni</option>
                            <option value="7" <?= 7 == date('n') ? "selected" : "" ?>>Juli</option>
                            <option value="8" <?= 8 == date('n') ? "selected" : "" ?>>Agustus</option>
                            <option value="9" <?= 9 == date('n') ? "selected" : "" ?>>September</option>
                            <option value="10" <?= 10 == date('n') ? "selected" : "" ?>>Oktober</option>
                            <option value="11" <?= 11 == date('n') ? "selected" : "" ?>>November</option>
                            <option value="12" <?= 11 == date('n') ? "selected" : "" ?>>Desember</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="id_user">Pegawai</label>
                        <select name="id_user" id="id_user" class="form-control select2" style="width: 100%;">
                            <option value="0">--Pegawai--</option>
                            <?php if (session()->get('level')) : ?>
                                <?php foreach ($combobox_pegawai as $pegawai) : ?>
                                    <option value="<?= $pegawai['id_user'] ?>" data-bu="<?= $pegawai['id_bu'] ?>" data-divisi="<?= $pegawai['id_divisi'] ?>" data-sub="<?= $pegawai['id_divisi_sub'] ?>" data-level="<?= $pegawai['level'] ?>"><?= strtoupper($pegawai['nm_pegawai'])  ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for=""></label>
                        <?php if (session()->get('level')) : ?>
                            <div class="dropdown options ms-auto" id="btn_atasan">
                                <button class="btn btn-dark form-control dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-file-find mr-1"></i>Preview</button>
                                <ul class="dropdown-menu">
                                    <?php foreach ($jabatan as $level) : ?>
                                        <li><a class="dropdown-item" onclick="preview(<?= $level['id_divisi'] . ',' . $level['id_divisi_sub'] . ',' . $level['level'] ?>)"><?= $level['nm_organisasi'] ?></a></li>
                                    <?php endforeach ?>

                                </ul>
                            </div>
                        <?php endif ?>
                        <button class="btn btn-primary form-control" id="btn_bawahan">Preview</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="evaluasiTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width='5%'>Action</th>
                                <th><input type="checkbox" name="check_all" id="check_all" class="form-check-input"></th>
                                <th>Status</th>
                                <th>Nama KPI</th>
                                <th>Sub Bobot</th>
                                <th>Satuan</th>
                                <th>Target Tahun</th>
                                <th>Target Bulanan</th>
                                <th>Realisasi</th>
                                <th>Pencapaian</th>
                                <th>Nilai</th>
                                <th>Komentar</th>
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
                        <div class="col-12">
                            <input type="text" name="id_kpi" id="id_kpi" value="" hidden>
                            <input type="text" name="id_spkd" id="id_spkd" value="" hidden>
                            <input type="hidden" name="polaritas" id="polaritas" value="">
                            <div class="mb-2">
                                <label for="">KPI</label>
                                <input type="text" class="form-control" name="nm_kpi" id="nm_kpi" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="">Satuan</label>
                                <input type="text" class="form-control" name="nm_satuan" id="nm_satuan" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="">Target Tahun Ini</label>
                                <input type="text" class="form-control" name="target" id="target" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="">Target Bulan Ini</label>
                                <input type="text" class="form-control" name="target_bulan" id="target_bulan" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="">Realisasi</label>
                                <input type="text" class="form-control" name="realisasi" id="realisasi">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="btn_save" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="id_spkd_comment" id="id_spkd_comment" hidden>
                        <label for="komentae">Komentar Perbaikan</label>
                        <textarea class="form-control" name="komentar" id="komentar" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="reject_spkd" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="keterangan"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="evaluasiModal" tabindex="-1" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="evaluasiModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <input type="text" name="id_spkd_evaluasi" id="id_spkd_evaluasi" value="" hidden>
                            <div class="mb-2">
                                <label for="">Penyebab Tidak Tercapai</label>
                                <input type="text" class="form-control" name="penyebab" id="penyebab">
                            </div>
                            <div class="mb-2">
                                <label for="">Tindakan Perbaikan</label>
                                <input type="text" class="form-control" name="tindakan_perbaikan" id="tindakan_perbaikan">
                            </div>
                            <div class="mb-2">
                                <label for="">Target Perbaikan</label>
                                <input type="text" class="form-control" name="target_perbaikan" id="target_perbaikan">
                            </div>
                            <div class="mb-2">
                                <label for="">Waktu Perbaikan</label>
                                <input type="text" class="form-control" name="waktu_perbaikan" id="waktu_perbaikan">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="btn_save_evaluasi" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    $("#target").maskMoney({
        thousands: '.',
        decimal: ',',
        affixesStay: false,
        precision: 2
    });
    $("#target_bulan").maskMoney({
        thousands: '.',
        decimal: ',',
        affixesStay: false,
        precision: 2,
        allowNegative: true
    });
    $("#realisasi").maskMoney({
        thousands: '.',
        decimal: ',',
        affixesStay: false,
        precision: 2,
        allowNegative: true
    });

    if (<?= count(session()->get('level')) ?> > 0) {
        $('#btn_bawahan').hide();
    }


    var evaluasiTable = $('#evaluasiTable').DataTable({
        "ordering": false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        oLanguage: {
            sProcessing: $('.loader').hide()
        },
        ajax: {
            url: "<?= base_url() ?>evaluasi/ax_data_evaluasi",
            type: 'POST',
            data: function(d) {
                return $.extend({}, d, {
                    "tahun": $('#tahun').val(),
                    "bulan": $('#bulan').val(),
                    "id_user": $('#id_user').val(),
                    "id_bu": $('#id_user').find(':selected').data('bu'),
                    "id_divisi": $('#id_user').find(':selected').data('divisi'),
                    "id_divisi_sub": $('#id_user').find(':selected').data('sub'),
                    "level": $('#id_user').find(':selected').data('level'),
                });
            }
        },
        columns: [{
                data: "id_spkd",
                render: function(data, type, full, meta) {
                    var str = '';
                    var nm_satuan = "'" + full.nm_satuan + "'";
                    var nm_kpi = "'" + full.nm_kpi + "'";
                    var target = "'" + full.target + "'";
                    var target_bulanan = "'" + full.target_bulanan + "'";
                    var level = ['<?= implode("','", session()->get('level')) ?>']
                    if (full.status == undefined || full.status == 0 || full.status == 2) {
                        str += '<div class="dropdown">'
                        str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                        str += '<ul class="dropdown-menu" style="">'
                        if (full.status == undefined && <?= session()->get('id_posisi') ?> != 10 && $('#id_user').val() == 0) {
                            str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ',' + full.id_kpi + ',' + target + ',' + nm_satuan + ',' + nm_kpi + ',' + target_bulanan + ',' + full.polaritas + ')"><i class="bx bx-list-ul"></i> Isi Nilai</a></li>'
                        } else if (full.status == undefined && <?= session()->get('id_posisi') ?> == 10) {
                            str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ',' + full.id_kpi + ',' + target + ',' + nm_satuan + ',' + nm_kpi + ',' + target_bulanan + ',' + full.polaritas + ')"><i class="bx bx-list-ul"></i> Isi Nilai</a></li>'

                        } else if (full.status == 0) {
                            if ($('#id_user').val() != 0) {
                                // str += '<li><a class="dropdown-item" onclick="approve('+data+')"><i class="bx bx-check"></i> Approve</a></li>'
                                str += '<li><a class="dropdown-item" onclick="reject(' + data + ')"><i class="bx bx-x"></i> Reject</a></li>'
                            } else {
                                str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ',' + full.id_kpi + ',' + target + ',' + nm_satuan + ',' + nm_kpi + ',' + target_bulanan + ',' + full.polaritas + ')"><i class="bx bx-list-ul"></i> Isi Nilai</a></li>'
                            }
                        } else if (full.status == 2 && full.cuser == <?= session()->get('id_user') ?>) {
                            str += '<li><a class="dropdown-item" onclick="ViewData(' + data + ',' + full.id_kpi + ',' + target + ',' + nm_satuan + ',' + nm_kpi + ',' + target_bulanan + ',' + full.polaritas + ')"><i class="bx bx-list-ul"></i> Isi Nilai</a></li>'
                        }
                        str += '</ul>'
                        str += '</div>'
                    }

                    return str;
                }
            },
            {
                data: "id_spkd",
                render: function(data, type, full, meta) {
                    if (full.status == undefined || full.status == 1 || full.status == 2) {
                        return ""
                    } else {
                        return '<input type="checkbox" class="form-check-input check_spkd_' + full.status + '" id="check_spkd" name="check_kpi" data-spkd="' + data + '"></input>'
                    }
                }
            },
            {
                data: "status",
                render: function(data, type, full, meta) {
                    var str = "";

                    if (data == undefined) {
                        str = ""
                    }
                    if (data == 0) {
                        str = '<span class="badge bg-secondary">Pending</span>';
                    } else if (data == 1) {
                        str = '<span class="badge bg-success">Approve</span>';
                    } else if (data == 2) {
                        str = '<span class="badge bg-danger">Reject</span>';
                    }

                    return str;
                }
            },
            {
                data: "nm_kpi"
            },
            {
                data: "sub_bobot"
            },
            {
                data: "nm_satuan"
            },
            {
                data: "target",
                render: function(data, type, full, meta) {
                    return addKoma(data);
                }
            },
            {
                data: "target_bulanan",
                render: function(data, type, full, meta) {
                    return addKoma(data);
                }
            },
            {
                data: "realisasi",
                render: function(data, type, full, meta) {
                    if (data == undefined) {
                        return "";
                    } else {
                        return addKoma(data);
                    }
                }
            },
            {
                data: "pencapaian",
                render: function(data, type, full, meta) {
                    if (data == undefined) {
                        return ""
                    } else {

                        return data + "%";
                    }
                }
            },
            {
                data: "nilai",
                render: function(data, type, full, meta) {
                    if (data == undefined) {
                        return ""
                    } else {

                        return data + "%";
                    }
                }
            },
            {
                data: "status",
                render: function(data, type, full, meta) {
                    var str = "";

                    if (data == 2) {
                        str = '<button onclick="showComment(' + full.id_spkd + ')" class="btn btn-sm btn-danger"> <i class="bx bx-comment-detail me-0"></i></button>'
                    }

                    return str;
                }
            },
        ]
    });

    function ViewData(id_spkd, id_kpi, target, nm_satuan, nm_kpi, target_bulanan, polaritas) {
        if (id_spkd == 0) {
            $('#id_spkd').val(id_spkd);
            $('#id_kpi').val(id_kpi);
            $('#polaritas').val(polaritas);
            $('#target_bulan').val((target_bulanan.toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $('#target').val((target.toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $('#nm_satuan').val(nm_satuan);
            $('#nm_kpi').val(nm_kpi);
            $('#realisasi').val("");
            $('#addModal').modal('show');
            $('#addModalLabel').html('Isi SPKD');
        } else {
            var url = "<?= base_url() ?>evaluasi/ax_data_evaluasi_by_id";
            var data = {

                id_spkd: id_spkd,
                bulan: $('#bulan').val()

            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                console.log(data);
                $('#id_spkd').val(data['id_spkd']);
                $('#id_kpi').val(data['id_kpi']);
                $('#polaritas').val(polaritas);
                $('#target_bulan').val((data['target_bulanan'].toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#target').val((data['target'].toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#nm_satuan').val(data['nm_satuan']);
                $('#nm_kpi').val(data['nm_kpi']);
                $('#realisasi').val((data['realisasi'].toString().replace(/\s|[.]/g, ',')).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#addModal').modal('show');
                $('#addModalLabel').html('Isi SPKD');
            });
        }
    }

    $('#btn_save').on('click', function() {
        // console.log($('#realisasi').val().replace(/\s|[.]/g, '') < $('#target_bulan').val().replace(/\s|[.]/g, ''))
        console.log(parseInt($('#realisasi').val().replace(/\s|[.]/g, '')))
        if (parseInt($('#realisasi').val().replace(/\s|[.]/g, '')) < parseInt($('#target_bulan').val().replace(/\s|[.]/g, '')) && $('#polaritas').val() == 2) {
            $('#penyebab').val(""),
                $('#tindakan_perbaikan').val(""),
                $('#target_perbaikan').val(""),
                $('#waktu_perbaikan').val(""),
                $('#evaluasiModal').modal('show');
            $('#addModal').modal('hide');
        } else {
            $('.loader').show();
            var url = "<?= base_url() ?>evaluasi/ax_save_data";
            var data = {
                id_spkd: $('#id_spkd').val(),
                id_kpi: $('#id_kpi').val(),
                id_kpi: $('#id_kpi').val(),
                target_bulan: $('#target_bulan').val().replace(/\s|[.]/g, ''),
                realisasi: $('#realisasi').val().replace(/\s|[.]/g, ''),
                bulan: $('#bulan').val(),
                tahun: $('#tahun').val(),
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('.loader').hide();
                $('#addModal').modal('hide');
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil disimpan.",
                    icon: "success"
                });
                evaluasiTable.ajax.reload();
            });
        }
    });

    $('#btn_save_evaluasi').on('click', function() {
        if ($('#penyebab').val() == "") {
            Swal.fire({
                title: "Warning!",
                text: "Penyebab Wajib Diisi.",
                icon: "warning"
            });
            return;
        } else if ($('#tindakan_perbaikan').val() == "") {
            Swal.fire({
                title: "Warning!",
                text: "Tindakan Wajib Diisi.",
                icon: "warning"
            });
            return;
        } else if ($('#target_perbaikan').val() == "") {
            Swal.fire({
                title: "Warning!",
                text: "Target Wajib Diisi.",
                icon: "warning"
            });
            return;
        } else if ($('#waktu_perbaikan').val() == "") {
            Swal.fire({
                title: "Warning!",
                text: "Waktu Perbaikan Wajib Diisi.",
                icon: "warning"
            });
            return;
        } else {
            $('.loader').show();
            var url = "<?= base_url() ?>evaluasi/ax_save_data";
            var data = {
                id_spkd_evaluasi: $('#id_spkd_evaluasi').val(),
                id_spkd: $('#id_spkd').val(),
                id_kpi: $('#id_kpi').val(),
                id_kpi: $('#id_kpi').val(),
                target_bulan: $('#target_bulan').val().replace(/\s|[.]/g, ''),
                realisasi: $('#realisasi').val().replace(/\s|[.]/g, ''),
                bulan: $('#bulan').val(),
                tahun: $('#tahun').val(),
                penyebab: $('#penyebab').val(),
                tindakan_perbaikan: $('#tindakan_perbaikan').val(),
                target_perbaikan: $('#target_perbaikan').val(),
                waktu_perbaikan: $('#waktu_perbaikan').val(),
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('.loader').hide();
                $('#evaluasiModal').modal('hide');
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil disimpan.",
                    icon: "success"
                });
                evaluasiTable.ajax.reload();
            });

        }
    });

    function DeleteData(id_evaluasi) {
        var url = "<?= base_url() ?>evaluasi/ax_delete_data";
        var data = {
            id_evaluasi: id_evaluasi
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            console.log(data);
            evaluasiTable.ajax.reload();
        });
    }


    function approve(id_spkd) {
        var url = "<?= base_url() ?>evaluasi/ax_approve_data";
        var data = {
            id_spkd: id_spkd
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);;
            evaluasiTable.ajax.reload();
        });
    }

    function showComment(id_spkd) {
        var url = "<?= base_url() ?>evaluasi/ax_data_evaluasi_by_id";
        var data = {

            id_spkd: id_spkd,

        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            $('#keterangan').html(data['keterangan']);
            $('#commentModal').modal('show');
            $('#commentModalLabel').html('Komentar Perbaikan');
        });
    }

    function reject(id_spkd) {
        $('#id_spkd_comment').val(id_spkd)
        $('#rejectModal').modal('show');
        $('#rejectModalLabel').html('Komentar Perbaikan');
        // console.log(id_spkd);
    }

    $('#reject_spkd').on('click', function() {
        var url = "<?= base_url() ?>evaluasi/ax_reject_data";
        var data = {
            id_spkd: $('#id_spkd_comment').val(),
            keterangan: $('#komentar').val(),
        };
        console.log(data);

        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(data, textStatus, jqXHR) {
            var data = JSON.parse(data);
            Swal.fire({
                title: "Success!",
                text: "Data berhasil disimpan.",
                icon: "success"
            });
            $('#rejectModal').modal('hide');
        });
    })

    function preview(id_divisi, id_divisi_sub, level) {
        var url = "<?= base_url() ?>laporan_spkd/laporan";
        var tahun = $('#tahun').val()
        var bulan = $('#bulan').val()

        window.open(url + "?id_bu=<?= session()->get('id_bu') ?>&id_divisi=" + id_divisi + "&id_divisi_sub=" + id_divisi_sub + "&id_user=<?= session()->get('id_user') ?>&tahun=" + tahun + "&bulan=" + bulan, '_blank');

        window.focus();
    }

    $('#btn_bawahan').on('click', function() {
        var id_user = $('#id_user').val();
        var id_divisi = 0;
        var id_divisi_sub = 0;

        if (id_user == 0) {
            id_user = <?= session()->get('id_user') ?>;
            id_divisi = <?= session()->get('divisi') ?>;
            id_divisi_sub = <?= session()->get('divisi_sub') ?>;
        } else {
            id_divisi = $('#id_user').find(':selected').data('divisi');
            id_divisi_sub = $('#id_user').find(':selected').data('sub');
        }

        var url = "<?= base_url() ?>laporan_spkd/laporan";
        var tahun = $('#tahun').val()
        var bulan = $('#bulan').val()

        window.open(url + "?id_bu=<?= session()->get('id_bu') ?>&id_divisi=" + id_divisi + "&id_divisi_sub=" + id_divisi_sub + "&id_user=" + id_user + "&tahun=" + tahun + "&bulan=" + bulan, '_blank');

        window.focus();
    })



    // get_kpi();

    // function get_kpi(){
    //     var date = new Date();
    //     var month = (date.getMonth()+1) < 10 ? '0'+(date.getMonth()+1) : date.getMonth();
    //     var tgl = date.getFullYear()+"-"+ month;
    //     var id_user;
    //     <?php if (!empty(session()->get('level'))) { ?>
    //         id_user = $('#id_pegawai').val()
    //     <?php } else { ?>
    //         id_user = <?= session()->get('id_user') ?>
    //     <?php } ?>
    //     // console.log(tgl);
    //     var url = "<?= base_url() ?>evaluasi/ax_get_kpi";
    //     var data = {
    //        id_user: $('#id_pegawai').val(),
    //        tgl: tgl

    //     };

    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         data: data
    //     }).done(function(data, textStatus, jqXHR) {
    //         var data = JSON.parse(data);
    //         var str = ""
    //         var dis;
    //         str += '<tr class="">'
    //             str += '<th style="width: 5%;">No</th>'
    //             str += '<th style="width: 25%;">KPI</th>'
    //             str += '<th style="width: 45%;">Deskripsi</th>'
    //             str += '<th style="width: 10%;">Bobot %</th>'
    //             str += '<th style="width: 10%;">Pencapaian %</th>'
    //         str += '</tr>'
    //         $.each(data, function(index, value){
    //             str += "<tr>"
    //             str += "<td>"+(index + 1)+"</td>"
    //             str += "<td>"+value['nm_kpi_personal']+"</td>"
    //             str += "<td>"+value['deskripsi']+"</td>"
    //             str += "<td>100</td>"
    //             if (value['id_spkd'] == '0') {
    //                 dis = ""
    //             }else{
    //                 dis = "disabled";
    //             }
    //             str += '<td><input class="form-control" name="" id="" value="'+value['pencapaian']+'" '+dis+'></td>'
    //             str += "</tr>" 
    //             console.log(value)
    //         });
    //         $('#spkd_kpi').html(str);
    //         // evaluasiTable.ajax.reload();
    //     });
    // }

    // $('#id_pegawai').on('change', function(){

    //     if ($(this).find(':selected').data('level') != 5) {

    //     }else{

    //     }

    //     get_kpi();
    // })

    $('#bulan').on('change', function() {
        evaluasiTable.ajax.reload()
    })
    $('#tahun').on('change', function() {
        evaluasiTable.ajax.reload()
    })
    $('#id_user').on('change', function() {
        evaluasiTable.ajax.reload()
        $('#check_all').prop('checked', false);
        if ($(this).val() == 0) {
            $('#btn_atasan').show();
            $('#btn_bawahan').hide();
            $('#btn_approve').prop('disabled', true);
        } else {
            $('#btn_atasan').hide();
            $('#btn_bawahan').show();
            $('#btn_approve').prop('disabled', false);
        }
    })


    //CHECKBOX CONDITION

    var list_spkd = [];
    $('#check_all').on('click', function() {
        if ($(this).is(':checked', true)) {
            $('.check_spkd_0').prop('checked', true);
        } else {
            $('.check_spkd_0').prop('checked', false);
            list_spkd = [];
        }
    })

    $('#btn_approve').on('click', function() {
        $(".check_spkd_0:checked").each(function() {
            list_spkd.push($(this).data('spkd'))
        })

        if ($('#id_user').val() == 0) {
            $('#check_all').prop('checked', false);
            $('.check_spkd_0').prop('checked', false);
            list_spkd = [];
            Swal.fire({
                title: "Failed!",
                text: "Maaf anda tidak dapat melakukan approve pada diri sendiri.",
                icon: "error"
            });
        } else if (list_spkd.length == 0) {
            Swal.fire({
                title: "Failed!",
                text: "Tidak ada SPKD yang terpilih.",
                icon: "warning"
            });
        } else {
            $.each(list_spkd, function(index, value) {
                var url = "<?= base_url() ?>evaluasi/ax_approve_data";
                var data = {
                    id_spkd: value
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);;
                    // evaluasiTable.ajax.reload();
                });
            })

            evaluasiTable.ajax.reload()
            Swal.fire({
                title: "Success!",
                text: "Data berhasil Diapprove.",
                icon: "success"
            });
            $('#check_all').prop('checked', false);
            list_spkd = [];
        }
    })
</script>

<?= $this->endSection() ?>