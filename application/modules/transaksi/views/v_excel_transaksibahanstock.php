<?php 
	header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=Transaksi.xls");
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
						<th>Tgl Update</th>
                        <th>Kode Perubahan</th>
                        <th>Perubahan</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>                  
					<tbody>
					<?php $i=0; foreach ($inventorybahan->result() as $d) {  $i++; ?>
						<tr>
							<td><?= $i?></td>
							<td><?= $d->nama_bahan?></td>
							<td><?= $d->satuan?></td>
							<td><?= date('d M Y',strtotime($d->tgl_update)).' ('.date('H:i',strtotime($d->tgl_update)).')'?></td>
                            <td><?= $d->jenis_perubahan?></td>
                            <td><?= $d->perubahan?></td>
							<td><?= $d->qty?></td>
						</tr>	
					<?php } ?>	
					</tbody>
		</table>
	</body>
</html>				