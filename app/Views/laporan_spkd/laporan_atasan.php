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
        <td><?= strtoupper($user['nm_organisasi']) ?></td>
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
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="12%"><strong>PERSPEKTIF</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>BOBOT PERSPEKTIF</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="15%"><strong>STRATEGIC OBJECTIVE</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="25%"><strong>KPI</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>SUB BOBOT</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>SATUAN</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>TARGET</td>
            <td colspan="4" style="text-align:center;background-color:#d5d5e3;" width=""><strong>PELAKSANAAN</td>
            <td colspan="4" style="text-align:center;background-color:#d5d5e3;" width=""><strong>EVALUASI/MITIGASI</td>

        </tr>
        <tr>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>RENCANA/ TARGET</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>REALISASI</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>PENCAPAIAN</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>NILAI</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="15%"><strong>PENYEBAB</td>
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
            <td style="text-align:center;background-color:#FFCF81;"><strong>12</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>13</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>14</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>15</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>16</td>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        $total_bobot = 0;
        $total_sub_bobot = 0;
        $total_evaluasi = 0;
        foreach ($perspektif as $per) : ?>
            <?php
            $span = 1;
            foreach ($evaluasi as $ev) {
                if ($ev['id_perspektif'] == $per['id_perspektif']) {
                    $span++;
                }
            }
            ?>
            <tr>
                <td rowspan="<?= $span ?>" style="text-align:center;"><?= $i++ ?></td>
                <td rowspan="<?= $span ?>"><?= $per['nm_perspektif'] ?></td>
                <td rowspan="<?= $span ?>" style="text-align:center;"><?= $per['bobot'] ?>%</td>
                <td rowspan="<?= $span ?>">
                    <table style="font-size: 8pt">
                        <?php foreach ($evaluasi as $ev) : ?>
                            <?php if ($ev['id_perspektif'] == $per['id_perspektif']) : ?>
                                <tr>
                                    <td>-</td>
                                    <td><?= $ev['nm_inisiatif'] ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </table>
                </td>
            </tr>
            <?php foreach ($evaluasi as $ev) : ?>
                <?php if ($ev['id_perspektif'] == $per['id_perspektif']) : ?>
                    <tr>
                        <td><?= $ev['nm_kpi'] ?></td>
                        <td style="text-align: center;"><?= $ev['sub_bobot_bulanan'] ?>%</td>
                        <td style="text-align: center;"><?= $ev['nm_satuan'] ?></td>
                        <td style="text-align: center;"><?= number_format($ev['target'], 2, ",", ".") ?></td>
                        <td style="text-align: center;"><?= number_format($ev['target_bulanan'], 2, ",", ".") ?></td>
                        <td style="text-align: center;"><?= number_format($ev['realisasi'], 2, ",", ".") ?></td>
                        <td style="text-align: center;"><?= $ev['pencapaian'] ?></td>
                        <td style="text-align: center;"><?= $ev['nilai'] ?></td>
                        <td style="text-align: center;"><?= $ev['penyebab'] ?></td>
                        <td style="text-align: center;"><?= $ev['tindakan_perbaikan'] ?></td>
                        <td style="text-align: center;"><?= $ev['target_perbaikan'] ?></td>
                        <td style="text-align: center;"><?= $ev['waktu_perbaikan'] ?></td>

                    </tr>
                <?php $total_evaluasi += $ev['nilai'];
                    $total_sub_bobot += $ev['sub_bobot_bulanan'];
                endif ?>
            <?php endforeach ?>
        <?php $total_bobot += $per['bobot'];
        endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: center;" colspan="2" rowspan="4"><strong>Total</td>
        </tr>
        <tr>
            <td style="text-align: center;"><strong><?= $total_bobot ?>%</td>
            <td><strong></td>
            <td><strong></td>
            <td style="text-align: center;"><strong><?= $total_sub_bobot ?>%</td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td style="text-align: center;"><strong><?= $total_evaluasi ?>%</td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
            <td><strong></td>
        </tr>
        <?php
        if ($total_evaluasi > 120) {
            $total_evaluasi = 120;
        }

        if ($total_evaluasi < 85) {
            $nilai_final = 1;
            $conv_final = "Tidak Sesuai Kriteria";
        } elseif ($total_evaluasi >= 85 && $total_evaluasi <= 94) {
            $nilai_final = 2;
            $conv_final = "Di Bawah Kriteria";
        } elseif ($total_evaluasi >= 95 && $total_evaluasi <= 100) {
            $nilai_final = 3;
            $conv_final = "Sesuai Kriteria";
        } elseif ($total_evaluasi >= 101 && $total_evaluasi <= 110) {
            $nilai_final = 4;
            $conv_final = "Melebihi Kriteria";
        } elseif ($total_evaluasi >= 111 && $total_evaluasi <= 120) {
            $nilai_final = 5;
            $conv_final = "Jauh Melebihi Kriteria";
        }
        ?>
        <tr>
            <td style="text-align: center;" colspan="9">Nilai</td>
            <td style="text-align: center;"><?= $nilai_final ?></td>
        </tr>
        <tr>
            <td style="text-align: center;" colspan="9">Karakteristik</td>
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