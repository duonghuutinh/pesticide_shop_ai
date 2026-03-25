<table class="table table-striped table-bordered mt20 mb20">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Tổng số lượng đánh giá</th>
            <th scope="col">Số lượng đánh giá mới</th>
            <th scope="col">Đánh giá trung bình</th>
            <th scope="col">Đánh giá gần nhất</th>
            <th scope="col">Xem chi tiết</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($reviews as $key => $review): ?>
            <tr>
                <th scope="row"><?php echo ($start + $key + 1); ?></th>
                <td>
                    <img style="height: 20px; width: 20px" src="<?php echo base_url('uploads/product/' . $review->Image); ?>"
                        alt="" width="150" height="150">
                </td>
                <td><?php echo $review->Name; ?></td>

                <td><?php echo $review->total_reviews ?></td>
                <td><?php echo $review->pending_reviews ?></td>
                <td><?php echo $review->avg_rating ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($review->last_review_time)); ?></td>
                <td class="text-center">
                    <a href="<?php echo base_url('review-list/detail/'.$review->ProductID)?>" title="Xem chi tiết">
                        <i class="fa fa-eye receipt_detail_eye"></i>
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<div class="mt-3 text-center">
    <?php echo $links; ?>
</div>