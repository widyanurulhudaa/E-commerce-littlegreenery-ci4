<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/fix.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span>Checkout</span></p>
                <h1 class="mb-0 bread">Data Order #<?= $data->order_number ?></h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section ftco-Keranjang Belanja">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-12 ftco-animate">
                <table class="table table-hover table-striped">
                    <thead class="thead-primary">
                        <tr class="text-center">
                            <th colspan="2" style="font-size: 30px">
                                Order #<?php echo $data->order_number; ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Nomor</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo $data->order_number; ?></h3>
                            </td>

                        </tr>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Tanggal</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo get_formatted_date($data->order_date); ?></h3>
                            </td>

                        </tr>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Item</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo $data->total_items; ?></h3>
                            </td>

                        </tr>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Harga</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo format_rupiah($data->total_price);  ?></h3>
                            </td>

                        </tr>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Metode Pembayaran</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo ($data->payment_method == 1) ? 'Transfer bank' : 'Bayar ditempat';  ?></h3>
                            </td>

                        </tr>
                        <tr class="text-center cart">
                            <td class="product-name">
                                <h3>Status</h3>
                            </td>
                            <td class="product-name">
                                <h3><?php echo get_order_status($data->order_status, $data->payment_method);  ?></h3>
                            </td>

                        </tr><!-- END TR-->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-12 mt-5 cart-wrap ftco-animate">
                <table class="table ">
                    <thead class="thead-primary">
                        <tr class="text-center">
                            <th scope="col"></th>
                            <th scope="col">Produk</th>
                            <th scope="col">Jumlah Beli</th>
                            <th scope="col">Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr class="text-center ">
                                <td class="image-prod">
                                    <div class="img img-fluid rounded" alt="<?php echo $item->name; ?>" style="background-image:url(<?php echo base_url('assets/uploads/products/' . $item->picture_name); ?>);"></div>
                                </td>
                                <td class="product-name">
                                    <h3 class="mb-0"><?php echo $item->name; ?></h3>
                                </td>
                                <td class="product-name">
                                    <h3><?php echo $item->order_qty; ?></h3>
                                </td>
                                <td class="product-name">
                                    <h3>Rp <?php echo format_rupiah($item->order_price); ?></h3>
                                </td>

                            </tr><!-- END TR-->
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header" style="background:#e4606d   ; color :white;">
                <h5 class="card-heading" style="color :white;">Data Penerima</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped table-hover">
                    <tr>
                        <td style="background:#e4606d   ; color :white;">Nama</td>
                        <td><b><?php echo $delivery_data->customer->name; ?></b></td>
                    </tr>
                    <tr>
                        <td style="background:#e4606d   ; color :white;">No. HP</td>
                        <td><b><?php echo $delivery_data->customer->phone_number; ?></b></td>
                    </tr>
                    <tr>
                        <td style="background:#e4606d   ; color :white;">Alamat</td>
                        <td><b><?php echo $delivery_data->customer->address; ?></b></td>
                    </tr>
                    <tr>
                        <td style="background:#e4606d   ; color :white;">Catatan</td>
                        <td><b><?php echo $delivery_data->note; ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card card-primary mb-4">
            <div class="card-header" style="background:#e4606d   ; color :white;">
                <h5 class="card-heading" style="color :white;">Pembayaran</h5>
            </div>
            <div class="card-body p-0">
                <?php if ($data->payment_price == NULL) : ?>
                    <div class="alert alert-info m-2">Tidak ada data pembayaran.</div>
                <?php else : ?>
                    <table class="table table-hover table-striped table-hover">
                        <tr>
                            <td>Transfer</td>
                            <td><b>Rp <?php echo format_rupiah($data->payment_price); ?></b></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><b><?php echo get_formatted_date($data->payment_date); ?></b></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><b>
                                    <?php if ($data->payment_status == 1) : ?>
                                        <span class="badge badge-warning text-white">Menunggu konfirmasi</span>
                                    <?php elseif ($data->payment_method == 2) : ?>
                                        <span class="badge badge-success text-white">Dikonfirmasi</span>
                                    <?php elseif ($data->payment_method == 3) : ?>
                                        <span class="badge badge-danger text-white">Gagal</span>
                                    <?php endif; ?>
                                </b></td>
                        </tr>
                        <tr>
                            <td>Transfer ke</td>
                            <td><b>
                                    <?php
                                    $bank_data = json_decode($data->payment_data);
                                    $bank_data  = (array) $bank_data;
                                    $transfer_to = $bank_data['transfer_to'];

                                    $transfer_to = $banks[$transfer_to];
                                    $transfer_from = $bank_data['source'];
                                    ?>
                                    <?php echo $transfer_to->bank; ?> a.n <?php echo $transfer_to->name; ?> (<?php echo $transfer_to->number; ?>)
                                </b></td>
                        </tr>
                        <tr>
                            <td>Transfer dari</td>
                            <td><b><?php echo $transfer_from->bank; ?> a.n <?php echo $transfer_from->name; ?> (<?php echo $transfer_from->number; ?>)</b></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header" style="background:#e4606d   ; color :white;">
                <h5 class="card-heading" style="color :white;">Tindakan</h5>
            </div>
            <div class="card-body">
                <div class="text-center actionRow">
                    <?php if ($data->payment_method == 1) : ?>
                        <?php if ($data->order_status == 1) : ?>
                            <p>Order menunggu pembayaran</p>
                            <p>Sudah mengirim pembayaran? Mari konfirmasi pembayaran.</p>
                            <a href="<?php echo base_url('customer_payments/confirm?order=' . $data->id); ?>" class="btn btn-success">Konfirmasi Pembayaran</a>
                            <br>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">Batalkan</a>
                        <?php elseif ($data->order_status == 5) : ?>
                            <p>Order dibatalkan</p>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
                        <?php elseif ($data->order_status == 2) : ?>
                            <p>Order dalam proses</p>
                        <?php elseif ($data->order_status == 3) : ?>
                            <p>Dalam pengiriman</p>
                        <?php elseif ($data->order_status == 4) : ?>
                            <p>Order selesai</p>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
                        <?php endif; ?>
                    <?php elseif ($data->payment_method == 2) : ?>
                        <?php if ($data->order_status == 1) : ?>
                            <p>Order dalam proses</p>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal"><i class="fa fa-times"></i> Batalkan</a>
                        <?php elseif ($data->order_status == 4) : ?>
                            <p>Order dibatalkan</p>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
                        <?php elseif ($data->order_status == 2) : ?>
                            <p>Dalam pengiriman</p>
                        <?php elseif ($data->order_status == 3) : ?>
                            <p>Order selesai</p>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>