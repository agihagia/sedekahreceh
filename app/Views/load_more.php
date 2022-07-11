<?php if ($jenissedekah > 0) { ?>
    <?php foreach ($jenissedekah as $sedekah) { ?>
        <?php $postID = $sedekah->id; ?>
        <div class="col-sm-6 col-lg-3 mb-4 list_item">
            <div class="card">
                <img src="/images/sedekah/<?= $sedekah->sampul ?>" class="card-img-top" alt="" width="100%" height="200">
                <div class="card-body">
                    <h5 class="card-title"><?= $sedekah->jenis ?><h5 class="card-title">
                            <h4>Rp.<?= $sedekah->rupiah ?></h4>
                            <p class="card-text">
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                <?= $sedekah->des ?><i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($total > $limit) { ?>
        <div class="show_more_main" id="show_more_main<?= $postID; ?>">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
            <span id="<?= $postID; ?>" class="show_more" title="Load more posts">Load more</span>
            <span class="loding" style="display: none;"><i class="fa fa-circle-notch fa-spin"></i> <span class="loding_txt">Loading...</span></span>
        </div>
    <?php } else { ?>
        <p class="lead text-center">-- "Sedekah recehnya di sini, sedekah gedenya di mana-mana." --</p>
    <?php } ?>
<?php } ?>