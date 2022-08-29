<?= $this->extend('admin\header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Pengaturan Situs</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <?php echo form_open_multipart('admin_settings/update'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <div class="row">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Identitas Toko</h3>
            <?php if ($flash) : ?>
              <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                <?php echo $flash; ?>
              </span>
            <?php endif; ?>
          </div>

          <div class="card-body">

            <div class="form-group">
              <label class="form-control-label" for="name">Nama toko:</label>
              <input type="text" name="store_name" value="<?php echo set_value('store_name', get_settings('store_name')); ?>" class="form-control" id="name">

              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_name'); ?></div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label class="form-control-label" for="phone_number">No. HP:</label>
                  <input type="text" name="store_phone_number" value="<?php echo set_value('store_phone_number', get_settings('store_phone_number')); ?>" class="form-control" id="phone_number">

                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_phone_number'); ?></div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">Email:</label>
                  <input type="text" name="store_email" value="<?php echo set_value('store_email', get_settings('store_email')); ?>" class="form-control" id="email">

                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_email'); ?></div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-control-label" for="address">Alamat:</label>
              <textarea name="store_address" class="form-control" id="address"><?php echo set_value('store_address', get_settings('store_address')); ?></textarea>

              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_address'); ?></div>
            </div>

            <div class="form-group">
              <label class="form-control-label" for="tagline">Tagline:</label>
              <input type="text" name="store_tagline" value="<?php echo set_value('store_tagline', get_settings('store_tagline')); ?>" class="form-control" id="tagline">

              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_tagline'); ?></div>
            </div>

            <div class="form-group">
              <label class="form-control-label" for="description">Deskripsi:</label>
              <textarea name="store_description" class="form-control" id="description"><?php echo set_value('store_description', get_settings('store_description')); ?></textarea>

              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('store_description'); ?></div>
            </div>

          </div>

        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Pengaturan Pembayaran</h3>
            <button type="button" data-toggle="modal" data-target="#addBankModal" class="btn btn-outline-primary btn-add float-right btn-sm" style="margin-top: -30px;"><i class="fas fa-plus-square"></i></button>
          </div>
          <div class="card-body">
            <?php if (is_array($banks) && count($banks) > 0) : ?>
              <?php $n = 0; ?>
              <div class="increment">
                <?php foreach ($banks as $slug => $bank) : ?>

                  <div class="row alert alert-info bank-data">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="">Nama bank:</label>
                        <input type="text" class="form-control" name="banks[<?php echo $n; ?>][bank]" value="<?php echo $bank->bank; ?>">
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="">No. Rekening:</label>
                      <input type="text" class="form-control" name="banks[<?php echo $n; ?>][number]" value="<?php echo $bank->number; ?>">
                    </div>
                    <div class="col-6">
                      <label for="">Nama pemilik:</label>
                      <input type="text" class="form-control" name="banks[<?php echo $n; ?>][name]" value="<?php echo $bank->name; ?>">
                    </div>
                  </div>

                  <?php $n++; ?>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              <div class="alert alert-info alert-zero">
                Belum ada data bank yang ditambahkan. Tambahkan yang pertama!
                <br>
                (Tekan tombol + dikanan untuk menambah)
              </div>
            <?php endif; ?>
          </div>
          <div class="card-footer">

          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0">Logo</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-control-label" for="pic">Foto:</label>
            <input type="file" name="picture" class="form-control" id="pic">
            <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
            <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="mb-0">Belanja</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-control-label" for="ongkir">Ongkos kirim:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Rp</span>
              </div>
              <input type="text" name="shipping_cost" value="<?php echo set_value('shipping_cost', get_settings('shipping_cost')); ?>" class="form-control" id="ongkir">
            </div>
            <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('shipping_cost'); ?></div>
          </div>

          <div class="form-group">
            <label class="form-control-label" for="free_ongkir">Minimal belanja untuk gratis ongkir:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Rp</span>
              </div>
              <input type="text" name="min_shop_to_free_shipping_cost" value="<?php echo set_value('min_shop_to_free_shipping_cost', get_settings('min_shop_to_free_shipping_cost')); ?>" class="form-control" id="free_ongkir">
            </div>
            <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('min_shop_to_free_shipping_cost'); ?></div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
      </div>

    </div>
  </div>

  </form>

  <div class="modal fade" id="addBankModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent">
              <h3 class="card-heading text-center mt-2">Tambah Rekening Bank</h3>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" action="<?php echo base_url('admin_settings/add_bank'); ?>" method="POST" id="addCouponForm">

                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="">Nama bank:</label>
                      <input type="text" class="form-control" name="bank">
                    </div>
                  </div>
                  <div class="col-6">
                    <label for="">No. Rekening:</label>
                    <input type="text" class="form-control" name="number">
                  </div>
                  <div class="col-6">
                    <label for="">Nama pemilik:</label>
                    <input type="text" class="form-control" name="name">
                  </div>
                </div>

                <div class="text-left">
                  <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                </div>
                <div class="float-right" style="margin-top: -90px">
                  <button type="submit" class="btn btn-primary my-4 addPackageBtn">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    jQuery(document).ready(function() {
      let no = $('.bank-data').length;
      jQuery(".btn-add").click(function() {

      });
      jQuery("body").on("click", ".btn-remove", function() {
        jQuery(this).parents(".input-group").remove();

        let zero = $('.alert-zero');
        if (zero.length > 0) {
          zero.show('fade')
        }
      })
    })
  </script>
  <?= $this->include('admin/footer') ?>
  <?= $this->endSection(); ?>