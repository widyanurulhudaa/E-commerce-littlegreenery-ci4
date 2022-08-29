<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/bg_1.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span>Checkout</span></p>
                <h1 class="mb-0 bread">Data Order #<?= $data->order_number ?></h1>
            </div>
        </div>
    </div>
</div>
<!-- <section class="content p-4">
    <div class="row">
        <div class="col-md-8 ftco-animate">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-heading">Data Order</h5>
                </div>
                <div class="card-body ">
                    <table class="table table-hover table-striped table-hover">
                        <tr>
                            <td>Nomor</td>
                            <td><b>#<?php echo $data->order_number; ?></b></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><b><?php echo get_formatted_date($data->order_date); ?></b></td>
                        </tr>
                        <tr>
                            <td>Item</td>
                            <td><b><?php echo $data->total_items; ?></b></td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td><b>Rp <?php echo format_rupiah($data->total_price); ?></b></td>
                        </tr>
                        <tr>
                            <td>Metode pembayaran</td>
                            <td><b><?php echo ($data->payment_method == 1) ? 'Transfer bank' : 'Bayar ditempat'; ?></b></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><b class="statusField"><?php echo get_order_status($data->order_status, $data->payment_method); ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-heading">Barang dalam pesanan</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Produk</th>
                            <th scope="col">Jumlah beli</th>
                            <th scope="col">Harga satuan</th>
                        </tr>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <img class="img img-fluid rounded" style="width: 60px; height: 60px;" alt="<?php echo $item->name; ?>" src="<?php echo base_url('assets/uploads/products/' . $item->picture_name); ?>">
                                </td>
                                <td>
                                    <h5 class="mb-0"><?php echo $item->name; ?></h5>
                                </td>
                                <td><?php echo $item->order_qty; ?></td>
                                <td>Rp <?php echo format_rupiah($item->order_price); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-heading">Data Penerima</h5>
                </div>
                <div class="card-body p-2">
                    <table class="table table-hover table-striped table-hover">
                        <tr>
                            <td>Nama</td>
                            <td><b><?php echo $delivery_data->customer->name; ?></b></td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td><b><?php echo $delivery_data->customer->phone_number; ?></b></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><b><?php echo $delivery_data->customer->address; ?></b></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td><b><?php echo $delivery_data->note; ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-heading">Pembayaran</h5>
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
                <div class="card-header">
                    <h5 class="card-heading">Tindakan</h5>
                </div>
                <div class="card-body">
                    <div class="text-center actionRow">
                        <?php if ($data->payment_method == 1) : ?>
                            <?php if ($data->order_status == 1) : ?>
                                <p>Order menunggu pembayaran</p>
                                <p>Sudah mengirim pembayaran? Mari konfirmasi pembayaran.</p>
                                <a href="<?php echo site_url('customer/payments/confirm?order=' . $data->id); ?>" class="btn btn-success">Konfirmasi Pembayaran</a>
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
    </div>
</section> -->
<section class="ftco-section ftco-Keranjang Belanja">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table table-hover table-striped table-hover">
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
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-12 mt-5 cart-wrap ftco-animate">
                <div class="cart-list">
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
        </div>
        <div class="row justify-content-end">
            <div class="cart-total mb-3">
                <h3>Kode Kupon</h3>
                <p>Punya kode kupon? Gunakan kupon kamu untuk mendapatkan potongan harga menarik</p>
                <div class="form-group">
                    <label for="code">Kode:</label>
                    <input id="code" name="coupon_code" type="text" class="form-control text-left px-3" placeholder="">
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
                <h3>Rincian Keranjang</h3>
                <p class="d-flex">
                    <span>Subtotal</span>
                    <span class="n-subtotal font-weight-bold">Rp <? //php echo format_rupiah($total_cart); 
                                                                    ?></span>
                </p>
                <p class="d-flex">
                    <span>Biaya pengiriman</span>
                    <? //php if ($total_cart >= get_settings('min_shop_to_free_shipping_cost')) : 
                    ?>
                    <span class="n-ongkir font-weight-bold">Gratis</span>
                    <? //php else : 
                    ?>
                    <span class="n-ongkir font-weight-bold">Rp <?php echo format_rupiah(get_settings('shipping_cost')); ?></span>
                    <? //php endif; 
                    ?>
                </p>
                <hr>
                <p class="d-flex total-price">
                    <span>Total</span>
                    <span class="n-total font-weight-bold">Rp <? //php echo format_rupiah($total_price); 
                                                                ?></span>
                </p>
            </div>
            <p><button type="submit" class="btn btn-primary py-3 px-4">Checkout</button></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ftco-animate">
            <div class="alert alert-info">Tidak ada barang dalam keranjang.<br><?php echo anchor('browse', 'Jelajahi produk kami'); ?> dan mulailah berbelanja!</div>
        </div>
    </div>
    </div>
</section>
<?php if (($data->payment_method == 1 && $data->order_status == 1) || ($data->payment_method == 2 && $data->order_status == 1)) : ?>
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Batalkan Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin membatalkan order? Silahkan hubungi kami untuk pengembalian dana.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel-btn">Batalkan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.cancel-btn').click(function(e) {
            e.preventDefault();

            $(this).html('<i class="fa fa-spin fa-spinner"></i> Membatalkan...');

            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('customer/orders/order_api?action=cancel_order'); ?>',
                data: {
                    id: <?php echo $data->id; ?>
                },
                context: this,
                success: function(res) {
                    if (res.code == 200) {
                        $(this).html('Batalkan');

                        if (res.success) {
                            $('.statusField').text('Dibatalkan');
                            $('.actionRow').html('Order dibatalkan');
                        } else if (res.error) {
                            $('.actionRow').html(res.message);
                        }

                        setTimeout(() => {
                            $('#cancelModal').modal('hide');
                        }, 2000);
                    }
                }
            })
        })
    </script>
<?php endif; ?>

<?php if (($data->payment_method == 1 && ($data->order_status == 5 || $data->order_status == 4)) || ($data->payment_method == 2 && ($data->order_status == 4 || $data->order_status == 3))) : ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletelModalLabel">Hapus Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="deleteText">Anda yakin ingin menghapus order? Semua data yang terkait juga akan dihapus</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning delete-btn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.delete-btn').click(function(e) {
            e.preventDefault();

            $(this).html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');
            var del = $('.deleteText');

            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('customer/orders/order_api?action=delete_order'); ?>',
                data: {
                    id: <?php echo $data->id; ?>
                },
                context: this,
                success: function(res) {
                    if (res.code == 200) {
                        $(this).html('Hapus');

                        if (res.success) {
                            del.html('Order dan semua datanya berhasil dihapus');

                            setTimeout(() => {
                                del.html('<i class="fa fa-spin fa-spinner"></i> Mengalihkan...');
                            }, 3000);
                            setTimeout(() => {
                                window.location = '<?php echo site_url('customer/orders'); ?>';
                            }, 5000);
                        } else if (res.error) {
                            $('.actionRow').html(res.message);

                            setTimeout(() => {
                                $('#deleteModal').modal('hide');
                            }, 2000);
                        }
                    }
                }
            })
        })
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>