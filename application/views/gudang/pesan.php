<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title ?></b></h3>
	</div>
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
								<td>
                                    <?php if($value->status == 'proses'): ?>
                                        <a href="<?= base_url('gudang/pesan/kirim/'.$value->id_pesanan) ?>" class="badge badge-warning kirim">Proses</a>
                                    <?php elseif($value->status == 'dikirim'): ?>
                                        <span class="badge badge-info">Dikirim</span>
                                    <?php elseif($value->status == 'selesai'): ?>
                                        <span class="badge badge-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
   document.querySelectorAll('.kirim').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Kirim Barang?",
                text: "Barang akan dikirim, dan stok barang pada gudang akan di perbarui!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Kirim"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });
</script>