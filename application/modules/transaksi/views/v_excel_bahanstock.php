<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Stock_Bahan.xls");
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
		<table id="table_inv" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
						<th>Bahan</th>                        
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Min Stock</th>
                        <th>Jumlah Stock</th>
                        <th>Status</th>
                      </tr>
                    </thead>                  
					<tbody>
					<?php $i=0; foreach ($bahanstock->result() as $d) {  $i++; ?>
						<tr>
							<td><?= $i?></td>
							<td><?= $d->nama_bahan?></td>
							<td><?= $d->satuan?></td>
                            <td><?= $d->harga_bahan?></td>
                            <td><?= $d->minimum_stock_alert?></td>
                            <td><?= $d->jml_stock?></td>
							<td><?= ($d->jml_stock <= $d->minimum_stock_alert) ? 'Kurang' : 'Aman'?></td>
						</tr>	
					<?php } ?>	
					</tbody>
		</table>
	</body>
</html>				