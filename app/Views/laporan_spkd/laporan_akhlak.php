<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:18px;" width="100%" align="center"><b>LAPORAN AKHLAK <br> (<?= $bulan." ".$tahun ?>)</td>

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

<table style="border-collapse:collapse; font-size: 9pt" border="1" width="100%">
    <thead>
        <tr>
            <td rowspan="3" style="text-align:center;background-color:#d5d5e3;" width="1%"><strong>NO</td>
            <td rowspan="3" style="text-align:center;background-color:#d5d5e3;" width="49%"><strong>KOMPONEN AKHLAK</td>
            <td colspan="5" style="text-align:center;background-color:#d5d5e3;"><strong>SKOR</td>
            
        </tr>
        <tr>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>TIDAK PERNAH</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>JARANG</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>KADANG-KADANG</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>SERING</td>
            <td style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>SELALU</td>
        </tr>
        <tr>
            <td style="text-align:center;background-color:#FFCF81;"><strong>1</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>2</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>3</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>4</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>5</td>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; foreach($akhlak as $a): ?>
            <tr>
                <td colspan="8" style="background-color:#BFD8AF;"><b><?= $a['nm_akhlak'] ?></b></td>
            </tr>
            <?php $no = 1; foreach($evaluasi_akhlak as $ea): ?>
                <?php if($a['id_akhlak'] == $ea['id_akhlak']): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?>.</td>
                        <td><?= $ea['nm_akhlak_detail'] ?></td>
                        <?php for($i = 1; $i <= 5; $i++ ): ?>
                            <td style="text-align: center;"><?= $ea['nilai'] == $i? "✔️" : "" ?></td>
                        <?php endfor ?>
                    </tr>
                <?php $total += $ea['nilai']; endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
        
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center;"><b>Nilai Akhir</b></td>
            <td colspan="5" style="text-align: center;"><b><?= $total ?></b></td>
        </tr>

    </tfoot>

</table>
<br>
<div style="margin-left: 10%; margin-right:10%">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <p style="font-size: 10pt;">Disusun Oleh</p>
            <img width="80" height="80" src="<?= $qr_pembuat ?>" alt="" />
            <p style="font-size: 10pt;"><?= strtoupper($user['contents']) ?></p>
          </div>
        </div>
        <div>
          <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <p style="font-size: 10pt;">Disetujui Oleh</p>
            <img width="80" height="80" src="<?= $qr_atasan ?>" alt="" />
            <p style="font-size: 10pt;"><?= strtoupper($user['user_atasan']) ?></p>
          </div>
        </div>
      </div>
</div>
    