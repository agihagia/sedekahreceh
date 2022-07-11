<?= $this->extend('templates/admin'); ?>
<?= $this->section('content') ?>
<h1 class="h2 mb-3">Form Setor sedekah</h1>
<div class="card">
    <div class="card-header">
        <a href="<?= base_url('akun'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama" class="col-form-label">Nama Anggota</label>
                        <input class="form-control" type="text" name="nama" id="nama" value="<?= $nasabah['nama'] ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="nama" class="col-form-label">Alamat</label>
                        <input class="form-control" type="text" name="alamat" id="alamat" value="<?= $nasabah['alamat'] ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="nama" class="col-form-label">RT</label>
                        <input class="form-control" type="text" name="rt" id="rt" value="<?= $nasabah['rt'] ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="nama" class="col-form-label">RW</label>
                        <input class="form-control" type="text" name="rw" id="rw" value="<?= $nasabah['rw'] ?>" readonly>
                    </div>
                </div>

                <form action="<?= base_url('transaksi/save_setor') ?>" id="formSetor" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $nasabah['id'] ?>">
                    <div class="row align-items-center" id="banyakSetor">
                        <div class="col mb-3">
                            <label for="jenis" class="col-form-label">Pilih Jenis sedekah</label>
                            <select name="jenis[]" id="jenis" class="form-select">
                                <option value="">Pilih Satu</option>
                                <?php foreach ($sedekah as $s) : ?>
                                    <option data-rupiah="<?= $s['rupiah'] ?>" value="<?= $s['id'] ?>"><?= $s['jenis'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="qty" class="col-form-label">Banyaknya</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Kg</span>
                                </div>
                                <input type="text" name="qty[]" id="qty" class="form-control" onkeyup="hitung()">
                                <input type="hidden" name="rupiahSatuan[]" id="rupiahSatuan">
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label class="col-form-label"></label><br />
                            <button type="button" class="btn btn-primary btn-sm me-2" id="tambah"><i class="fas fa-plus"></i> Tambah Field</button>
                            <button type="button" onclick="hapusField(this)" id="hapus" class="btn btn-danger btn-sm text-light"><i class="fas fa-trash"></i> Hapus</button>
                        </div>
                    </div>
                    <br />
                    <div class="row mb-3">
                        <label for="total" class="col-2 col-form-label">Total rupiah</label>
                        <div class="col-7">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="total" id="total" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" onclick="hitung()" class="btn btn-secondary">Hitung Total</button>
                        </div>
                    </div>
                    <hr />
                    <div class="form-inline justify-content-between">
                        <button type="button" onclick="cekTransaksi()" class="btn btn-success text-light">
                            <i class="fas fa-paper-plane"></i> Setor sedekah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection('content') ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

    })

    function cekTransaksi() {
        const totalSetor = $('#total').val()
        if (totalSetor == "") {
            Swal.fire({
                icon: 'error',
                text: 'Hitung Total rupiah terlebih dahulu untuk memastikan setoran!'
            })
        } else {
            Swal.fire({
                icon: 'question',
                text: `Nasabah akan menyetorkan sedekah dengan nilai tukar Rp.${totalSetor}, Lanjutkan?`,
                footer: 'Tekan diluar kotak untuk membatalkan aksi'
            }).then((res) => {
                if (res.isConfirmed) {
                    $('form#formSetor').submit()
                }
            })
        }
    }

    function hapusField(e) {
        // cek banyaknya kolom
        const jumlahForm = $('div#banyakSetor').length
        if (jumlahForm <= 1) {
            Swal.fire({
                icon: 'error',
                title: 'Peringatan',
                text: 'Form Tunggal tidak dapat dihapus!'
            })
        } else {
            $(e).parents('div#banyakSetor').remove()
        }
    }
    $('#formSetor').nestedForm({
        forms: '#banyakSetor',
        adder: '#tambah',
    });

    function hitung() {
        var total = 0;
        $('select > option:selected').each(function() {
            let rupiah = $(this).data('rupiah') // field data-rupiah pada option
            let qty = $(this).parents('div#banyakSetor').find('input#qty').val() //cari ke parent untuk mencari input qty
            let rupiahSatuan = $(this).parents('div#banyakSetor').find('input#rupiahSatuan').val(rupiah) //cari ke parent untuk mencari input qty
            total += rupiah * qty
        })
        $('#total').val(total);
    }
</script>
<?= $this->endsection() ?>