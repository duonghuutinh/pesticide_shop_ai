<section>
    <div class="container">
        <div class="row">
            <?php $this->load->view('pages/component/sidebar'); ?>
            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Danh sách sản phẩm giảm giá</h2>
                    <?php
                    foreach ($products_sale as $key => $allProOnSale) {
                        ?>
                        <form action="<?php echo base_url('add-to-cart') ?>" method="POST">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <input type="hidden" value="<?php echo $allProOnSale->ProductID ?>" name="ProductID">
                                    <input type="hidden" value="1" name="Quantity">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <!-- <div
                                                class="view-product <?php echo ($allProOnSale->total_remaining == 0) ? 'out-of-stock' : ''; ?>">
                                                <img style="width: 300px; height: 300px"
                                                    src="<?php echo base_url('uploads/product/' . $allProOnSale->Image) ?>"
                                                    alt="<?php echo $allProOnSale->Name ?>" />
                                            </div> -->
                                            <img src="<?php echo base_url('uploads/product/' . $allProOnSale->Image) ?>"
                                                alt="<?php echo $allProOnSale->Name ?>" />

                                            <h2>
                                                <?php
                                                // Kiểm tra nếu có giảm giá
                                                if (isset($allProOnSale->Promotion) && $allProOnSale->Promotion != 0) {
                                                    // Tính giá sau giảm
                                                    $price_no_Promotion = $allProOnSale->Selling_price;
                                                    $Selling_price = $allProOnSale->Selling_price * (1 - $allProOnSale->Promotion / 100);
                                                    ?>
                                                    <span style="color: red" class="sale-label">Sale: </span>
                                                    <span
                                                        class="discounted-price"><?php echo number_format($Selling_price, 0, ',', '.') ?>
                                                        VND</span>
                                                    <?php
                                                } else {
                                                    // Nếu không có giảm giá
                                                    echo number_format($allProOnSale->Selling_price, 0, ',', '.') . " VND";
                                                }
                                                ?>
                                            </h2>

                                            <p><?php echo $allProOnSale->Name ?></p>
                                            <a href="<?php echo base_url('san-pham/' . $allProOnSale->ProductID . '/' . $allProOnSale->Slug) ?>"
                                                class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Details</a>
                                            <button type="submit" class="btn btn-default cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
                <?php echo $links; ?>
            </div>
        </div>
    </div>
</section>