<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3"><?= $title; ?></h1>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('user'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <?= form_open_multipart('/user/update/' . $auth['id'] . '', 'class="#"'); ?>
        <?= csrf_field(); ?>
        <!-- <input type="hidden" name="passwordLama" value="<?= $auth['password']; ?>"> -->
        <input type="hidden" name="fotoLama" value="<?= $auth['foto']; ?>">
        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" placeholder="Nama Lengkap" autofocus value="<?= (old('nama')) ? old('nama') : $auth['nama'] ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama'); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user" name="username" placeholder="Username" value="<?= (old('username')) ? old('username') : $auth['username'] ?>" readonly>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>
        <!-- <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control form-control-user" name="password" placeholder="Password" value="<?= (old('password')) ? old('password') : $auth['password'] ?>">
                <div class="invalid-feedback">
                </div>
            </div>
        </div> -->
        <div class="row mb-3">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user" name="alamat" placeholder="Alamat" value="<?= (old('alamat')) ? old('alamat') : $auth['alamat'] ?>">
                <div class="invalid-feedback">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="rt" class="col-sm-2 col-form-label">RT/RW</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control form-control-user" name="rt" placeholder="RT" value="<?= (old('rt')) ? old('rt') : $auth['rt'] ?>">
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-user" name="rw" placeholder="RW" value="<?= (old('rw')) ? old('rw') : $auth['rw'] ?>">
                        <div class="invalid-feedback">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="saldo" class="col-sm-2 col-form-label">Saldo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-user" name="saldo" placeholder="Saldo" value="<?= (old('saldo')) ? old('saldo') : $auth['saldo'] ?>" readonly>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <?php if ($auth['foto'] != 'profile.png') { ?>
                    <img src="<?= base_url() ?>/<?= $auth['foto']; ?>" width="100" alt="Foto profil" class="border border-3 rounded-circle mb-2">
                <?php } else { ?>
                    <img src="<?= base_url('/images/photos/profile.png') ?>" width="100" alt="Foto profil" class="border border-3 rounded-circle mb-2">
                <?php } ?>
                <img id='output' class="rounded-circle mb-2" style="width: 100px;">
                <div class="custom-file">
                    <input type="file" class="form-control form-control-user <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto" onchange="readFoto(event)">
                    <div class="form-text">Format Foto jpg/jpeg/png</div>
                    <div class="invalid-feedback">
                        <?= $validation->getError('foto'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary btn-user btn-block center-block" onclick="return confirm('Anda akan diarahkan untuk login ulang, klik OK untuk melanjutkan?')">
                    <i class="mdi mdi-content-save mdi-18px"></i> Update
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