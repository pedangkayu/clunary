<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Laporan_Cost_Menu.xls");
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
        <b>Tanggal <?php echo date('d M Y', strtotime($tgl_open));?></b> (Diunduh pada: <?php echo date('d M Y H:i', strtotime($datetime_now))?>)<br>
        <table id="table_audit" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Perusahaan</th>                        
                <th>Menu</th>
                <th>Harga</th>
                <th>Cost Menu</th>
                <th>Jml Penjualan</th>
                <th>Pendapatan Kotor</th>
                <th>Total Cost</th>
              </tr>
            </thead>                  
            <tbody>
                <?php
                $i=0;
                $total_cost_fonte = 0;
                $total_cost_suteki = 0;
                foreach ($cost_menu->result() as $d) {
                    $i++;
                    if($d->id_perusahaan==100){
                        $total_cost_fonte += $d->total_cost;
                    }elseif($d->id_perusahaan==127){
                        $total_cost_suteki += $d->total_cost;
                    }
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $d->nama_perusahaan?></td>
                        <td><?php echo $d->nama_menu?></td>
                        <td><?php echo '<div align="right">'.number_format($d->harga, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->cost_menu, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->jml_menu, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total, 2, ',', '.').'</div>'?></td>
                        <td><?php echo '<div align="right">'.number_format($d->total_cost, 2, ',', '.').'</div>'?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td>Cost Gundala</td>
                    <td><?php echo '<div align="right">'.number_format($total_cost_fonte, 2, ',', '.').'</div>'?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Cost Tenant</td>
                    <td><?php echo '<div align="right">'.number_format($total_cost_suteki, 2, ',', '.').'</div>'?></td>
                </tr>
            </tbody>
        </table>
       
</body>
</html>				