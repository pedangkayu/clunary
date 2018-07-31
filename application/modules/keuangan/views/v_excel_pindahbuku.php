<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Laporan_PindahBuku.xls");
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
                <th>Tgl Transaksi</th>                        
                <th>Pegawai</th>
                <th>Sumber</th>
                <th>Tujuan</th>
                <th>Nominal (Rp)</th>
                <th>Selisih (Rp)</th>
                <th>Catatan</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                foreach ($pindahbuku->result() as $d) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('d M Y (H:i)',strtotime($d->date_pindahbuku))?></td>
                        <td><?php echo $d->nama_eksekutor;?></td>
                        <td><?php echo $d->source_reg;?></td>
                        <td><?php echo $d->destination_reg;?></td>
                        <td><?php echo '<div align="right">'.number_format($d->nominal_reg, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->selisih, 2, ',', '.').'</div>'?></td>
                        <td><?php echo $d->catatan;?></td>
                    </tr>
                    <?php
                }
                ?>
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
                <th>Saldo System</th>
                <th>Saldo Real</th>
                <th>Selisih</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_saldo_system = 0;
                $total_saldo_real = 0;
                $total_saldo_selisih = 0;
                foreach ($pendapatan->result() as $d) {
                    $i++;
                    $total_saldo_system += $d->total_system;
                    $total_saldo_real += $d->total_real;
                    $total_saldo_selisih += $d->total_selisih;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('M Y',strtotime($d->date_submit))?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_system, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_real, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_selisih, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="2">Total</td>
                    <td><?php echo '<div align="right">'.number_format($total_saldo_system, 2, ',', '.').'</div>'?></td>
                    <td><?php echo '<div align="right">'.number_format($total_saldo_real, 2, ',', '.').'</div>'?></td>
                    <td><?php echo '<div align="right">'.number_format($total_saldo_selisih, 2, ',', '.').'</div>'?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</body>
</html>				