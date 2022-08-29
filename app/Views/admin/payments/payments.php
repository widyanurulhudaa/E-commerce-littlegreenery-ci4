<?= $this->extend('admin\header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Kelola Pembayaran</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
          <h3 class="mb-0">Kelola Pembayaran</h3>
        </div>

        <?php if (count($payments) > 0) : ?>
          <div class="card-body p-0">
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pembayaran Order</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($payments as $payment) : ?>
                    <tr>
                      <th scope="col">
                        <?php echo $payment['id']; ?>
                      </th>
                      <td>#<?php echo anchor('admin_payments/view/' . $payment['id'], $payment['order_number']); ?></td>
                      <td>
                        <?php echo $payment['customer']; ?>
                      </td>
                      <td>
                        <?php echo get_formatted_date($payment['payment_date']); ?>
                      </td>
                      <td>
                        Rp <?php echo format_rupiah($payment['payment_price']); ?>
                      </td>
                      <td><?php echo get_payment_status($payment['status']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer">
            <?php echo $pager->links('table', 'pagination'); ?>
          </div>
        <?php else : ?>
          <div class="card-body">
            <div class="alert alert-primary">
              Belum ada data pembayaran.</div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
  <?= $this->include('admin/footer') ?>
  <?= $this->endSection(); ?>