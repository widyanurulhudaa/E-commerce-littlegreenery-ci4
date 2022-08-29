<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/fix.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span><?php echo anchor('customer_payments', 'Payments'); ?></span>
                </p>
                <h1 class="mb-0 bread">Pembayaran Saya</h1>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card card-primary">
                        <div class="card-header bg-primary">
                            <h5 class="card-heading" style="color:white;">Data Pembayaran</h5>
                        </div>
                        <?php echo form_open_multipart('customer_payments/do_confirm'); ?>

                        <?php $validation = \Config\Services::validation() ?>
                        <div class="card-body">
                            <?php if ($flash) : ?>
                                <div class="alert alert-info"><?php echo $flash; ?></div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label class="form-control-label" for="orders">Order:</label>
                                <?php if (count($orders) > 0) : ?>
                                    <select name="order_id" class="form-control" id="orders">
                                        <?php foreach ($orders as $order) : ?>
                                            <option value="<?php echo $order->id; ?>" <?php echo set_select('order_id', $order->id, ($order_id == $order->id) ? TRUE : FALSE); ?>>#<?php echo $order->order_number; ?> (Rp <?php echo format_rupiah($order->total_price); ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else : ?>
                                    <div class="text-danger font-weight-bold">Belum ada data order.</div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="bank_name" class="form-control-label">Nama bank:</label>
                                        <input type="text" name="bank_name" value="<?php echo set_value('bank_name'); ?>" class="form-control" id="bank_name" required>
                                        <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('bank_name'); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="bank_number" class="form-control-label">No. Rekening:</label>
                                        <input type="text" name="bank_number" value="<?php echo set_value('bank_number'); ?>" class="form-control" id="bank_number" required>
                                        <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('bank_number'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price" class="form-control-label">Jumlah Transfer:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" name="transfer" value="<?php echo set_value('transfer'); ?>" class="form-control" id="price" required>
                                            <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('transfer'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="an" class="form-control-label">Atas nama:</label>
                                        <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control" id="an" required>
                                        <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('name'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="to">Transfer ke</label>
                                <?php if (count($banks) > 0) : ?>
                                    <select name="bank" class="form-control" id="orders">
                                        <?php foreach ($banks as $bank => $data) : ?>
                                            <option value="<?php echo $bank; ?>" <?php echo set_select('bank', $bank); ?>><?php echo $data->bank; ?> a.n <?php echo $data->name; ?> (<?php echo $data->number; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else : ?>
                                    <div class="text-danger font-weight-bold">Belum ada data bank.</div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="picture" class="form-control-label">Bukti pembayaran:</label>
                                <input type="file" name="picture" class="form-control" required>
                                <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <input type="submit" value="Konfirmasi" class="btn btn-primary">
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card card-header bg-primary">
                            <h5 class="card-heading" style="color:white;">Pembayaran saya</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (count($payments) > 0) : ?>
                                <table class="table table-responsive table-striped">
                                    <?php foreach ($payments as $payment) : ?>
                                        <tr>
                                            <td>
                                                <?php echo anchor('customer_payments/view/' . $payment->id, 'Order #' . $payment->order_number); ?>
                                            </td>
                                            <td>
                                                <?php if ($payment->payment_status == 1) : ?>
                                                    <span class="badge badge-warning text-white">Menunggu konfirmasi</span>
                                                <?php elseif ($payment->payment_status == 2) : ?>
                                                    <span class="badge badge-success text-white">Dikonfirmasi</span>
                                                <?php elseif ($payment->payment_status == 3) : ?>
                                                    <span class="badge badge-danger text-white">Gagal mengonfirmasi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else : ?>
                                <div class="m-3 alert alert-info">Belum ada data pembayaran.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>