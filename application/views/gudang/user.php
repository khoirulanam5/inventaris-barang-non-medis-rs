<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title?></b></h3>
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
							<th class="text-center">ID User</th>
							<th class="text-center">Nama</th>
							<th class="text-center">No.Telp</th>
							<th class="text-center">Email</th>
							<th class="text-center">Alamat</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Status</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($user as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_user ?></td>
								<td><?= $value->nm_pengguna ?></td>
								<td><?= $value->no_hp ?></td>
                                <td><?= $value->email ?></td>
                                <td><?= $value->alamat ?></td>
                                <td><?= $value->username ?></td>
                                <td><?= $value->level ?></td>
                                <td>
                                <?php if ($value->status == '0'): ?>
                                    <span class="badge bg-warning" style="color: white;">Non Aktif</span>
                                <?php elseif ($value->status == '1'): ?>
                                    <span class="badge bg-success" style="color: white;">Aktif</span>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php if($value->status == '0'): ?>
                                                <a class="dropdown-item aktivasi" href="<?= base_url('gudang/user/aktivasi/'.$value->id_user) ?>"><i class="fas fa-check"></i> Aktivasi</a>
                                            <?php elseif($value->status == '1'): ?>
                                                <a class="dropdown-item nonaktivasi" href="<?= base_url('gudang/user/nonaktivasi/'.$value->id_user) ?>"><i class="fas fa-user-slash"></i> Nonaktifkan</a>
                                            <?php endif; ?>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#edit<?= $value->id_user ?>"><i class="fas fa-edit"></i> Edit</button>
                                            <a class="dropdown-item text-danger hapus" href="<?= base_url('gudang/user/delete/'.$value->id_user) ?>"><i class="fas fa-trash"></i> Hapus</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/user/add') ?>" method="post" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>Nama</label>
        		<input type="text" name="nm_pengguna" id="nm_pengguna" class="form-control" required>
                <?= form_error('nm_pengguna', '<div class="text-danger small ml-3">', '</div>') ?>
        	</div>
        	<div class="form-group">
        		<label>No.Telp</label>
        		<input type="number" name="no_hp" id="no_hp" class="form-control" required>
                <?= form_error('no_hp', '<div class="text-danger small ml-3">', '</div>') ?>
        	</div>
        	<div class="form-group">
        		<label>Email</label>
        		<input type="email" name="email" id="email" class="form-control" required>
                <?= form_error('email', '<div class="text-danger small ml-3">', '</div>') ?>
        	</div>
            <div class="form-group">
        		<label>Username</label>
        		<input type="text" name="username" id="username" class="form-control" required>
                <?= form_error('username', '<div class="text-danger small ml-3">', '</div>') ?>
        	</div>
            <div class="form-group">
        		<label>Password</label>
        		<input type="password" name="password" id="password" class="form-control" required>
                <?= form_error('password', '<div class="text-danger small ml-3">', '</div>') ?>
        	</div>
            <div class="form-group">
                <label>Jabatan</label>
                <select name="level" class="form-control" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="staf gudang">Staf Gudang</option>
                    <option value="staf unit">Staf Unit</option>
                    <option value="pemasok">Pemasok</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" required>
                <?= form_error('alamat', '<div class="text-danger small ml-3">', '</div>') ?>
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

<?php foreach ($user as $value): ?>
<div class="modal fade" id="edit<?= $value->id_user ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gudang/user/edit/'.$value->id_user) ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nm_pengguna" id="nm_pengguna" class="form-control" value="<?= $value->nm_pengguna ?>" required>
                    <?= form_error('nm_pengguna', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label>No.Telp</label>
                    <input type="number" name="no_hp" id="no_hp" class="form-control" value="<?= $value->no_hp ?>" required>
                    <?= form_error('no_hp', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $value->email ?>" required>
                    <?= form_error('email', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $value->username ?>" required>
                    <?= form_error('username', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="<?= $value->password ?>" required>
                    <?= form_error('password', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="level" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        <option value="staf gudang" <?= ($value->level == 'staf gudang') ? 'selected' : '' ?>>Staf Gudang</option>
                        <option value="staf unit" <?= ($value->level == 'staf unit') ? 'selected' : '' ?>>Staf Unit</option>
                        <option value="pemasok" <?= ($value->level == 'pemasok') ? 'selected' : '' ?>>Pemasok</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $value->alamat ?>" required>
                    <?= form_error('alamat', '<div class="text-danger small ml-3">', '</div>') ?>
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
<script>
   document.querySelectorAll('.aktivasi').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Aktivasi Akun?",
                text: "Akun akan di aktivasi sehingga pengguna dapat login ke sistem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aktivasi"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });
</script>
<script>
   document.querySelectorAll('.nonaktivasi').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Nonaktifkan Akun?",
                text: "Akun akan dinonaktifkan sehingga pengguna tidak dapat login ke sistem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Nonaktifkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });
</script>