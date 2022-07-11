<h1 class="h2 mb-3"><?= $title; ?></h1>
<div class="card">
    <div class="card-body">

        <a href="javascript:void(0);" id="tambah" class="btn btn-primary mb-4 btnTambah"><i class="mdi mdi-plus"></i> Tambah Data</a>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive" id="table">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfToken" />
            <table class="table" cellspacing="0" width="100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col" width="30%">Jawaban</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>