<!doctype html>
<html lang="en">
  <head>
  	<title>Login 09</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href=<?= base_url("loginn/css/style.css")?>>

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
		<div class="container-login100" style="background-image: url(<?= base_url('loginn/images/bg.jpg')?>)">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap py-5">
					<div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?= base_url('loginn/images/logo.png.png')?>)"></div>
		      	<h3 class="text-center mb-0"><?= lang('Register') ?></h3>
		      	<p class="text-center">Register yourself by filling in the following data</p>
						<form action="<?= route_to('register') ?>" method="post" class="login-form">
                        <?= csrf_field() ?>
                        <?= view('Myth\Auth\Views\_message_block') ?>

					<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"> </div>
		      			<input name="name" type="text <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" class="form-control" placeholder="Full Name" required>
							 
						</div>
					<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"></div>
		      			<input name="username" type="text <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" class="form-control" placeholder="Username" required>
							
							</div>		
					<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"></div>
		      			<input name="email" type="email <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" class="form-control" placeholder="Email" required>
							 
						</div>
						<div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center "></div>
	              <input name="password"type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" required>
					
						</div>
						<div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center "></div>
	              <input name="pass_confirm"type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Repeat Password"required>
					
				
						</div><div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"> </div>
		      			<input name="phone_number" type="text <?php if (session('errors.phone_number')) : ?>is-invalid<?php endif ?>" class="form-control" placeholder="Phone Number" required>
							 
						</div>
						<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"> </div>
		      			<input name="address" type="textarea <?php if (session('errors.address')) : ?>is-invalid<?php endif ?>" class="form-control" placeholder="Address" required>
							 
							
	            <!-- <div class="form-group d-md-flex">
								<div class="w-100 text-md-right">
									<a href="#">Forgot Password</a>
								</div> -->
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn form-control btn-primary rounded submit px-3"> <?= lang('Auth.register') ?></button>
	            </div>
	          </form>
	          <div class="w-100 text-center mt-4 text">
	          	<p class="mb-0"><?= lang('Auth.alreadyRegistered') ?></p>
		          <a href="<?= route_to('login') ?>">Sign In</a>
	          </div>
	        </div>
				</div>
			</div>
		</div>
	</section>

  <script src=<?= base_url("loginn/js/jquery.min.js")?>></script>
  <script src=<?= base_url("loginn/js/popper.js")?>></script>
  <script src=<?= base_url("loginn/js/bootstrap.min.js")?>></script>
  <script src=<?= base_url("loginn/js/main.js")?>></script>

	</body>
</html>

