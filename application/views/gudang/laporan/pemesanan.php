<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title ?></b></h3>
	</div>
    <a class="btn btn-sm btn-success mb-3" href="<?= base_url('gudang/laporan/cetak_pemesanan') ?>" target="_blank"><i class="fas fa-print fa-sm"></i> Cetak</a>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
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
		</div>
	</div>
</div>