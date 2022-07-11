<?php if ($transaksi > 0) { ?>
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
    <?php if ($total > $limit) { ?>
        <div class="show_more_main" id="show_more_main<?= $postID; ?>">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
            <span id="<?= $postID; ?>" class="show_more" title="Load more posts">Load more</span>
            <span class="loding" style="display: none;"><i class="fa fa-circle-notch fa-spin"></i> <span class="loding_txt">Loading...</span></span>
        </div>
    <?php } else { ?>
        <p class="lead text-center">-- Transaksi sudah ditampilkan semua --</p>
    <?php } ?>

<?php } ?>