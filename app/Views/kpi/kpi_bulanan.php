<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:18px;" width="100%" align="center"><b>KEY PERFORMANCE INDICATOR (KPI) <br> <?= $tahun ?></td>

    </tr>
</table>
<br>
<table style="font-size:9pt;">
    <tr>
        <td>DIVISI</td>
        <td width="10%">:</td>
        <td><?= strtoupper($divisi['nm_divisi']) ?></td>
    </tr>
    <tr>
        <td>SUB DIVISI</td>
        <td width="10%">:</td>
        <td><?= strtoupper($divisi_sub['nm_divisi_sub']) ?></td>
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
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="20%"><strong>KPI</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>SUB BOBOT</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="5%"><strong>SATUAN</td>
            <td rowspan="2" style="text-align:center;background-color:#d5d5e3;" width="4%"><strong>TARGET</td>
            <td colspan="12" style="text-align:center;background-color:#d5d5e3;" width="24%"><strong>TARGET BULAN</td>
            
        </tr>
        <tr>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>JAN</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>FEB</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>MAR</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>APR</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>MEI</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>JUN</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>JUL</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>AGT</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>SEP</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>OKT</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>NOV</td>
            <td style="text-align:center;background-color:#d5d5e3;" ><strong>DES</td>
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
            <td style="text-align:center;background-color:#FFCF81;"><strong>17</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>18</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>19</td>
            <td style="text-align:center;background-color:#FFCF81;"><strong>20</td>
        </tr>
    </thead>
    <tbody>
        <?php $total_sub_bobot = 0; $i = 1; foreach($perspektif as $per): ?>
            <?php 
                $span = 1;
                foreach($kpi as $k){
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
                    <?php foreach($kpi as $k): ?>
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
            <?php foreach($kpi as $k): ?>
                <?php if($k['id_perspektif'] == $per['id_perspektif']): ?>
                    <tr>
                        <td><?= $k['nm_kpi'] ?></td>
                        <td style="text-align: center;"><?= $k['sub_bobot'] ?>%</td>
                        <td style="text-align: center;"><?= $k['nm_satuan'] ?></td>
                        <td style="text-align: center;"><?= number_format($k['target'],2,",",".")?></td>
                        <td style="text-align: center;"><?= $k['bulan_1'] != null ? number_format($k['bulan_1'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_2'] != null ? number_format($k['bulan_2'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_3'] != null ? number_format($k['bulan_3'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_4'] != null ? number_format($k['bulan_4'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_5'] != null ? number_format($k['bulan_5'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_6'] != null ? number_format($k['bulan_6'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_7'] != null ? number_format($k['bulan_7'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_8'] != null ? number_format($k['bulan_8'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_9'] != null ? number_format($k['bulan_9'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_10'] != null ? number_format($k['bulan_10'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_11'] != null ? number_format($k['bulan_11'],2,",",".") : "" ?></td>
                        <td style="text-align: center;"><?= $k['bulan_12'] != null ? number_format($k['bulan_12'],2,",",".") : "" ?></td>
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
            <td colspan="14"></td>
        </tr>
    </tbody>
</table>
<br>
<!-- <div style="margin-left: 10%; margin-right:10%">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <p style="font-size: 10pt;">Disusun Oleh</p>
            <img width="80" height="80" src="" alt="" />
            <p style="font-size: 10pt;"><?= strtoupper($user['contents']) ?></p>
          </div>
        </div>
        <div>
          <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <p style="font-size: 10pt;">Disetujui Oleh</p>
            <img width="80" height="80" src="" alt="" />
            <p style="font-size: 10pt;"><?= strtoupper($user['atasan']) ?></p>
          </div>
        </div>
      </div>
</div> -->
    