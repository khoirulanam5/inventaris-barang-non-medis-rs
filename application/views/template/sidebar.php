<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center m-4" href="">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-hospital fa-2x text-light"></i>
                </div>
                <div class="sidebar-brand-text ml-2">RS <br><small>Aisyiyah Kudus</small></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php if($this->session->userdata('level') == 'staf gudang'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'user') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/user') ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'barang') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/barang') ?>">
                        <i class="fas fa-box"></i>
                        <span>Barang</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'kategori') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/kategori') ?>">
                        <i class="fas fa-fw fa-boxes"></i>
                        <span>Kategori Barang</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'stok') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/stok') ?>">
                        <i class="fas fa-warehouse"></i>
                        <span>Stok Barang</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'pesan') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/pesan') ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pesanan (UNIT)</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'distribusi') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('gudang/distribusi') ?>">
                        <i class="fas fa-truck"></i>
                        <span>Distribusi Pemasok</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                        aria-expanded="true" aria-controls="collapseLaporan">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= base_url('gudang/laporan') ?>">Laporan Pesanan</a>
                            <a class="collapse-item" href="<?= base_url('gudang/laporan/distribusi') ?>">Laporan Distribusi</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($this->session->userdata('level') == 'staf unit'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'unit') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('unit/unit') ?>">
                        <i class="fas fa-building"></i>
                        <span>Unit</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'pesan') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('unit/pesan') ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pesan Barang</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'riwayat') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('unit/riwayat') ?>">
                        <i class="fas fa-file-alt"></i>
                        <span>Riwayat Pesan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if($this->session->userdata('level') == 'pemasok'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'distribusi') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('pemasok/distribusi') ?>">
                        <i class="fas fa-truck"></i>
                        <span>Permintaan Barang</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="navbar">

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <ul class="nav navbar-nav navbar-right">

                            <div class="sidebar-brand-text ml-2">
                                <p class="d-inline"><?= $this->session->userdata('level') ?></p>
                            </div>
                            <a class="btn btn-default btn-sm logout ml-3" href="<?= base_url('auth/logout') ?>">
                                <i class="fas fa-fw fa-power-off"></i>
                            </a>

                            </ul>

                        </div>
                    </ul>

                </nav>

                <script>
                document.querySelectorAll('.logout').forEach(item => {
                        item.addEventListener('click', function(e) {
                            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
                            var url = this.getAttribute('href'); // Ambil URL dari atribut href
                            Swal.fire({
                                title: "Yakin Ingin Keluar?",
                                text: "",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Keluar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika konfirmasi, redirect ke URL penghapusan
                                    window.location.href = url;
                                }
                            });
                        });
                    });
                </script>