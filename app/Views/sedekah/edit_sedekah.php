<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3"><?= $title; ?></h1>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('datasedekah'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <?= form_open_multipart('/sedekah/update/' . $sedekah['id'] . '', 'class="#"'); ?>
        <!-- form hanya bisa diinput lewat halaman ini saja -->
        <input type="hidden" name="slug" value="<?= $sedekah['slug']; ?>">
        <input type="hidden" name="sampulLama" value="<?= $sedekah['sampul']; ?>">

        <div class="row mb-3">
            <label for="sampul" class="col-sm-2 col-form-label">Foto Sampul</label>
            <div class="col-sm-6">
                <img src="<?= base_url(); ?>/images/sedekah/<?= $sedekah['sampul']; ?>" width="200" class="mb-3">
                <img id='output' style="width: 200px;margin-bottom: 1rem">
                <div class="custom-file">
                    <input type="file" class="form-control <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul" onchange="readFoto(event)">
                    <div class="invalid-feedback">
                        <?= $validation->getError('sampul'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?>" name="jenis" autofocus value="<?= (old('jenis')) ? old('jenis') : $sedekah['jenis'] ?>">
                <div id="validationServer04Feedback" class="invalid-feedback">
                    <?= $validation->getError('jenis'); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="rupiah" class="col-sm-2 col-form-label">rupiah</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rupiah" name="rupiah" value="<?= (old('rupiah')) ? old('rupiah') : $sedekah['rupiah'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="des" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="des" name="des" rows="3"><?= (old('des')) ? old('des') : $sedekah['des'] ?></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-3"><i class="mdi mdi-content-save"></i> Update</button>
        <?= form_close() ?>
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