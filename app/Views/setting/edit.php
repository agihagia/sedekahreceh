<div class="modal fade" id="editModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title h4"><?= $title; ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="refresh()"></button>
			</div>
			<?= form_open('setting/update', ['class' => 'formUpdate'], ['id' => $setting['id']]); ?>
			<div class="modal-body">
                <div class="form-group">
					<label for="value" class="form-label">Value Setting</label>
					<textarea class="form-control" id="value" name="value" rows="5"><?= $setting['value_setting']; ?></textarea>
					<div class="errorvalue invalid-feedback">
						<span class="errorValue"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="update">Update</button>
			</div>
			<?= form_close(); ?>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	$(document).ready(function() {
		$('.formUpdate').submit(function() {
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: $(this).serialize(),
				dataType: 'json',
				beforeSend: function() {
					$('#update').html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
				},
				complete: function() {
					$('#update').html('Update');
				},
				success: function(response) {
					if (response.error) {
                        if (response.csrf_token) {
							$('#csrfToken, input[name=<?= csrf_token() ?>]').val(response.csrf_token);
						}
						if (response.error.value_setting) {
							$('#value').addClass('is-invalid');
							$('.errorValue').addClass('form-control-feedback pr-2')
							$('.errorvalue').html(response.error.value_setting)
						} else {
							$('#value').removeClass('is-invalid');
							$('#value').addClass('is-valid');
						}
						window.setTimeout(function() {
							$('.errorValue').fadeTo(500, 0).fadeTo(500, 0).slideUp(500, function() {
								$(this).remove();
								$('#value').removeClass('is-invalid');
								$('.errorvalue').append(`
									<span class="errorValue"></span>
								`);
							})
						}, 3000);
					} else {
                        if (response.csrf_token) {
							$('#csrfToken, input[name=<?= csrf_token() ?>]').val(response.csrf_token);
						}
						Swal.fire({
							icon: 'success',
							title: 'Data berhasil diperbarui',
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
						})
						$('#editModal').modal('hide');
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