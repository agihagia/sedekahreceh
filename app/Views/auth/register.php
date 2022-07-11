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
                    <div class="row">
                        <div class="col">
                            <label for="jenis" class="col-form-label">Username</label>
                            <input type="text" class="form-control form-control-lg <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" placeholder="Username" value="<?= old('username'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                             <label for="jenis" class="col-form-label">Password</label>
                            <input type="password" class="form-control form-control-lg <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password" value="<?= old('password'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password'); ?>
                            </div>
                        </div>
                        <div class="col">
                             <label for="jenis" class="col-form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg <?= ($validation->hasError('confirm_password')) ? 'is-invalid' : ''; ?>" name="confirm_password" placeholder="Confirm Password" value="<?= old('confirm_password'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirm_password'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                     <div class="col">
                     <label for="jenis" class="col-form-label">Nama Lengkap</label>
                    <input type="text" class="form-control form-control-lg <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" placeholder="Nama Lengkap" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                        </div>
                        <div class="col">
                        <label for="jenis" class="col-form-label">Jenis Kelamin</label>
                             <select name="gender[]" id="gender" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div class="mb-3">
                <label for="jenis" class="col-form-label">email</label>
                    <input type="text" class="form-control form-control-lg <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" placeholder="email" value="<?= old('email'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                     <div class="col">
                     <label for="jenis" class="col-form-label">Tgl Lahir</label>
                        <input type="date" class="form-control form-control-lg <?= ($validation->hasError('tgl_lahir')) ? 'is-invalid' : ''; ?>" name="tgl_lahir" placeholder="Tgl Lahir" value="<?= old('tgl_lahir'); ?>">
                             <div class="invalid-feedback">
                                <?= $validation->getError('tgl_lahir'); ?>
                         </div>
                        </div>
                        <div class="col">
                        <label for="jenis" class="col-form-label">Whatsapp</label>
                            <input type="text" class="form-control form-control-lg <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" name="telp" placeholder="Whatsapp" value="<?= old('telp'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('telp'); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                    <label for="jenis" class="col-form-label">Instagram</label>
                        <input type="text" class="form-control form-control-lg <?= ($validation->hasError('instagram')) ? 'is-invalid' : ''; ?>" name="instagram" placeholder="instagram" value="<?= old('instagram'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('instagram'); ?>
                        </div>
                    </div>
                    <div class="col">
                    <label for="jenis" class="col-form-label">Telegram</label>
                        <input type="text" class="form-control form-control-lg <?= ($validation->hasError('telegram')) ? 'is-invalid' : ''; ?>" name="telegram" placeholder="Telegram" value="<?= old('telegram'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('telegram'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                <label for="jenis" class="col-form-label">Alamat</label>
                    <input type="text" class="form-control form-control-lg <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" placeholder="Alamat" value="<?= old('alamat'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                     <div class="col">
                     <label for="jenis" class="col-form-label">Provinsi</label>
                        <input type="text" class="form-control form-control-lg <?= ($validation->hasError('provinsi')) ? 'is-invalid' : ''; ?>" name="provinsi" placeholder="provinsi" value="<?= old('provinsi'); ?>">
                             <div class="invalid-feedback">
                                <?= $validation->getError('provinsi'); ?>
                         </div>
                        </div>
                        <div class="col">
                        <label for="jenis" class="col-form-label">Kota</label>
                            <input type="text" class="form-control form-control-lg <?= ($validation->hasError('kota')) ? 'is-invalid' : ''; ?>" name="kota" placeholder="Kab/Kota" value="<?= old('kota'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('kota'); ?>
                            </div>
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