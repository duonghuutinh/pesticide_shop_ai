<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row list-review-wrapper">
        <div class="col-lg-3">
            <div class="panel-head">
                <div class="panel-title"><?php echo $product->Name; ?></div>
                <div class="panel-description">
                    <img src="<?php echo base_url('uploads/product/' . $product->Image); ?>"
                        alt="" width="250" height="250">
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox">
                <div class="ibox-content">
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $index => $review): ?>
                            <?php $stt = $start + $index + 1; ?>
                            <div class="row mb15">
                                <form action="<?php echo base_url('reply-comment') ?>" method="POST">
                                    <input type="hidden" name="review_id" value="<?= $review->id ?>">
                                    <div class="form-row detail-comment">
                                        <span class="detail-comment-span">#<?php echo $stt ?></span>
                                        <div class="form-group">
                                            <label for="comment">Số sao đánh giá: <span class="text-danger"><?php echo $review->rating ?></span></label>
                                            <textarea name="comment" class="form-control width250" rows="2"
                                                placeholder="Nhập đánh giá"><?php echo set_value('comment', $review->comment); ?></textarea>
                                        </div>
                                        <div class="form-group ml20">
                                            <label for="reply">Trả lời đánh giá:</label>
                                            <textarea name="reply" class="form-control width250" rows="2"
                                                placeholder="Trả lời đánh giá"><?php echo set_value('comment', $review->reply); ?></textarea>
                                        </div>
                                        <div class="form-group ml20 review-status">
                                            <select name="is_active" class="form-control width200 setupSelect2">
                                                <option value="1" <?php echo ($review->is_active == 1) ? 'selected' : '' ?>>Đã duyệt</option>
                                                <option value="0" <?php echo ($review->is_active == 0) ? 'selected' : '' ?>>Chưa duyệt</option>
                                            </select>
                                        </div>
                                        <div class="text-right review-submit">
                                            <button type="submit" name="send" value="send" class="btn btn-primary">Lưu lại</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                        <?php endforeach; ?>

                        <?php if (!empty($links)): ?>
                            <div class="pagination-wrapper text-center mt20">
                                <?php echo $links; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            Không có dữ liệu
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>