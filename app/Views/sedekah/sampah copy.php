<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3">Daftar sedekah</h1>

<div class="card">
<div class="card-body">
    <div class="col">
        <div class="row">
            <div class="col-sm-6">
                <a href="<?= base_url(); ?>/sedekah/create" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="col-sm-6">
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan keyword pencarian.." name="keyword">
                        <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit"><i class="mdi mdi-magnify mdi-24px"></i></button>
                    </div>
                </form>
            </div>

        </div>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('del')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('del'); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
            <table class="table" cellspacing="0" width="100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">rupiah(Rp/Kg)</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">rupiah(Rp/Kg)</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php $i = 1; ?> -->
                <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                <?php foreach ($sedekah as $sh) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><img src="/img/<?= $sh['sampul']; ?>" alt="" class="fsedekah"></td>
                        <td><?= $sh['jenis']; ?></td>
                        <td><?= $sh['rupiah']; ?></td>
                        <td><a href="<?= base_url(); ?>/sedekah/<?= $sh['slug']; ?>" class="btn bg-primary btn-sm text-white"><i class="mdi mdi-eye"></i> Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links('sedekah', 'sedekah_pagination'); ?>
    </div>
</div>
</div>

</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
        var table = $('#datatable').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }).DataTable({
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            'destroy': true,
            'responsive': true,
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': '<?= base_url('sedekah/listdata'); ?>',
                'type': 'POST',
                "data": {
                    <?= csrf_token() ?>: $('input[name=<?= csrf_token() ?>]').val(),
                },
                "data": function(data) {
                    data.<?= csrf_token() ?> = $('input[name=<?= csrf_token() ?>]').val()
                },
                "dataSrc": function(response) {
                    $('input[name=<?= csrf_token() ?>]').val(response.<?= csrf_token() ?>);
                    return response.data;
                },
            },
            'columnDefs': [{
                'targets': [0, 4], //sesuaikan kolom yang tidak mau di sort
                'orderable': false
            }, ],
        })

        $('.tooltip').not(this).tooltip('hide');
    })

</script>
<?= $this->endSection('script'); ?>