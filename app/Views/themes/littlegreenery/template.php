<!DOCTYPE html>
<html lang="en">

<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

	<link rel="icon" href=<?= base_url('assets/uploads/sites/Logo.jpg') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/open-iconic-bootstrap.min.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/animate.css') ?>>

	
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/style.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/2.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/owl.carousel.min.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/owl.theme.default.min.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/magnific-popup.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/aos.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/ionicons.min.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/argon/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/bootstrap-datepicker.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/jquery.timepicker.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/flaticon.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/icomoon.css') ?>>
	<link rel="stylesheet" href=<?= base_url('assets/themes/littlegreenery/css/style.css') ?>>

	<link rel="stylesheet" href=<?= base_url('assets/plugins/toastr/toastr.min.css') ?>>

	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery-migrate-3.0.1.min.js') ?>></script>
</head>

<body class="goto-here">

	</div>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo get_store_name(); ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<?php if (in_groups('admin')) :  ?>
						<li class="nav-item active"><a href="<?php echo base_url(); ?>" class="nav-link">Home</a></li>
					<?php else : ?>
						<li class="nav-item active"><a href="<?php echo base_url(); ?>" class="nav-link">Home</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
							<div class="dropdown-menu" aria-labelledby="dropdown04">
								<a class="dropdown-item" href="<?php echo base_url('shop/cart'); ?>">Keranjang Belanja</a>
								<a class="dropdown-item" href="<?php echo base_url('customer_payments/confirm'); ?>">Konfirmasi Pembayaran</a>
								<a class="dropdown-item" href="<?php echo base_url('product'); ?>">Product</a>
							</div>
						</li>
						<li class="nav-item"><a href="<?php echo base_url('about'); ?>" class="nav-link">About</a></li>
						<li class="nav-item"><a href="<?php echo base_url('contact'); ?>" class="nav-link">Contact</a></li>
					<?php endif; ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
						<div class="dropdown-menu" aria-labelledby="dropdown05">
							<?php if (in_groups('customer')) : ?>
								<a class="dropdown-item" href="<?php echo base_url('customer_profile'); ?>">Akun saya</a>
								<a class="dropdown-item" href="<?php echo base_url('customer_orders'); ?>">Pesanan Saya</a>
								<div class="divider"></div>
								<a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Logout</a>
							<?php elseif (in_groups('admin')) :  ?>
								<a class="dropdown-item" href="<?php echo base_url('admin'); ?>">Dashboard</a>
								<div class="divider"></div>
								<a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Logout</a>
							<?php else : ?>
								<a class="dropdown-item" href="<?php echo base_url('login'); ?>">Login</a>
								<a class="dropdown-item" href="<?php echo base_url('register'); ?>">Registration</a>
							<?php endif; ?>
						</div>
					</li>
					<?php if (in_groups('customer')) : ?>
						<li class="nav-item cta cta-colored"><a href="<?php echo base_url('shop/cart'); ?>" class="nav-link"><span class="icon-shopping_cart"></span>[<span class="cart-item-total">0</span>]</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- END nav -->
	<?= $this->renderSection('konten') ?>

	<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
		<div class="container py-4">

		</div>
	</section>

	<footer class="footer">
		<div class="container">
			<div class="footer__top">
				<div class="row">
					<div class="col-lg-3 col-md-3">
						<div class="footer__logo">
							<a href="#"><img src="data:image/webp;base64,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" alt="" data-pagespeed-url-hash="2207202823" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="footer__top__text">
							<p>The floristry business has a significant market in the corporate and social event world,
								as flowers</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-3">
						<div class="footer__top__social">
							<a href="#"><i class="icon-facebook"></i></a>
							<a href="#"><i class="icon-twitter"></i></a>
							<a href="https://www.instagram.com/little.greenery/?hl=id"><i class="icon-instagram"></i></a>
							<a href="#"><i class="icon-linkedin"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="footer__options">
				<div class="row">
					<div class="col-lg-2 col-md-3">
						<div class="footer__widget">
							<h4>Company</h4>
							<ul>
								<li><a href="<?php echo base_url('Pages'); ?>">About us</a></li>
								<li><a href="<?php echo base_url('Pages'); ?>">Contact us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-3">
						<div class="footer__widget">
							<h4>Account</h4>
							<ul>
								<li><a href="<?php echo base_url('Product'); ?>">My cart</a></li>
								<li><a href="<?php echo base_url('Login'); ?>">Login/Register</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="footer__newslatter">
							<h4>Newletter</h4>
							<p>Subcribe to our newsletter to get more free tips. No Spam, Promise.</p>
							<form action="#">
								<input type="text" placeholder="Email">
								<button type="submit">Subscribe</button>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="footer__widget footer__widget--address">
							<h4>Get in touch</h4>
							<ul>
								<li>Jl Vila Pabite, Bengkulu</li>
								<li>(08) 2178 9210 - (08) 1111 6868</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="footer__copyright">
				<div class="row">
					<div class="col-lg-12 text-center">

						<p>Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
							<script>
								document.write(new Date().getFullYear());
							</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" rel="nofollow noopener">Littlegreenery</a>
						</p>

					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
		</svg></div>

	<script src=<?= base_url('assets/themes/littlegreenery/js/popper.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/bootstrap.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.easing.1.3.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.waypoints.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.stellar.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/owl.carousel.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.magnific-popup.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/aos.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/jquery.animateNumber.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/bootstrap-datepicker.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/scrollax.min.js') ?>></script>
	<script src=<?= base_url('assets/themes/littlegreenery/js/main.js') ?>></script>
	<script src=<?= base_url('assets/plugins/toastr/toastr.min.js') ?>></script>
	<script src="<?php echo base_url('assets/themes//littlegreenery/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/themes/littlegreenery/js/2.js'); ?>"></script>
	<script src="<?php echo base_url('assets/themes/littlegreenery/js/jn.js'); ?>"></script>
	<script src="<?php echo base_url('assets/themes/littlegreenery/js/m.js'); ?>"></script>
	<script src="<?php echo base_url('assets/themes/littlegreenery/js/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/themes/littlegreenery/js/main.js'); ?>"></script>
	
	<script>
		toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}

		$.ajax({
			method: 'GET',
			url: '<?php echo base_url('Shop/cart_api?action=cart_info'); ?>',
			success: function(res) {
				var data = res.data;

				var total_item = data.total_item;
				$('.cart-item-total').text(total_item);
			}
		});

		$('.add-cart').click(function(e) {
			e.preventDefault();

			var id = $(this).data('id');
			var sku = $(this).data('sku');
			var qty = $(this).data('qty');
			qty = (qty > 0) ? qty : 1;
			var price = $(this).data('price');
			var name = $(this).data('name');

			$.ajax({
				method: 'POST',
				url: '<?= base_url('Shop/cart_api?action=add_item'); ?>',
				data: {
					id: id,
					sku: sku,
					qty: qty,
					price: price,
					name: name
				},
				success: function(res) {
					if (res.code == 200) {
						var totalItem = res.total_item;

						$('.cart-item-total').text(totalItem);
						toastr.info('Item ditambahkan dalam keranjang');
					} else {
						console.log('Terjadi kesalahan');
					}
				}
			});
		});
	</script>

</body>

</html>