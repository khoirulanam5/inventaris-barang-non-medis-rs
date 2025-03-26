<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
    body {
        margin: 10mm;
        font-family: Arial, sans-serif;
    }

    @media print {
        .no-print {
            display: none;
        }
    }

    .header-container {
        display: flex;
        align-items: center;
        margin-bottom: 5px; /* Kurangi margin agar lebih dekat */
        page-break-after: avoid; /* Hindari pemisahan header */
    }

    .header-logo {
        height: 100px;
    }

    .header-text {
        text-align: center;
        width: 100%;
    }

    hr {
        margin-top: 5px; /* Kurangi margin agar dekat dengan tabel */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px; /* Kurangi jarak tabel */
        page-break-before: avoid; /* Hindari tabel muncul di halaman baru */
        page-break-inside: auto; /* Biarkan tabel terbagi jika terlalu panjang */
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        font-size: 12px;
    }

    @media print and (orientation: portrait) {
        th, td {
            font-size: 10px;
            padding: 5px;
        }
    }

    .signature {
        margin-top: 30px;
        text-align: right;
        page-break-inside: avoid; /* Hindari tanda tangan terpotong */
    }

    @media print {
        .header-container, table, .signature {
            page-break-after: avoid; /* Hindari elemen terpisah */
        }
    }
</style>
</head>
<body>
    <div class="print-container">
        <!-- Header Section -->
        <div class="header-container">
            <div>
                <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" class="header-logo">
            </div>
            <div class="header-text">
                <h2><b>RS. Aisyiyah Kudus</b></h2>
                <p>Alamat: Jl. Hos Cokroaminoto No.248, Mlati Norowito, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah<br>
                   No. Telp: 0812-6167-1916
                </p>
            </div>
        </div>
        <hr style="border: 2px solid black;">

        <!-- Content Section -->
        <h3 style="text-align: center;">DATA KIRIM BARANG KE UNIT</h3>
        <table class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No.</th>
							<th class="text-center">ID Pesanan</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Nama Barang</th>
							<th class="text-center">Nama Unit</th>
							<th class="text-center">Jumlah Barang</th>
							<th class="text-center">Tanggal Pesan</th>
							<th class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($pesanan as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_pesanan ?></td>
								<td><?= $value->nm_pengguna ?></td>
								<td><?= $value->nm_barang ?></td>
								<td><?= $value->nm_unit ?></td>
								<td><?= $value->jml_pesan ?></td>
								<td><?= do_formal_date($value->tgl_pesanan) ?></td>
								<td><?= $value->status ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
    </div>
    
    <!-- Signature Section -->
    <div class="signature">
        <p>Kudus, <?= date('d F Y'); ?></p>
        <p><b>Staff Gudang</b></p>
        <br><br><br>
        <div>
            <p><b><u>Sheila</u></b></p>
        </div>
    </div>
    
    <script>
        window.print();
    </script>
</body>
</html>
