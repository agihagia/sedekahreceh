<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3"><?= $title; ?></h1>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('akun'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <?= form_open_multipart('/akun/save_register', 'class="#"'); ?>
        <?= csrf_field(); ?>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" placeholder="Nama Lengkap" value="<?= old('nama'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama'); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" placeholder="Username" value="<?= old('username'); ?>">
                <div class="invalid-feedback">
                <?= $validation->getError('username'); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control form-control-user <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password" value="<?= old('password'); ?>">
                <div class="invalid-feedback">
                <?= $validation->getError('password'); ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" placeholder="Alamat" value="<?= old('alamat'); ?>">
                <div class="invalid-feedback">
                <?= $validation->getError('alamat'); ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="rt" class="col-sm-2 col-form-label">RT/RW</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control form-control-user <?= ($validation->hasError('rt')) ? 'is-invalid' : ''; ?>" name="rt" placeholder="RT" value="<?= old('rt'); ?>">
                        <div class="invalid-feedback">
                        <?= $validation->getError('rt'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-user <?= ($validation->hasError('rw')) ? 'is-invalid' : ''; ?>" name="rw" placeholder="RW" value="<?= old('rw'); ?>">
                        <div class="invalid-feedback">
                        <?= $validation->getError('rw'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
            <img src="<?= base_url('/images/photos/profile.png') ?>" width="100" alt="Foto profil" class="border border-3 rounded-circle mb-2">
            <img id='output' class="rounded-circle mb-2" style="width: 100px;">
                <div class="custom-file">
                    <input type="file" class="form-control form-control-user <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto" onchange="readFoto(event)">
                    <div class="invalid-feedback">
                        <?= $validation->getError('foto'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary btn-user btn-block center-block">
                <i class="mdi mdi-content-save mdi-18px"></i> Simpan
                </button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= $this->endSection('content'); ?>

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