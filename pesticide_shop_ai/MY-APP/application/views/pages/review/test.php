<div class="container">
    <h1 class="title">Đánh giá sản phẩm</h1>

    <?php $errors = $this->session->flashdata('errors') ?? []; ?>
    <?php $old_inputs = $this->session->flashdata('old_inputs') ?? []; ?>

    <form action="<?= base_url('review/submitReviews') ?>" method="post">
        <input type="hidden" name="Order_Code" value="<?= $Order_Code ?>">

        <?php foreach ($all_product_in_order as $index => $product): ?>
            <div class="review-card row">
                <div class="col-sm-3 text-center">
                    <img src="<?= base_url('uploads/product/' . $product->Image) ?>" alt="<?= $product->Name ?>">
                    <p class="text-primary" style="margin-top:10px;"><?= $product->Name ?></p>
                </div>
                <div class="col-sm-9">
                    <input type="hidden" name="reviews[<?= $index ?>][ProductID]" value="<?= $product->ProductID ?>">

                    <!-- Đánh giá (Sao) -->
                    <div class="form-group">
                        <label class="rating-label">Đánh giá: <span class="text-primary"><?= $product->Name ?></span> </label>
                        <span class="text-danger"><?= $errors[$index]['rating'] ?? '' ?></span> 
                        <div class="star-rating" data-index="<?= $index ?>">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?= isset($old_inputs[$index]) && $old_inputs[$index]['rating'] == $i ? 'selected' : '' ?>" data-value="<?= $i ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="reviews[<?= $index ?>][rating]" value="<?= isset($old_inputs[$index]) ? $old_inputs[$index]['rating'] : 0 ?>" class="rating-input">
                        <?= form_error("reviews[$index][rating]") ?>
                    </div>

                    <!-- Nhận xét -->
                    <div class="form-group">
                        <label class="font24" for="comment_<?= $index ?>">Nhận xét:</label>
                        <span class="text-danger"><?= $errors[$index]['comment'] ?? '' ?></span>
                        <textarea name="reviews[<?= $index ?>][comment]" id="comment_<?= $index ?>" class="form-control" placeholder="Nhập nhận xét của bạn..."><?= isset($old_inputs[$index]) ? htmlspecialchars($old_inputs[$index]['comment']) : '' ?></textarea>
                        <?= form_error("reviews[$index][comment]") ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-right">
            <button type="submit" class="btn btn-success mb10">Gửi đánh giá</button>
        </div>
    </form>
</div>

<script>
    $('.star-rating').each(function() {
        var $container = $(this);
        var $stars = $container.find('.star');
        var $input = $container.closest('.col-sm-9').find('.rating-input');

        // Gán sao vàng khi click
        $stars.on('click', function() {
            var rating = $(this).data('value');
            $input.val(rating);

            $stars.each(function(index) {
                $(this).toggleClass('active', index < rating);
            });
        });

        var initialRating = parseInt($input.val()) || 0;
        $stars.each(function(index) {
            $(this).toggleClass('active', index < initialRating);
        });
    });
</script>
