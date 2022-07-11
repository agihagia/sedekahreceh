<?= $this->extend('templates/admin'); ?>
<?= $this->section('content'); ?>
<div class="viewData">
    <?= $this->include('App\Views\backup/data'); ?>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('modal'); ?>
<div class="viewModal"></div>
<?= $this->endSection(); ?>

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
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            'destroy': true,
            'responsive': true,
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': '<?= base_url('backup/listdata'); ?>',
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
                'targets': [0, 3], //sesuaikan kolom yang tidak mau di sort
                'orderable': false
            }, ],
        })

        $('.tooltip').not(this).tooltip('hide');
        
        $('.btnTambah').click(function() {
            var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
            var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
            $.ajax({
                url: '<?= base_url('backup/save'); ?>',
                type: 'POST',
                data: {
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#tambah').html('<i class="fas fa-circle-notch fa-spin"></i> Please wait...');
                },
                complete: function() {
                    $('#tambah').html('<i class="mdi mdi-plus"></i> Tambah Data');
                },
                success: function(response) {
                    if (response.csrf_token) {
                        $('#csrfToken, input[name=<?= csrf_token() ?>]').val(response.csrf_token);
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    })
                    $('.viewData').html(response.data);
                    show_data();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    }

    function refresh() {
        $.ajax({
            url: '<?= base_url('backup/refresh'); ?>',
            type: 'GET',
            cache: false,
            dataType: 'json',
            success: function(response) {
                if (response.csrf_token) {
                    $('#csrfToken, input[name=<?= csrf_token() ?>]').val(response.csrf_token);
                }
                //window.location.reload(true);
                $('.viewData').html(response.data);
                show_data();

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>
<?= $this->endSection('script'); ?>