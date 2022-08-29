<?= $this->extend('themes\littlegreenery\template'); ?>

<?= $this->section('konten'); ?>
<div class="hero-wrap hero-bread" style="background-image: url('<?= base_url('assets/themes/littlegreenery/images/fix.jpg'); ?>');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span>Product</span></p>
                <h1 class="mb-0 bread">PRODUCT</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <?php

            if (count($products) > 0) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-6 col-lg-3 ftco-animate">

                        <div class="product">
                            <a href="<?= base_url('shop/product/' . $product['id'] . '/' . $product['sku'] . '/') ?>" class="img-prod">
                                <img class="img-fluid" src="<?= base_url('assets/uploads/products/' . $product['picture_name']) ?>" alt="<?= $product['name']; ?>">
                                <?php if ($product['current_discount'] > 0) : ?>
                                    <span class="status"><?php $nilai = $product['current_discount'] / $product['price'] * 100;
                                                            echo number_format($nilai, 0); ?>%</span>
                                <?php endif; ?>
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="<?= base_url('shop/product/' . $product['id'] . '/' . $product['sku'] . '/') ?>"><?= $product['name']; ?></a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price">
                                            <?php if ($product['current_discount'] > 0) : ?>
                                                <span class="mr-2 price-dc"><?= number_to_currency($product['price'], 'IDR', 'id_ID', 2); ?></span><span class="price-sale"><?= number_to_currency($product['price'] - $product['current_discount'], 'IDR', 'id_ID', 2); ?></span>
                                            <?php else : ?>
                                                <span class="mr-2"><span class="price-sale"><?= number_to_currency($product['price'] - $product['current_discount'], 'IDR', 'id_ID', 2); ?></span>
                                                <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <a href="<?= base_url('shop/product/' . $product['id'] . '/' . $product['sku'] . '/') ?>" class="buy-now d-flex justify-content-center align-items-center text-center">
                                            <span><i class="ion-ios-menu"></i></span>
                                        </a>
                                        <a href="#" type='submit' class="add-to-chart add-cart d-flex justify-content-center align-items-center mx-1" data-sku="<?= $product['sku']; ?>" data-name="<?= $product['name']; ?>" data-price="<?= ($product['current_discount'] > 0) ? ($product['price'] - $product['current_discount']) : $product['price']; ?>" data-id="<?= $product['id']; ?>">
                                            <span><i class="ion-ios-cart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                ?>
            <?php else :
            ?>
            <?php endif;
            ?>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <?php echo $pager->links('card', 'paginationCust'); ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>