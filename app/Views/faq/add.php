<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title h4"><?= $title; ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?= form_open('faq/save', ['class' => 'formSave']); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="pertanyaan" class="form-label">Pertanyaan</label>
					<input class="form-control form-control-lg" id="pertanyaan" name="pertanyaan" value="<?= old('pertanyaan'); ?>">
					<div class="errorpertanyaan invalid-feedback">
						<span class="errorPertanyaan"></span>
					</div>
				</div>
				<div class="form-group">
					<label for="jawaban" class="form-label">Jawaban</label>
					<textarea class="form-control" id="jawaban" name="jawaban" rows="5"><?= old('jawaban'); ?></textarea>
					<div class="errorjawaban invalid-feedback">
						<span class="errorJawaban"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
			</div>
			<?= form_close(); ?>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	$(document).ready(function() {
		$('.formSave').submit(function() {
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: $(this).serialize(),
				dataType: 'json',
				beforeSend: function() {
					$('#simpan').html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
				},
				complete: function() {
					$('#simpan').html('Simpan');
				},
				success: function(response) {
					if (response.error) {
						if (response.csrf_token) {
							$('#csrfToken, input[name=<?= csrf_token() ?>]').val(response.csrf_token);
						}
						if (response.error.pertanyaan) {
							$('#pertanyaan').addClass('is-invalid');
							$('.errorPertanyaan').addClass('form-control-feedback pr-2')
							$('.errorPertanyaan').html(response.error.pertanyaan)
						} else {
							$('#pertanyaan').removeClass('is-invalid');
							$('#pertanyaan').addClass('is-valid');
						}
						if (response.error.jawaban) {
							$('#jawaban').addClass('is-invalid');
							$('.errorJawaban').addClass('form-control-feedback pr-2')
							$('.errorJawaban').html(response.error.jawaban)
						} else {
							$('#jawaban').removeClass('is-invalid');
							$('#jawaban').addClass('is-valid');
						}
						window.setTimeout(function() {
							$('.errorPertanyaan').fadeTo(500, 0).fadeTo(500, 0).slideUp(500, function() {
								$(this).remove();
								$('#pertanyaan').removeClass('is-invalid');
								$('.errorpertanyaan').append(`
									<span class="errorPertanyaan"></span>
								`);
							})
							$('.errorJawaban').fadeTo(500, 0).fadeTo(500, 0).slideUp(500, function() {
								$(this).remove();
								$('#jawaban').removeClass('is-invalid');
								$('.errorjawaban').append(`
									<span class="errorJawaban"></span>
								`);
							})
						}, 3000);
					} else {
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
						$('#addModal').modal('hide');
						$('.viewData').html(response.data);
						show_data();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});
			return false;
		})
	})
</script>