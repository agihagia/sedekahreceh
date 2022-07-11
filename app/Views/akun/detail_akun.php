<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3">Detail Akun</h1>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <div class="text-center mb-3">
                    <?php if ($auth['foto'] != 'profile.png') { ?>
                        <img src="<?= base_url() ?>/<?= $auth['foto']; ?>" width="100" alt="Foto profil <?= $auth['username']; ?>" class="border border-3 rounded-circle mb-2">
                    <?php } else { ?>
                        <img src="<?= base_url('/images/photos/profile.png') ?>" width="100" alt="Foto profil <?= $auth['username']; ?>" class="border border-3 rounded-circle mb-2">
                    <?php } ?>
                    <h3><?= $auth['nama']; ?></h3>
                    <p class="text-muted text-center"><?= $auth['username']; ?><br />
                        <?= $auth['level']; ?></p>
                </div>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class='fas fa-coins text-warning'></i> Saldo</b> <a class="text-decoration-none float-end">Rp.<?= $auth['saldo']; ?></a>
                    </li>
                </ul>
                <div class="d-grid gap-2">
                    <button onclick="pilihTransaksi()" class="btn btn-primary"><i class="mdi mdi-swap-horizontal-bold"></i> Transaksi</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-4">
                Tentang <?= $auth['nama']; ?>
            </div>
            <div class="card-body">
                <h6><i class="mdi mdi-map-marker"></i> Alamat</h6>
                <p class="text-muted" style="font-size: 1rem;"><?= $auth['alamat']; ?> RT <?= $auth['rt']; ?> RW <?= $auth['rw']; ?></p>
                <hr />
                <h6><i class="mdi mdi-account-key"></i> Akun</h6>
                <a href="<?= base_url(); ?>/akun/reset/<?= $auth['username']; ?>"><i class="mdi mdi-lock-reset"></i> Reset Password</a>
                <hr />
                <div class="d-grid gap-2">
                <a href="<?= base_url('/akun/edit'); ?>/<?= $auth['username']; ?>" class="btn btn-warning"><i class="mdi mdi-account-edit"></i> Update</a>
                </div>
                <!-- <form action="/akun/<?//= $auth['id']; ?>" method="POST" class="d-inline">
                    <?//= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger text-white" onclick="return confirm('Apakah anda yakin menghapus data ini?')"><i class="mdi mdi-delete"></i>Hapus</button>
                </form> -->

            </div>
        </div>

    </div>

    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills pb-0">
                    <li class="nav-item"><a class="nav-link active" href="#transaksi" data-bs-toggle="tab"><i class="mdi mdi-swap-horizontal-bold mdi-18px"></i> Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#aktivitas" data-bs-toggle="tab"><i class="mdi mdi-format-list-checks mdi-18px"></i> Aktivitas</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="transaksi">
                        <?php if (!empty($transaksi)) { ?>
                            <div class="postList">
                                <?php foreach ($transaksi as $row) { ?>
                                    <?php $postID = $row['id']; ?>
                                    <?php if ($row['status_transaksi'] == '1') {
                                        $status = "<span class=\"text-success\">Selesai</span>";
                                    } else {
                                        $status = "<span class=\"text-success\">Tertunda</span>";
                                    } ?>
                                    <div class="list_item my-4">
                                        <h6 class="text-secondary"><?= date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></h6>
                                        <p>No.Trans: <?= $row['no_transaksi']; ?><span class="float-end"><?= $status; ?></span></p>
                                        <h5><i class="mdi mdi-swap-horizontal-bold mdi-24px <?php if ($row['jenis_transaksi'] == 'masuk') {
                                            echo "text-success";
                                            } else {
                                            echo "text-danger";
                                            }; ?>"></i> Transaksi: <?= $row['jenis_transaksi']; ?>
                                            <span class="float-end">Rp.<?= $row['total_rupiah']; ?></span>
                                        </h5>
                                    </div>
                                    <hr />
                                <?php } ?>
                                <div class="show_more_main" id="show_more_main<?= $postID; ?>">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
                                    <span id="<?= $postID; ?>" class="show_more" title="Load more posts">Load more</span>
                                    <span class="loding" style="display: none;"><i class="fa fa-circle-notch fa-spin"></i> <span class="loding_txt">Loading...</span></span>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="text-center">
                                <img src="<?= base_url('/images/no_data_found.png'); ?>" class="img-fluid" width="400" alt="">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="aktivitas">

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script') ?>
<script>
    function pilihTransaksi() {
        Swal.fire({
            icon: 'question',
            title: 'Pilih Jenis Transaksi',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Setor sedekah',
            denyButtonText: 'Tarik Saldo',
            cancelButtonText: 'Batal'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.href = "<?= base_url(); ?>/transaksi/setor/<?= $auth['id'] ?>";
            } else if (result.isDenied) {
                location.href = "<?= base_url(); ?>/transaksi/tarik/<?= $auth['id'] ?>";
            }
        })
    }
</script>
<script>
    var baseUrl = '<?= base_url(); ?>';

    $(document).ready(function() {
        $(document).on('click', '.show_more', function() {
            var ID = $(this).attr('id');
            var idUser = "<?= $auth['id'] ?>";
            var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
            var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
            $('.show_more').hide();
            $('.loding').show();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/akun/loadmore',
                data: {
                    id: ID,
                    id_user: idUser,
                    [csrfName]: csrfHash
                },
                success: function(html) {
                    $('#show_more_main' + ID).remove();
                    $('.postList').append(html);
                }
            });
        });
    })
</script>
<?= $this->endSection('script'); ?>