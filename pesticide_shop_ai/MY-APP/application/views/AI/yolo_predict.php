<div class="container-fuild ai-container">
<h1 class="title">🧠 Chẩn đoán bệnh trên lá cây sầu riêng</h1>
    <h2></h2>
    <div class="row">
        <div class="col-lg-4">
            <form class="form-upload-img-predict" action="" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <input type="file" name="image" accept="image/*" required class="form-control">
                </div>
                <button class="upload-image" type="submit">Tải ảnh lên và chẩn đoán</button>
            </form>
        </div>
        <div class="col-lg-8">
            <h4 class="ai-result-title">Kết quả</h4>
            <?php if (!empty($image_url)): ?>
                <div class="ai-result row">
                    <div class="col-md-6">
                        <?php foreach ($predictions as $prediction): ?>
                            <div class="alert alert-success p-2 mb-2">
                                Loại bệnh: <strong>
                                    <?php
                                    $label_id = $prediction['label'];
                                    echo isset($label_map[$label_id]) ? $label_map[$label_id] : 'Không rõ';
                                    ?>
                                </strong><br>
                                Độ chính xác: <strong><?php echo round($prediction['confidence'] * 100, 2); ?>%</strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $image_url; ?>" alt="Prediction Result" class="img-fluid rounded shadow" style="max-height: 300px;">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($message)): ?>
                <p class="ai-error"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>

    </div>
    <?php if (!empty($relevant_products)): ?>
        <section>
        <h1 class="title">Gợi ý sản phẩm</h1>
            <!-- <h3 class="title text-center">Sản phẩm gợi ý dựa trên kết quả chẩn đoán</h3> -->
            <div class="features_items row">
                <?php foreach ($relevant_products as $product): ?>
                    <form action="<?php echo base_url('add-to-cart') ?>" method="POST">
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <input type="hidden" name="ProductID" value="<?php echo $product->ProductID ?>">
                                <input type="hidden" name="Quantity" value="1">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?php echo base_url('uploads/product/' . $product->Image) ?>"
                                            alt="<?php echo $product->Name ?>" />

                                        <h2>
                                            <?php
                                            if (isset($product->Promotion) && $product->Promotion != 0) {
                                                $price_no_Promotion = $product->Selling_price;
                                                $Selling_price = $product->Selling_price * (1 - $product->Promotion / 100);
                                            ?>
                                                <span class="sale-label">Sale: </span>
                                                <span class="discounted-price">
                                                    <?php echo number_format($Selling_price, 0, ',', '.') ?> VND
                                                </span>
                                            <?php
                                            } else {
                                                echo number_format($product->Selling_price, 0, ',', '.') . " VND";
                                            }
                                            ?>
                                        </h2>

                                        <p><?php echo $product->Name ?></p>
                                        <a href="<?php echo base_url('san-pham/' . $product->ProductID . '/' . $product->Slug) ?>"
                                            class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Details</a>
                                        <button type="submit" class="btn btn-default cart">
                                            <i class="fa fa-shopping-cart"></i> Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </section>
        <div class="mt-3 text-center">
            <?php echo $links; ?>
        </div>
    <?php endif; ?>

</div>