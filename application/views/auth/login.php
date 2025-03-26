<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets/logo.png') ?>" alt="Logo RS Aisyiyah Kudus" class="mb-3" style="width: 100px; height: auto;">
                                        <h1 class="h4 text-gray-900 mb-1">RS Aisyiyah Kudus</h1>
                                        <small class="text-gray-900 mb-2">Alamat: Jl. Hos Cokroaminoto No.248, Mlati Norowito, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah</small>
                                    </div>
                                    <br>
                                    <?= $this->session->flashdata('pesan') ?>
                                    <form method="post" action="<?= base_url('auth/login') ?>">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Masukan Username Anda..." name="username" style="border-radius: 30px;">
                                            <?= form_error('username', '<div class="text-danger small ml-2">', '</div>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" placeholder="Masukan Password Anda..." name="password" style="border-radius: 30px;">
                                            <?= form_error('password', '<div class="text-danger small ml-2">', '</div>') ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary col-md-5" style="border-radius: 30px;">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
