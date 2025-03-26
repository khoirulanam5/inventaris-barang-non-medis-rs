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
							<th class="text-center">ID Barang</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Kategori</th>
							<th class="text-center">Satuan</th>
							<th class="text-center">Foto</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($barang as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_barang ?></td>
								<td><?= $value->nm_barang ?></td>
								<td><?= $value->nm_kategori ?></td>
								<td><?= $value->satuan ?></td>
                                <td>
                                <?php if ($value->foto == NULL): ?>
                                    <span>Empty</span>
                                <?php elseif ($value->foto !== NULL): ?>
                                    <a href="<?= base_url('assets/barang/'.$value->foto) ?>" target="_blank">
                                        <img src="<?= base_url('assets/barang/'.$value->foto) ?>" alt="" style="height: 50px; width: 50px; object-fit: cover;">
                                    </a>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item" data-toggle="modal" data-target="#edit<?= $value->id_barang ?>"><i class="fas fa-edit"></i> Edit</button>
                                            <a class="dropdown-item text-danger hapus" href="<?= base_url('gudang/barang/delete/'.$value->id_barang) ?>"><i class="fas fa-trash"></i> Hapus</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/barang/add') ?>" method="post" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>Kategori</label>
        		<select name="id_kategori" id="id_kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k->id_kategori ?>"><?= $k->nm_kategori ?></option>
                        <?php endforeach; ?>
                </select>
                <?= form_error('id_kategori', '<div class="text-danger small ml-3">', '</div>') ?>
            </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nm_barang" id="nm_barang" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="foto" id="foto" accept="image/png, image/jpeg, image/jpg" class="form-control" required>
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php foreach ($barang as $b): ?>
<div class="modal fade" id="edit<?= $b->id_barang ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/barang/edit/'.$b->id_barang) ?>" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
              <option value="">Pilih Kategori</option>
              <?php foreach ($kategori as $k): ?>
                <option value="<?= $k->id_kategori ?>" <?= ($b->id_kategori == $k->id_kategori) ? 'selected' : '' ?>>
                  <?= $k->nm_kategori ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?= form_error('id_kategori', '<div class="text-danger small ml-3">', '</div>') ?>
          </div>

          <div class="form-group">
            <label for="nm_barang">Nama Barang</label>
            <input type="text" name="nm_barang" id="nm_barang" class="form-control" value="<?= $b->nm_barang ?>" required>
          </div>

          <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" value="<?= $b->satuan ?>" required>
          </div>

          <div class="form-group">
            <label>Foto</label><br>
            <?php if (!empty($b->foto)): ?>
              <img src="<?= base_url('assets/barang/' . $b->foto) ?>" alt="Foto Profil" class="img-thumbnail mb-2" width="150">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
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
</script>