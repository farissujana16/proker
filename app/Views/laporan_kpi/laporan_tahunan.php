<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:18px;" width="100%" align="center"><b>KEY PERFORMANCE INDICATOR (KPI) <br> <?= $tahun ?></td>

    </tr>
</table>
<br>
<table style="font-size:9pt;">
    <tr>
        <td>DIVISI</td>
        <td width="5%">:</td>
        <td><?= strtoupper($divisi['nm_divisi']) ?></td>
    </tr>
    <tr>
        <td>JABATAN</td>
        <td width="5%">:</td>
        <td><?= strtoupper($user['nm_organisasi']) ?></td>
    </tr>
    <tr>
        <td>NAMA</td>
        <td width="5%">:</td>
        <td><?= strtoupper($user['contents']) ?></td>
    </tr>
    <tr>
        <td>ATASAN</td>
        <td width="5%">:</td>
        <td><?= strtoupper($user['atasan']) ?></td>
    </tr>
</table><br />

<table style="border-collapse:collapse; font-size: 8pt" border="1" width="100%">
    <thead>
        <tr>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="1%"><strong>NO</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>PERSPEKTIF</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>BOBOT PERSPEKTIF</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="15%"><strong>STRATEGIC OBJECTIVE</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="20%"><strong>KPI</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>SUB BOBOT</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>SATUAN</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>TARGET</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>POLARITAS</td>
            <td colspan="2" style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>PENGUKURAN</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>CASCADING</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="10%"><strong>KETERANGAN</td>
            
        </tr>
        <tr>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>SIKLUS</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>RUMUS</td>
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
        </tr>
    </thead>
    <tbody>
        <?php $total_sub_bobot = 0; $i = 1; foreach($perspektif as $per): ?>
            <?php 
                $span = 1;
                foreach($tahunan as $k){
                    if ($k['id_perspektif'] == $per['id_perspektif']) {
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
                    <?php foreach($tahunan as $k): ?>
                        <?php if($k['id_perspektif'] == $per['id_perspektif']): ?>
                            <tr>
                                <td>-</td>
                                <td><?= $k['nm_inisiatif'] ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                    </table>
                </td>
            </tr>
            <?php foreach($tahunan as $k): ?>
                <?php if($k['id_perspektif'] == $per['id_perspektif']): ?>
                    <tr>
                        <td><?= $k['nm_kpi'] ?></td>
                        <td style="text-align: center;"><?= $k['sub_bobot'] ?>%</td>
                        <td style="text-align: center;"><?= $k['nm_satuan'] ?></td>
                        <td style="text-align: center;"><?= number_format($k['target'],2,",",".") ?></td>
                        <td style="text-align: center;"><?= $k['polaritas'] == 1? "Minize" : "Maximize" ?></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <?php
                        $total_sub_bobot += $k['sub_bobot'];
                    ?>
                <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
        <tr>
            <td style="text-align: center;" colspan="5"><b>Total Sub Bobot</b></td>
            <td style="text-align: center;"><b><?= $total_sub_bobot ?>%</b></td>
            <td colspan="7"></td>
        </tr>
    </tbody>
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
    