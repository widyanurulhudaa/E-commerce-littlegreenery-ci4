<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/bg_1.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Products</span>
                </p>
                <h1 class="mb-0 bread">Pembayaran Saya</h1>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <section class="ftco-section">
        <div class="container">
            <a class="btn btn-primary py-3 px-4 mb-2" href="<?php echo base_url('customer_payments/confirm'); ?>">Tambah Pembayaran</a>
            <div class="card card-primary">
                <div class="card-body<?php echo (count($payments) > 0) ? ' p-0' : ''; ?>">
                    <?php if (count($payments) > 0) : ?>
                        <div class="table-responsive">
                            <table class="table table-striped m-0">
                                <tr class="bg-primary" style="color:white;">
                                    <th scope="col">NO</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status</th>
                                </tr>
                                <?php $i = 1 + (10 * ($currentPage - 1)) ?>
                                <?php foreach ($payments as $payment) : ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo anchor('customer_payments/view/' . $payment['id'], '#' . $payment['order_number']); ?></td>
                                        <td><?php echo get_formatted_date($payment['payment_date']); ?></td>
                                        <td><?php echo get_payment_status($payment['payment_status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    Belum ada data pembayaran
                                </div>

                                <?php echo anchor('customer_payments/confirm', 'Konfirmasi pembayaran baru'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($pager) : ?>
                    <div class="card-footer">
                        <?php echo $pager->links('table', 'pagination'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>