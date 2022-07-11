<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3"><?= $title; ?></h1>

<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <div class="row mb-4">
            <div class="col-sm-6">
                <a href="<?= base_url(); ?>/akun/register" class="btn btn-primary"><i class="mdi mdi-account-plus"></i> Tambah Data</a>
            </div>
            <div class="col-sm-6">
              
            </div>
        </div>
        <div class="table-responsive">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
            <table class="table" cellspacing="0" width="100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Saldo(Rp)</th>
                        <th scope="col" width="10%">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
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
                'url': '<?= base_url('user/listdata'); ?>',
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

    function nonActive(id) {
        var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
        var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url('akun/user/toggle'); ?>",
            data: {
                id: id,
                [csrfName]: csrfHash
            },
            success: function(response) {
                if (response == 'sukses') {
                    let timerInterval;
                    Swal.fire({
                        icon: 'success',
                        title: 'Perubahan status berhasil',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((res) => {
                        if (res.dismiss === Swal.DismissReason.timer)
                            window.location.reload(true)
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function active(id) {
        var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
        var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url('akun/user/toggle'); ?>",
            data: {
                id: id,
                [csrfName]: csrfHash
            },
            success: function(response) {
                if (response == 'sukses') {
                    let timerInterval;
                    Swal.fire({
                        icon: 'success',
                        title: 'Perubahan status berhasil',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((res) => {
                        if (res.dismiss === Swal.DismissReason.timer)
                            window.location.reload(true)
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function pilihTransaksi(e) {
        const id = $(e).data('id')
        Swal.fire({
            icon: 'question',
            title: 'Pilih Jenis Transaksi',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Setor sedekah',
            denyButtonText: 'Request Penyaluran',
            cancelButtonText: 'Batal'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.href = "<?= base_url(); ?>/transaksi/setor/" + id;
            } else if (result.isDenied) {
                location.href = "<?= base_url(); ?>/transaksi/tarik/" + id;
            }
        })
    }
</script>
<?= $this->endSection('script'); ?>