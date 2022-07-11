<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<h1 class="h2 mb-3">Daftar Transaksi</h1>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-sm-6">
                <button data-bs-toggle="modal" data-bs-target="#rekapModal" class="btn btn-primary"><i class="fas fa-print"></i> Laporan PDF</button>
            </div>

            <div class="col-sm-6">

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
                        <th scope="col">No.Trans</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal modal-fade" id="detailModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Transaksi Setor</h5>
                <a class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> Cetak</a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Nama Anggota</h6>
                        <h6>Tanggal Transaksi</h6>
                    </div>
                    <div class="col">
                        <h6 id="namaNasabah"></h6>
                        <h6 id="tanggalTransaksi"></h6>
                    </div>
                </div>
                <table class="table" id="detailTable">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Berat (KG)</th>
                            <th>rupiah/KG</th>
                            <th>Total rupiah</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="text-end col pt-3">
                    <h6 id="totalTR"></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-fade" id="tarikModal">
    <div role="dialog" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Penarikan Saldo</h5>
                <a class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> Cetak</a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Nama Anggota</h6>
                        <h6>Tanggal Penarikan</h6>
                        <h6>Saldo Keluar Rp.</h6>
                    </div>
                    <div class="col">
                        <h6 id="namaNasabah"></h6>
                        <h6 id="tanggalTarik"></h6>
                        <h6 id="saldo"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-fade" id="rekapModal">
    <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content">
            <div class="modal-header">Rekap Transaksi</div>
            <div class="modal-body">
                <h5>Pilih Rentang Tanggal</h5>
                <form action="<?= base_url('/transaksi/rekap'); ?>" method="get">
                    <div class="form-group">
                        <label>Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control">
                    </div>
                    <div class="text-center form-group">
                        <button class="btn btn-outline-danger" type="submit"><i class="fas fa-file-pdf"></i> Cetak PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        show_data();
    })

    function show_data() {
        $('[data-bs-toggle="tooltip"]').tooltip();
        var table = $('#datatable').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }).DataTable({
            "lengthMenu": [
                [10, 20, -1],
                [10, 20, "All"]
            ],
            'destroy': true,
            'responsive': true,
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': '<?= base_url('transaksi/listdata'); ?>',
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
    }
</script>

<script>
    $('#detailModal').on('show.bs.modal', function(e) {
        var tombol = $(e.relatedTarget)
        var modal = $(this)
        //kosongkan tabel
        $('table#detailTable > tbody>tr').remove()
        modal.find('h6#namaNasabah').text(tombol.data('nama'))
        modal.find('h6#tanggalTransaksi').text(tombol.data('tanggal'))
        modal.find('#totalTR').text('Total Transaksi: Rp.' + tombol.data('total'))
        modal.find('a').attr('href', '<?= base_url(); ?>/transaksi/cetakTransaksi/' + tombol.data('id'))
        $.ajax({
            type: "GET",
            url: window.origin + "/transaksi/getDetail",
            data: {
                id_transaksi: tombol.data('id')
            },
            dataType: "text",
            success: function(response) {
                const data = JSON.parse(response);
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    $('table#detailTable > tbody').append(
                        `<tr>
                        <td>${element.jenis}</td>
                        <td>${element.berat}</td>
                        <td>${element.rupiah}</td>
                        <td>${element.rupiah_total}</td>
                    </tr>`
                    )

                }
            }
        });
    })
    $('#tarikModal').on('show.bs.modal', function(e) {
        var tombol = $(e.relatedTarget)
        var modal = $(this)
        modal.find('#namaNasabah').text(tombol.data('nama'))
        modal.find('#tanggalTarik').text(tombol.data('tanggal'))
        modal.find('#saldo').text(tombol.data('total'))
        modal.find('a').attr('href', '<?= base_url(); ?>/transaksi/cetakTransaksi/' + tombol.data('id'))
    })

    function hapus(e) {
        const id = $(e).data('id')
        Swal.fire({
            icon: 'error',
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin akan menghapus transaksi ini?',
            footer: 'Setelah dihapus, data tidak dapat dikembalikan!',
            showCancelButton: true
        }).then((res) => {
            Swal.showLoading()
            if (res.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/hapus') ?>",
                    data: {
                        id: id,
                        <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                    },
                    dataType: "text",
                    success: function(response) {
                        if (response == 'sukses') {
                            Swal.fire({
                                icon: 'success',
                                text: 'Data Berhasil dihapus'
                            }).then((res) => {
                                if (res.isConfirmed)
                                    window.location.reload(true)
                            })
                        }
                    }
                });
            }
        })
    }

    function proses(id) {
        var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
        var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Proses',
            text: 'Apakah Anda yakin akan memproses transaksi ini?',
            showCancelButton: true
        }).then((res) => {
                Swal.showLoading()
                if (res.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('transaksi/proses_penarikan'); ?>",
                        data: {
                            id: id,
                            [csrfName]: csrfHash
                        },
                        success: function(response) {
                            if (response == 'sukses') {
                                let timerInterval;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Proses penarikan berhasil',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                }).then((res) => {
                                    if (res.dismiss === Swal.DismissReason.timer)
                                        window.location.reload(true)
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
        })
    }
</script>
<?= $this->endSection(); ?>