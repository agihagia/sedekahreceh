<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title><?= $sitetitle ?> <?= $instansi ?></title>
	<meta content="<?= $brand ?> Sedekah Receh Official" name="description">
	<meta content="Sedekah Receh Official" name="keywords">

	<!-- Custom fonts for this template-->
	<link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/mdi/css/materialdesignicons.min.css">
	<!-- Custom styles for this template-->
	<link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/css/style.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/aos/aos.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/css/home.css">
	<link rel="shortcut icon" href="<?= base_url(); ?>/template/images/favicon.png" />
</head>

<body>

	<!-- ======= Header ======= -->
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
			<div class="container bg-light">
				<a class="navbar-brand" href="<?= base_url() ?>"><?= $appname ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item fs-6 me-2 active"><a class="nav-link" href="#hero">Home</a></li>
						<li class="nav-item fs-6 me-2"><a class="nav-link" href="#tujuan">Tujuan Kami</a></li>
						<li class="nav-item fs-6 me-2"><a class="nav-link" href="#jenis">Program</a></li>
						<li class="nav-item fs-6 me-2"><a class="nav-link" href="#faq">F.A.Q</a></li>
						<li class="nav-item fs-6 me-2"><a class="nav-link" href="#contact">Hubungi Kami</a></li>
						<?php if (empty(session('id'))) : ?>
							<li class="nav-item fs-6"><a class="nav-link" href="<?= base_url('login'); ?>"><i class="mdi mdi-login"></i> Login</a></li>
						<?php else : ?>
							<li class="nav-item fs-6"><a class="nav-link" href="<?= base_url('user'); ?>">Dashboard</a></li>
						<?php endif ?>
					</ul>
				</div>
			</div>
		</nav><!-- .nav-menu -->
	</header><!-- End Header -->

	<!-- ======= Hero Section ======= -->
	<section id="hero" class="d-flex align-items-center py-4">
		<div class="row">
			<div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch hero-img" data-aos="fade-up">
				<img src="<?= base_url('/images/sedekah2.png'); ?>" class="img-fluid" alt="">
			</div>
			<div class="pt-5 col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-lg-0" data-aos="fade-up">
				<div class="container">
					<h4 class="fw-normal mb-3">Sedekah Recehnya di sini,Sedekah gedenya di mana-mana</h4>
					<h4 class="fw-normal mb-3">Yang penting ISTIQOMAH</h4>
					<h4 class="fw-normal mb-3">Eksekusi berjamaah, Meski seribu ajah</h4>
					<br>
					<a href="<?= base_url('login'); ?>" class="btn btn-outline-success"><i class="mdi mdi-account-check-outline"></i> Mulai Sedekah</a>
					<!-- <a href="#" class="download-btn"><i class="bx bxl-apple"></i> App Store</a> -->
				</div>
			</div>
		</div>
	</section><!-- End Hero -->

	<main id="main">
				<!-- ======= Tujuan Section ======= -->
				<section id="tujuan" class="py-4">
			<div class="container">
			<div class="text-center">
					<h1>Sedekah Receh</h1>
				</div>
				<br />
				<div class="row">
					<div class="col-md-3 grid-margin stretch-card mb-0" data-aos="fade-up" data-aos-delay="500">
						<div class="card">
							<div class="card-body">
								<div class="text-start"><i class="mdi mdi-account-check mdi-48px text-info"></i></div>
								<h4>Komunitas</h4>
								<h6></h6>
							</div>
						</div>
					</div>
					<div class="col-md-3 grid-margin stretch-card mb-0" data-aos="fade-up" data-aos-delay="200">
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-start"><i class="mdi mdi-heart mdi-48px text-success"></i></div>
								<h4>Berbagi</h4>
								<h6></h6>
							</div>
						</div>
					</div>
					<div class="col-md-3 grid-margin stretch-card mb-0" data-aos="fade-up" data-aos-delay="400">
						<div class="card">
							<div class="card-body">
								<div class="text-start"><i class="mdi mdi-elevation-rise mdi-48px text-warning"></i></div>
								<h4>Konsistensi</h4>
								<h6></h6>
							</div>
						</div>
					</div>
					<div class="col-md-3 grid-margin stretch-card mb-0" data-aos="fade-up" data-aos-delay="300">
						<div class="card">
							<div class="card-body">
								<div class="text-start"><i class="mdi mdi-target mdi-48px text-danger"></i></div>
								<h4>Transparansi</h4>
								<h6></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!-- End App Features Section -->
		<section id="jenis" class="py-4">
			<div class="container">
				<div class="text-center">
					<h1>Realisasi Program</h1>
					<h4>Sedekah Receh</h4>
				</div>
				<br />
				<?php if (!empty($jenissedekah)) { ?>
					<div class="postList row">
						<?php foreach ($jenissedekah as $sedekah) { ?>
							<?php $postID = $sedekah->id; ?>
							<div class="col-sm-6 col-lg-3 mb-4 list_item">
								<div class="card">
									<img src="<?= base_url(); ?>/images/sedekah/<?= $sedekah->sampul ?>" class="card-img-top" alt="" width="100%" height="200">
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
						<div class="show_more_main" id="show_more_main<?= $postID; ?>">
							<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfSecure" />
							<span id="<?= $postID; ?>" class="show_more" title="Load more posts">Load more</span>
							<span class="loding" style="display: none;"><i class="fa fa-circle-notch fa-spin"></i> <span class="loding_txt">Loading...</span></span>
						</div>
					</div>
				<?php } else { ?>
					<div class="text-center">
						<img src="<?= base_url('/images/no_data_found.png'); ?>" class="img-fluid" width="400" alt="">
					</div>
				<?php } ?>
			</div>
		</section>
		<!-- ======= Frequently Asked Questions Section ======= -->
		<section id="faq" class="bg-light py-5">
			<div class="container">

				<div class="text-center">
					<h3 data-aos="fade-up">Frequently Asked Questions</h3>
					<h4 data-aos="fade-up" data-aos-delay="100">Daftar pertanyaan yang sering ditanyakan.</h4>
				</div>
				<br />

				<div class="accordion" id="accordion">
					<?php
					$i = 0;
					foreach ($faqs as $faq) {
						$i++;
					?>
						<div class="accordion-item">
							<h3 class="accordion-header" id="heading<?= $faq->id; ?>">
								<button class="accordion-button <?php echo ($i == 1 ? '' : 'collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $faq->id; ?>" aria-expanded="<?php echo ($i == 1 ? 'true' : 'false'); ?>" aria-controls="collapse<?= $faq->id; ?>">
									<?= $faq->pertanyaan; ?>
								</button>
							</h3>
							<div id="collapse<?= $faq->id; ?>" class="accordion-collapse collapse <?php echo ($i == 1 ? 'show' : ''); ?>" aria-labelledby="heading<?= $faq->id; ?>" data-bs-parent="#accordion">
								<div class="accordion-body">
									<?= $faq->jawaban; ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</section><!-- End Frequently Asked Questions Section -->

		<!-- ======= Contact Section ======= -->
		<section id="contact" class="py-5 bg-gradient-light text-dark">
			<div class="container">
				<div class="text-center mb-5">
					<h3 data-aos="fade-up">Hubungi Kami</h3>
					<h4 data-aos="fade-up" data-aos-delay="100">Anda dapat menghubungi kami melalui kontak atau media sosial kami.</h4>
				</div>

				<div class="row">
					<div class="col-md-7">
						<h4>Kontak</h4>
						<h6>Telp: <?= $telpon; ?> (WhatsApp)</h6>
						<h6>Email: <?= $email; ?></h6>
						<h6>Telegram: sedekahreceh <li class="list-inline-item"><a href="https://t.me/sedekahreceh" class="twitter"><i class="mdi mdi-telegram text-telegram icon-md"></i></a></li></h6>
						<ul class="list-inline">
							<li class="list-inline-item">
								<p class="lead">Follow Social Media:</p>
							</li>
							
							<li class="list-inline-item"><a href="https://www.instagram.com/sedekahrecehofficial/" class="instagram"><i class="mdi mdi-instagram text-danger icon-md"></i></a></li>
							
							<!--li class="list-inline-item"><a href="#" class="facebook"><i class="mdi mdi-facebook text-facebook icon-md"></i></a></!--li>
							<li-- class="list-inline-item"><a href="#" class="google-plus"><i class="mdi mdi-youtube text-youtube icon-md"></i></a></li-->
						</ul>
					</div>
					<!--div class="col-md-5 mb-3">
						<div class="google-maps">
							<?= $maps; ?>
						</div>
					<div-->
				</div>
			</div>
		</section><!-- End Contact Section -->

	</main><!-- End #main -->

	<!-- ======= Footer ======= -->
	<footer id="footer" class="py-4">
		<div class="container">
			<div class="copyright">
				<!-- &copy; Copyright <strong><span>Appland</span></strong>. All Rights Reserved -->
				Copyright &copy; <?= date('Y') ?> Sedekah Receh Official. All rights reserved.</p>
			</div>
		</div>
	</footer><!-- End Footer -->

	<a href="#" class="back-to-top"><i class="mdi mdi-arrow-up"></i></a>

	<script src="<?= base_url(); ?>/template/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?= base_url(); ?>/template/js/jquery.cookie.js" type="text/javascript"></script>
	<script src="<?= base_url(); ?>/template/js/off-canvas.js"></script>
	<script src="<?= base_url(); ?>/template/js/hoverable-collapse.js"></script>
	<script src="<?= base_url(); ?>/template/js/home.js"></script>
	<script src="<?= base_url(); ?>/template/vendors/aos/aos.js"></script>

	<script>
		AOS.init();
	</script>

	<script>
		var baseUrl = '<?= base_url(); ?>';

		$(document).ready(function() {
			$(document).on('click', '.show_more', function() {
				var ID = $(this).attr('id');
				var csrfName = '<?= csrf_token() ?>'; // Value specified in $config
				var csrfHash = $('input[name=<?= csrf_token() ?>]').val(); // CSRF hash
				$('.show_more').hide();
				$('.loding').show();
				$.ajax({
					type: 'POST',
					url: baseUrl + '/home/loadmore',
					data: {
						id: ID,
						[csrfName]: csrfHash
					},
					success: function(html) {
						$('#show_more_main' + ID).remove();
						$('.postList').append(html);
					}
				});
			});
		})
	</script>
	<?= $this->renderSection('script'); ?>
</body>

</html>