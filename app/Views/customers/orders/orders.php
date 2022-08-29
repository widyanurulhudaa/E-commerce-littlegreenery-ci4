<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/fix.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span><?php echo anchor('customer_orders', 'Orders'); ?></span>
                </p>
                <h1 class="mb-0 bread">Orderan Saya</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section">
    <div class="container">
        <div class="card card-primary">
            <div class="card-body<?php echo (count($orders) > 0) ? ' p-0' : ''; ?>">
                <?php if (count($orders) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <tr class="bg-primary" style="color:white;">
                                <th scope="col">NO</th>
                                <th scope="col">Nomor Pesanan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah Pesanan</th>
                                <th scope="col">Total Pesanan</th>
                                <th scope="col">Pembayaran</th>
                                <th scope="col">Status</th>
                            </tr>
                            <?php $i = 1 + (10 * ($currentPage - 1)) ?>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo anchor('customer_orders/view/' . $order['id'], '#' . $order['order_number']); ?></td>
                                    <td><?php echo get_formatted_date($order['order_date']); ?></td>
                                    <td><?php echo $order['total_items']; ?> barang</td>
                                    <td>Rp <?php echo format_rupiah($order['total_price']); ?></td>
                                    <td><?php echo ($order['payment_method'] == 1) ? 'Transfer bank' : 'Bayar ditempat'; ?></td>
                                    <td><?php echo get_order_status($order['order_status'], $order['payment_method']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                Belum ada data order.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-footer">
                <?php echo $pager->links('table', 'pagination'); ?>
            </div>
        </div>
</section>

</div>
<?= $this->endSection(); ?>