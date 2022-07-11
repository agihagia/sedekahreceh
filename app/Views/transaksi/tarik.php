<?= $this->extend('templates/admin') ?>
<?= $this->section('content') ?>
<h1 class="h2 mb-3">Form Penarikan Saldo</h1>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('akun'); ?>" class="btn"><i class="fas fa-arrow-left"></i> &nbsp;Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="<?= base_url('transaksi/save_tarik') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama" class="col-form-label">Nama Anggota</label>
                            <input class="form-control" type="text" name="nama" id="nama" value="<?= $user['nama'] ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="nama" class="col-form-label">Alamat</label>
                            <input class="form-control" type="text" name="alamat" id="alamat" value="<?= $user['alamat'] ?>" readonly>
                        </div>
                        <div class="col">
                            <label for="nama" class="col-form-label">RT</label>
                            <input class="form-control" type="text" name="rt" id="rt" value="<?= $user['rt'] ?>" readonly>
                        </div>
                        <div class="col">
                            <label for="nama" class="col-form-label">RW</label>
                            <input class="form-control" type="text" name="rw" id="rw" value="<?= $user['rw'] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="saldo">Saldo Tersedia</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-secondary">Rp</span>
                            </div>
                            <input class="form-control" type="text" name="saldo" id="saldo" value="<?= $user['saldo'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="tarik">Nominal Penarikan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-secondary">Rp</span>
                            </div>
                            <input type="text" id="tarik" name="tarik" onkeyup="hitungSisa()" class="form-control <?= ($validation->hasError('tarik')) ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback">
                <?= $validation->getError('tarik'); ?>
                </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sisa">Sisa Saldo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-secondary">Rp</span>
                            </div>
                            <input type="text" id="sisa" name="sisa" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success text-light" type="submit"><i class="fas fa-paper-plane"></i> Proses Tarik Dana</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function hitungSisa() {
        const Saldo = $('#saldo').val()
        const nominal = $('#tarik').val()
        const sisa = Saldo - nominal
        //lakukan perhitungan
        if (sisa < 0) {
            //out of range!
            Swal.fire({
                icon: 'warning',
                title: 'Terjadi Kesalahan!',
                text: 'Nominal tarik melebihi saldo!'
            })
            $('#tarik').val("")
            $('#sisa').val("")

        } else {
            $('#sisa').val(sisa)
        }
    }
</script>
<?= $this->endsection() ?>