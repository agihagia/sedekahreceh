<?= $this->extend('templates/auth'); ?>
<?= $this->section('content'); ?>

<div class="row w-100 mx-0 login-half-bg pt-5">
    <div class="col-lg-6 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
                <h3 class="mb-3"><?= $brand ?></h3>
            </div>
            <h2 class="mb-3">Register Akun</h2>
            <h5 class="fw-normal mb-3"></h5>

            <form action="<?= base_url(); ?>/auth/save_register" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="mb-3">

                    <input type="text" class="form-control form-control-lg <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" placeholder="Nama Lengkap" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control form-control-lg <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" placeholder="Username" value="<?= old('username'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control form-control-lg <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password" value="<?= old('password'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" placeholder="Alamat" value="<?= old('alamat'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat'); ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control form-control-lg <?= ($validation->hasError('rt')) ? 'is-invalid' : ''; ?>" name="rt" placeholder="RT" value="<?= old('rt'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('rt'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-lg <?= ($validation->hasError('rw')) ? 'is-invalid' : ''; ?>" name="rw" placeholder="RW" value="<?= old('rw'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('rw'); ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-10">
                            <div class="custom-file">
                                <input type="file" class="form-control form-control-user <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto" onchange="readFoto(event)">
                                <div class="form-text">Format Foto jpg/jpeg/png</div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('foto'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <img id='output' style="width: 50px;">
                        </div>
                    </div>
                </div>

                <br />

                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-success btn-user btn-block center-block text-light" style="font-size: 18px;">
                        Daftar
                    </button>
                </div>
            </form>

            <hr />

            <div class="text-center mt-3 font-weight-light">
                Sudah punya akun? <a href="<?= base_url('/login'); ?>" class="text-primary">Login</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    var readFoto = function(event) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('output');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    };
</script>
<?= $this->endSection(); ?>