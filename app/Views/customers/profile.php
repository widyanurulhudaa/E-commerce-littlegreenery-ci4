<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/fix.jpg'); ?>');">
  <div class="container">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-9 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Profile</span>
        </p>
        <h1 class="mb-0 bread">Profile Saya</h1>
      </div>
    </div>
  </div>
</div>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?php echo get_user_image(); ?>" alt="<?php echo get_user_name(); ?>">
              </div>

              <h3 class="profile-username text-center"><?php echo get_user_name(); ?></h3>
              <p class="text-muted text-center"><?php echo $user->username; ?> | <?php echo $user->email; ?></p>
              <?php if ($flash) : ?>
                <p class="text-center text-success"><?php echo $flash; ?></p>
              <?php endif; ?>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header p-2 bg-primary">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link profil active" href="#profile" data-toggle="tab" style="color:white;">Profil</a></li>
                <li class="nav-item"><a class="nav-link akun " href="#akun" data-toggle="tab" style="color:white;">Akun</a></li>
                <li class="nav-item"><a class="nav-link email" href="#email" data-toggle="tab" style="color:white;">Email</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="profile">
                  <?php echo form_open_multipart('customer_profile/edit_name'); ?>
                  <?php $validation = \Config\Services::validation() ?>
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Nama:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" name="name" value="<?php echo set_value('name', $user->name); ?>" required>
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('name'); ?></div>
                  </div>
                  <div class="form-group row">
                    <label for="inputHP" class="col-sm-2 col-form-label">No. HP:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputHP" name="phone_number" value="<?php echo set_value('phone_number', $user->phone_number); ?>" required>
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('phone_number'); ?></div>
                  </div>
                  <div class="form-group row">
                    <label for="inputAddr" class="col-sm-2 col-form-label">Alamat:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputAddr" name="address" value="<?php echo set_value('address', $user->address); ?>" required>
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('address'); ?></div>
                  </div>

                  <div class="form-group row">
                    <label for="picture" class="col-sm-2 col-form-label">Foto profil:</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-info" style="border-radius:10px ;">Perbarui</button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="akun">
                  <?php echo form_open('customer_profile/edit_account', array('autocomplete' => 'off')); ?>

                  <div class="form-group row">
                    <label for="inputUserName" class="col-sm-2 col-form-label">Username:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputUserName" name="username" value="<?php echo set_value('username', $user->username); ?>" required>
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('username'); ?></div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Masukkan password baru untuk mengganti. Kosongkan jika tidak ingin mengganti">
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('password'); ?></div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-info" style="border-radius:10px ;">Perbarui</button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="email">
                  <?php echo form_open('customer_profile/edit_email'); ?>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo set_value('email', $user->email); ?>" required>
                    </div>
                    <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('email'); ?></div>
                  </div>

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-info" style="border-radius:10px ;">Perbarui</button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?= $this->endSection(); ?>