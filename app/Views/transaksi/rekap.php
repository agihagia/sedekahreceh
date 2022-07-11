<style>
    .table-tr {
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid #000000;
        text-align: start;
        height: 20px;
        margin: 10px;
    }

    body {
        border: 1px solid #000;
        width: fit-content;
        padding: 10px;
    }

    h4,h5 {
        text-align: center;
    }
</style>

<body>
    <h4>Bank sedekah <?= $instansi; ?></h4>
    <h5><?= $alamat; ?>, Indonesia. Telp: <?= $telpon; ?>, Email: <?= $email; ?></h5>
    <hr/>
    <div style="font-size: 18px;text-align: center;">Rekap Transaksi</div>
    <p>Dari : <span><?= date('d F y', strtotime($dari)) ?></span> - Sampai : <span><?= date('d F y', strtotime($sampai)) ?></span></p>
    <table class="table-tr">
        <tr>
            <th style="width: 5%; text-align:center">No</th>
            <th style="width: 25%;">Nama Anggota</th>
            <th style="width: 17%;">Jenis Transaksi</th>
            <th style="width: 23%;">Total Transaksi</th>
            <th style="width: 30%;">Tanggal Transaksi</th>
        </tr>
        <?php $no = 1;
        foreach ($transaksi as $tr) : ?>
            <tr>
                <td style="width: 5%; text-align:center"><?= $no ?></td>
                <td style="width: 25%;"><?= $tr->nama ?></td>
                <td style="width: 17%;"><?= $tr->jenis_transaksi ?></td>
                <td style="width: 23%;"><?= $tr->total_rupiah ?></td>
                <td style="width: 30%;"><?= $tr->created_at ?></td>
            </tr>
        <?php $no++;
        endforeach ?>
    </table>
</body>