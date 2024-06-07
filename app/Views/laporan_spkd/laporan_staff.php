<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:18px;" width="100%" align="center"><b>KEY PERFORMANCE INDICATOR (KPI) <br> (<?= $bulan . " " . $tahun ?>)</td>

    </tr>
</table>
<br>
<table style="font-size:9pt;">
    <tr>
        <td>UNIT KERJA</td>
        <td width="10%">:</td>
        <td><?= strtoupper($bu['nm_bu']) ?></td>
    </tr>
    <tr>
        <td>DIVISI</td>
        <td width="10%">:</td>
        <td><?= strtoupper($divisi['nm_divisi']) ?></td>
    </tr>
    <tr>
        <td>JABATAN</td>
        <td width="10%">:</td>
        <td>STAFF <?= strtoupper($divisi_sub['nm_divisi_sub']) ?></td>
    </tr>
    <tr>
        <td>NAMA</td>
        <td width="10%">:</td>
        <td><?= strtoupper($user['contents']) ?></td>
    </tr>
    <tr>
        <td>ATASAN</td>
        <td width="10%">:</td>
        <td><?= strtoupper($user['atasan']) ?></td>
    </tr>
</table><br />

<table style="border-collapse:collapse; font-size: 8pt" border="1" width="100%">
    <thead>
        <tr>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="1%"><strong>NO</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="20%"><strong>AKTIVITAS</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>BOBOT</td>
            <td colspan="4" style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>PELAKSANAAN</td>
            <td colspan="4" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>EVALUASI/MITIGASI</td>

        </tr>
        <tr>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>TARGET</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>REALISASI</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>PENCAPAIAN</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>NILAI</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>PENYEBAB</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>TINDAKAN</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>TARGET</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>WAKTU PELAKSANAAN</td>
        </tr>
        <tr>
            <td style="text-align:center;background-color:#FFCF81;"><strong>1</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>2</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>3</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>4</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>5</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>6</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>7</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>8</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>9</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>10</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>11</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_bobot = 0;
        $total_nilai = 0;
        ?>
        <?php $i = 1;
        foreach ($evaluasi as $ev) : ?>
            <tr>
                <td style="text-align:center;"><strong><?= $i++ ?></td>
                <td style="text-align: center;"><?= $ev['nm_kpi'] ?></td>
                <?php if (session()->get('id_posisi') == 10) { ?>
                    <td style="text-align: center;"><?= $ev['sub_bobot'] ?></td>
                <?php } else { ?>
                    <td style="text-align: center;"><?= $ev['sub_bobot_bulanan'] ?></td>
                <?php } ?>
                <td style="text-align: center;"><?= number_format($ev['target'], 2, ",", ".") ?></td>
                <td style="text-align: center;"><?= number_format($ev['realisasi'], 2, ",", ".") ?></td>
                <td style="text-align: center;"><?= $ev['pencapaian'] ?></td>
                <td style="text-align: center;"><?= $ev['nilai'] ?></td>
                <td style="text-align: center;"><?= $ev['penyebab'] ?></td>
                <td style="text-align: center;"><?= $ev['tindakan_perbaikan'] ?></td>
                <td style="text-align: center;"><?= $ev['target_perbaikan'] ?></td>
                <td style="text-align: center;"><?= $ev['waktu_perbaikan'] ?></td>
            </tr>
            <?php
            if (session()->get('id_posisi') == 10) {
                $total_bobot += $ev['sub_bobot'];
            } else {
                $total_bobot += $ev['sub_bobot_bulanan'];
            }
            $total_nilai += $ev['nilai'];
            ?>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: center;" colspan="2" rowspan="4"><strong>Total</td>
        </tr>
        <tr>
            <td style="text-align: center;"><strong><?= $total_bobot ?>%</td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td style="text-align: center;"><strong><?= $total_nilai ?>%</td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
        </tr>
        <?php
        if ($total_nilai > 120) {
            $total_nilai = 120;
        }
        if ($total_nilai < 85) {
            $nilai_final = 1;
            $conv_final = "Tidak Sesuai Kriteria";
        } elseif ($total_nilai >= 85 && $total_nilai <= 94) {
            $nilai_final = 2;
            $conv_final = "Di Bawah Kriteria";
        } elseif ($total_nilai >= 95 && $total_nilai <= 100) {
            $nilai_final = 3;
            $conv_final = "Sesuai Kriteria";
        } elseif ($total_nilai >= 101 && $total_nilai <= 110) {
            $nilai_final = 4;
            $conv_final = "Melebihi Kriteria";
        } elseif ($total_nilai >= 111 && $total_nilai <= 120) {
            $nilai_final = 5;
            $conv_final = "Jauh Melebihi Kriteria";
        }
        ?>
        <tr>
            <td style="text-align: center;" colspan="4">Nilai</td>
            <td style="text-align: center;"><?= $nilai_final ?></td>
        </tr>
        <tr>
            <td style="text-align: center;" colspan="4">Karakteristik</td>
            <td style="text-align: center;"><?= $conv_final ?></td>
        </tr>

    </tfoot>

</table>
<br>
<div style="margin-left: 10%; margin-right:10%">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <p style="font-size: 10pt;">Disusun Oleh</p>
                <?php if (!empty($evaluasi)) : ?>
                    <img width="80" height="80" src="<?= $qr_pembuat ?>" alt="" />
                <?php endif ?>
                <p style="font-size: 10pt;"><?= strtoupper($user['contents']) ?></p>
            </div>
        </div>
        <div>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <p style="font-size: 10pt;">Disetujui Oleh</p>
                <?php if (!empty($evaluasi)) : ?>
                    <img width="80" height="80" src="<?= $qr_atasan ?>" alt="" />
                <?php endif ?>
                <p style="font-size: 10pt;"><?= strtoupper($user['user_atasan']) ?></p>
            </div>
        </div>
    </div>
</div>