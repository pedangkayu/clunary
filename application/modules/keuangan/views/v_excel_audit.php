<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Laporan_Audit.xls");
?>
<html>
<head>
    <style>
        body {
            font-family: Arial;
        }
        table {
            border-collapse: collapse;
        }
        th {
            background-color: #cccccc;
        }
        th, td {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <?php
    if($jenis_laporan==1){ //harian
        ?>
        <table id="table_audit" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Open</th>                        
                <th>Close</th>
                <th>Pegawai</th>
                <th>Keterangan</th>
                <th>Uraian</th>
                <th>Nominal</th>
                <th>Total</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_saldo_akhir = 0;
                foreach ($audit->result() as $d) {
                    $i++;
                    $total_saldo_akhir += $d->saldo_akhir;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('d M Y',strtotime($d->date_submit)).' ('.date('H:i',strtotime($d->date_submit)).')'?></td>
                        <td><?php echo date('d M Y',strtotime($d->date_modify)).' ('.date('H:i',strtotime($d->date_modify)).')'?></td>
                        <td><?php echo $d->nama_lengkap.' ('.$d->kode_pegawai.')'?></td>
                        <td><?php echo 'Saldo Awal'?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->saldo_awal, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                    $data_detail = modules::run('keuangan/c_audit/get_data_audit_detail', $d->id_audit);
                    $total_transaksi = 0;
                    foreach ($data_detail->result() as $r) {
                        $total_transaksi += $r->total_trans;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Transaksi : '?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($total_transaksi, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                    foreach ($data_detail->result() as $r) {
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo '- '.$r->payment_method?></td>
                            <td><?php echo number_format($r->total_trans, 2, ',', '.')?></td>
                            <td></td>
                            <td></td>
                        </tr>     
                        <?php
                    }
                    ?>
                    <tr>
                       <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Saldo System'?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->saldo_system, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <tr>
                       <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Selisih'?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->selisih, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <tr>
                       <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Saldo Akhir'?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->saldo_akhir, 2, ',', '.').'</div>'?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5">Total Saldo Akhir</td>
                    
                    <td></td>
                    <td></td>
                    <td><?php echo '<div align="right">'.number_format($total_saldo_akhir, 2, ',', '.').'</div>'?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }else if($jenis_laporan==2){ //bulanan
        ?>
        <table id="table_audit" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Bulan</th>                        
                <th>Keterangan</th>
                <th>Uraian</th>
                <th>Nominal</th>
                <th>Total</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_saldo_akhir = 0;
                foreach ($audit->result() as $d) {
                    $i++;
                    $total_saldo_akhir += $d->total_akhir;
                    
                    $data_detail = modules::run('keuangan/c_audit/get_data_audit_detail_bulanan', $d->date_submit);
                    $total_transaksi = 0;
                    foreach ($data_detail->result() as $r) {
                        $total_transaksi += $r->total_trans;
                    }
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('M Y', strtotime($d->date_submit));?></td>
                        <td><?php echo 'Transaksi : '?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($total_transaksi, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                    foreach ($data_detail->result() as $r) {
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo '- '.$r->payment_method?></td>
                            <td><?php echo number_format($r->total_trans, 2, ',', '.')?></td>
                            <td></td>
                            <td></td>
                        </tr>     
                        <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Saldo System'?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_system, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Selisih'?></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_selisih, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo 'Saldo Akhir'?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_akhir, 2, ',', '.').'</div>'?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3">Total Saldo Akhir</td>
                    <td></td>
                    <td></td>
                    <td><?php echo '<div align="right">'.number_format($total_saldo_akhir, 2, ',', '.').'</div>'?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</body>
</html>				