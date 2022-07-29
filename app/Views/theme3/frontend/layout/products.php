<?php
if (!empty($products)) { ?>
    <section class="product_section">
        <div class="container mb-5 pt-4">
            <div class="heading_container heading_center">
                <h2 class="pb-3 fw-bold text-color">Our Products</h2>
            </div>
            <div class="row" style="gap: 30px 0;">
                <?php foreach ($products as $product) {

                    foreach ($product as $p) {

                        $img = !empty($p['main_image']) ? base_url() . "/public/uploads/product_images/" . $p['main_image'] : base_url() . "/public/assets/img/product1.jpg";
                ?>
                        <div class="col-md-4">
                            <div class="main-wraiper">
                                <div class="container">
                                    <a href="javascript:void(0)">
                                        <div class="top" style="background: url(<?= base_url(); ?>/public/uploads/product_images/<?= $p['main_image'] ?>) no-repeat center center; background-size: 50%;">
                                        </div>
                                    </a>
                                    <div class="bottom btm1">
                                        <div class="left">
                                            <div class="details prc">
                                                <h4 class="text-truncate"><?= $p['product_name']; ?></h4>
                                                <p>₹ <?= $p['mrp']; ?></p>
                                            </div>
                                            <div class="buy by" onclick="addToCard(<?= $p['id']; ?>)">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="done">
                                                <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" scale="40" class="submt">
                                                </lord-icon>
                                            </div>
                                            <div class="details">
                                                <h4 class="text-truncate"><?= $p['product_name']; ?></h4>
                                                <p class="text-truncate"><?= $p['product_name']; ?></p>
                                            </div>
                                            <div class="remove rmv"><i class="material-icons">clear</i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="inside">
                                    <div class="icon"><i class="material-icons">info_outline</i></div>
                                    <div class="contents">
                                        <div class="col-lg-12 text-light">
                                            <div class="p-2">
                                                <ul class="list-unstyled mb-3">
                                                    <li class="d-flex justify-content-between py-1 border-bottom"><strong>Order
                                                            Subtotal
                                                        </strong><strong>₹<?= $p['mrp']; ?></strong></li>
                                                    <li class="d-flex justify-content-between py-1 border-bottom">
                                                        <strong>Shipping and
                                                            handling</strong><strong>₹10.00</strong>
                                                    </li>
                                                    <li class="d-flex justify-content-between py-1 border-bottom">
                                                        <strong>Discount
                                                        </strong><strong><?= $p['discount']; ?> %</strong>
                                                    </li>

                                                    <li class="d-flex justify-content-between py-1 border-bottom">
                                                        <strong>Total</strong>
                                                        <h5 class="font-weight-bold">₹<?= ($p['mrp'] + 10) - (($p['mrp'] * $p['discount']) / 100); ?></h5>
                                                    </li>
                                                </ul>
                                                <div>
                                                    <a href="javascript:void(0)" onclick="addToCard(<?= $p['id']; ?>)" class="btn rounded-pill p-2 btnbg btn-block bg-white nebtn w-100">
                                                        Procceed to checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } ?>
            </div>
            <div class="btn_box">
                <a class="btn btn-light" href="<?= base_url(); ?>/products">
                    <button class="btn-two"><span>All Products</span></button>
                </a>
            </div>
        </div>
    </section>
<?php }
?>