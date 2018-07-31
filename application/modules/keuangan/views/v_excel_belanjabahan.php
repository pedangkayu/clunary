<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Laporan_BelanjaBahan.xls");
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
                <th>Tanggal</th>                        
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_harga_semua = 0;
                foreach ($belanjabahan->result() as $d) {
                    $i++;
                    $total_harga_semua += $d->total_harga;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('d M Y',strtotime($d->tgl_update))?></td>
                        <td><?php echo $d->nama_bahan?></td>
                        <td><?php echo '<div align="right">'.number_format($d->qty, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->harga, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_harga, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5">Total</td>
                    <td><?php echo '<div align="right">'.number_format($total_harga_semua, 2, ',', '.').'</div>'?></td>
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
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Total</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_harga_semua = 0;
                foreach ($belanjabahan->result() as $d) {
                    $i++;
                    $total_harga_semua += $d->total_harga;
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo date('M Y',strtotime($d->tgl_update))?></td>
                        <td><?php echo $d->nama_bahan?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_qty, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_harga, 2, ',', '.').'</div>'?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="4">Total</td>
                    <td><?php echo '<div align="right">'.number_format($total_harga_semua, 2, ',', '.').'</div>'?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</body>
</html>				