<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title ?></b></h3>
	</div>
	<button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm"></i> Tambah</button>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No.</th>
							<th class="text-center">ID Distribusi</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Nama Barang</th>
							<th class="text-center">Jumlah Barang</th>
							<th class="text-center">Tanggal Pesan</th>
							<th class="text-center">Status</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($distribusi as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_distribusi ?></td>
								<td><?= $value->nm_pengguna ?></td>
								<td><?= $value->nm_barang ?></td>
								<td><?= $value->jml_distribusi ?></td>
								<td><?= do_formal_date($value->tgl_distribusi) ?></td>
								<td>
                                    <?php if($value->status == 'proses'): ?>
                                        <span class="badge badge-warning">Proses</span>
                                        <?php elseif($value->status == 'dikirim'): ?>
                                            <a href="<?= base_url('gudang/distribusi/terima/'.$value->id_distribusi) ?>" class="badge badge-info terima">Diterima</a>
                                    <?php elseif($value->status == 'selesai'): ?>
                                        <span class="badge badge-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 30px;">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php if($value->status == 'proses'): ?>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#edit<?= $value->id_distribusi ?>"><i class="fas fa-edit"></i> Edit</button>
                                            <?php endif; ?>
                                            <a class="dropdown-item text-danger hapus" href="<?= base_url('gudang/distribusi/delete/'.$value->id_distribusi) ?>"><i class="fas fa-trash"></i> Hapus</a>
                                        </div>
                                    </div>
                                </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Distribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/distribusi/add') ?>" method="post" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>Nama Barang</label>
        		<select name="id_barang" id="id_barang" class="form-control" required>
                    <option value="">Pilih Barang</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b->id_barang ?>"><?= $b->nm_barang ?></option>
                        <?php endforeach; ?>
                </select>
                <?= form_error('id_barang', '<div class="text-danger small ml-3">', '</div>') ?>
            </div>
            <div class="form-group">
                <label>Jumlah Barang</label>
                <input type="number" name="jml_distribusi" id="jml_distribusi" class="form-control" required>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Pesan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php foreach ($distribusi as $value): ?>
<div class="modal fade" id="edit<?= $value->id_distribusi ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Distribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/distribusi/edit/'.$value->id_distribusi) ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id_barang">Nama Barang</label>
            <select name="id_barang" id="id_barang" class="form-control" required>
              <option value="">Pilih Barang</option>
              <?php foreach ($barang as $b): ?>
                <option value="<?= $b->id_barang ?>" <?= ($value->id_barang == $b->id_barang) ? 'selected' : '' ?>>
                  <?= $b->nm_barang ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?= form_error('id_barang', '<div class="text-danger small ml-3">', '</div>') ?>
          </div>
          <div class="form-group">
            <label for="jml_distribusi">Jumlah Barang</label>
            <input type="number" name="jml_distribusi" id="jml_distribusi" class="form-control" value="<?= $value->jml_distribusi ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Pesan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>


<script>
   document.querySelectorAll('.hapus').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Hapus Data?",
                text: "Data yang sudah dihapus tidak dapat dipulihkan kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });

   document.querySelectorAll('.terima').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Konfirmasi?",
                text: "Jika barang sudah diterima, silahkan klik terima!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Terima"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });
</script>