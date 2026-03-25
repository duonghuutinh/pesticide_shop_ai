
<?php $this->load->view('pages/component/slider'); ?>
<section>
    <div class="container">
        <div class="row">
            <?php $this->load->view('pages/component/sidebar'); ?>
            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Danh sách sản phẩm</h2>
                    <?php if (empty($allproduct_pagination)) : ?>
                        <p class="text-center">Không có sản phẩm.</p>
                    <?php else : ?>
                        <?php foreach ($allproduct_pagination as $key => $allPro) : ?>
                            <form action="<?php echo base_url('add-to-cart') ?>" method="POST">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <input type="hidden" value="<?php echo $allPro->ProductID ?>" name="ProductID">
                                    <input type="hidden" value="1" name="Quantity">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                
                                            <img src="<?php echo base_url('uploads/product/' . $allPro->Image) ?>"
                                                alt="<?php echo $allPro->Name ?>" />

                                            <h2>
                                                <?php

                                                if (isset($allPro->Promotion) && $allPro->Promotion != 0) {

                                                    $price_no_Promotion = $allPro->Selling_price;
                                                    $Selling_price = $allPro->Selling_price * (1 - $allPro->Promotion / 100);
                                                ?>
                                                    <span style="color: red" class="sale-label">Sale: </span>
                                                    <span
                                                        class="discounted-price"><?php echo number_format($Selling_price, 0, ',', '.') ?>
                                                        VND</span>
                                                <?php
                                                } else {

                                                    echo number_format($allPro->Selling_price, 0, ',', '.') . " VND";
                                                }
                                                ?>
                                            </h2>

                                            <p><?php echo $allPro->Name ?></p>
                                            <a href="<?php echo base_url('san-pham/' . $allPro->ProductID . '/' . $allPro->Slug) ?>"
                                                class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Chi tiết</a>
                                            <button type="submit" class="btn btn-default cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                Thêm vào giỏ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo $links; ?>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">

            </div>
            <div class="col-sm-9 padding-right">

                <div class="features_items">
                    <h2 class="title text-center">Danh sách sản phẩm bán chạy</h2>
                    <?php if (empty($bestsellers)) : ?>
                        <p class="text-center">Không có sản phẩm.</p>
                    <?php else : ?>
                        <?php foreach ($bestsellers as $key => $bestseller) : ?>
                            <form action="<?php echo base_url('add-to-cart') ?>" method="POST">
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <input type="hidden" value="<?php echo $bestseller->ProductID ?>" name="ProductID">
                                        <input type="hidden" value="1" name="Quantity">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <!-- <div
                                                class="view-product <?php echo ($bestseller->total_remaining == 0) ? 'out-of-stock' : ''; ?>">
                                                <img style="width: 300px; height: 300px"
                                                    src="<?php echo base_url('uploads/product/' . $bestseller->Image) ?>"
                                                    alt="<?php echo $bestseller->Name ?>" />
                                            </div> -->
                                                <img src="<?php echo base_url('uploads/product/' . $bestseller->Image) ?>"
                                                    alt="<?php echo $bestseller->Name ?>" />

                                                <h2>
                                                    <?php

                                                    if (isset($bestseller->Promotion) && $bestseller->Promotion != 0) {

                                                        $price_no_Promotion = $bestseller->Selling_price;
                                                        $Selling_price = $bestseller->Selling_price * (1 - $bestseller->Promotion / 100);
                                                    ?>
                                                        <span style="color: red" class="sale-label">Sale: </span>
                                                        <span
                                                            class="discounted-price"><?php echo number_format($Selling_price, 0, ',', '.') ?>
                                                            VND</span>
                                                    <?php
                                                    } else {

                                                        echo number_format($bestseller->Selling_price, 0, ',', '.') . " VND";
                                                    }
                                                    ?>
                                                </h2>

                                                <p><?php echo $bestseller->Name ?></p>
                                                <a href="<?php echo base_url('san-pham/' . $bestseller->ProductID . '/' . $bestseller->Slug) ?>"
                                                    class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Chi tiết</a>
                                                <button type="submit" class="btn btn-default cart">
                                                    <i class="fa fa-shopping-cart"></i>
                                                    Thêm vào giỏ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>