<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/fix.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span><?php echo anchor('customer_payments', 'Payments View'); ?></span>
                </p>
                <h1 class="mb-0 bread">Pembayaran Saya</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header bg-primary">
                        <h5 class="card-heading" style="color:white;">Data Order</h5>
                    </div>
                    <div class="card-body ">
                        <table class="table table-hover table-striped table-responsive">
                            <tr>
                                <td>Order</td>
                                <td>#<b><?php echo $data->order_number; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><b><?php echo get_formatted_date($data->payment_date); ?></b></td>
                            </tr>
                            <tr>
                                <td>Jumlah transfer</td>
                                <td><b>Rp <?php echo format_rupiah($data->payment_price); ?></b></td>
                            </tr>
                            <tr>
                                <td>Transfer dari</td>
                                <td><b><?php echo $payment->source->bank; ?> a.n <?php echo $payment->source->name; ?> (<?php echo $payment->source->number; ?>)</td>
                            </tr>
                            <tr>
                                <td>Transfer ke</td>
                                <td><b>
                                        <?php
                                        $transfer_to = $payment->transfer_to;
                                        $transfer_to = $banks[$transfer_to];

                                        ?>
                                        <?php echo $transfer_to->bank; ?> a.n <?php echo $transfer_to->name; ?> (<?php echo $transfer_to->number; ?>)
                                    </b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><b><?php echo get_payment_status($data->payment_status); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header bg-primary">
                        <h5 class="card-heading" style="color:white;">Bukti Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img alt="Pembayaran order #<?php echo $data->order_number; ?>" class="img img-fluid" src="<?php echo base_url('assets/uploads/payments/' . $data->picture_name); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<?= $this->endSection(); ?>