<?= $this->extend('templates/auth'); ?>
<?= $this->section('content'); ?>

<!-- Row -->
<div class="row flex-grow">
    <div class="col-lg-6 d-flex align-items-center justify-content-center">
        <div class="auth-form-transparent text-left p-1">
            <div class="brand-logo">
            </div>
            <h2 class="mb-3">Login</h2>
            <h5 class="fw-normal mb-3">Masuk untuk BerSedekah</h5>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('sukses'); ?>
                </div>
            <?php endif; ?>

            <form class="user needs-validation" action="<?= base_url('auth/login'); ?>" method="POST" novalidate>
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label class="sr-only" for="username">Username</label>
                    <div class="input-group validate-input">
                        <div class="input-group-append">
                            <span class="input-group-text" style="height: 50px;">
                                <i class="mdi mdi-account-outline mdi-18px text-primary"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" aria-describedby="Username" placeholder="Username" value="<?= old('username') ?>" required="" autofocus>
                        <div class="invalid-feedback">
                            Username belum diisi
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <div class="input-group validate-input">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="height: 50px;">
                                <i class="mdi mdi-lock-outline mdi-18px text-primary"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required="">
                        <div class="invalid-feedback">
                            Password belum diisi
                        </div>
                    </div>
                </div>

                <button class="btn btn-block btn-success btn-lg font-weight-medium text-light" style="font-size: 18px;">
                    Login
                </button>
            </form>
            
            <hr />

            <div class="text-center mt-4 font-weight-light">
                Kembali ke <a href="<?= base_url('/'); ?>"> Home</a> &bull;
                Tidak punya akun? <a href="<?= base_url('/register'); ?>" class="text-primary">Register</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 login-half-bg d-none d-lg-flex flex-row">
        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; <?= date('Y') ?> Sedekah Receh Official. All rights reserved.</p>
    </div>
</div>



<?= $this->endSection(); ?>