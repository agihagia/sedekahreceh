<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3"><?= $title; ?> <?= $auth['username']; ?></h1>

<div class="card ">
    <div class="card-header">
        <a href="<?= base_url('akun'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <?= form_open_multipart('/akun/reset_pass/' . $auth['id'] . '', 'class="#"'); ?>
        <?= csrf_field(); ?>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
            <div class="col-sm-10">
                <input type="password" class="form-control form-control-user <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password Baru" value="">
                <div class="invalid-feedback">
                <?= $validation->getError('password'); ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary btn-user btn-block center-block">
                <i class="mdi mdi-lock-reset"></i> Simpan Password
                </button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection('content'); ?>