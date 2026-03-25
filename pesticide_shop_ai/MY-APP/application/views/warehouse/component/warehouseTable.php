
<table class="table table-striped table-bordered mt20 mb20">
    <thead>
        <tr>
            <th scope="text-center">STT</th>

            <th scope="text-center">Tên SP</th>
            <th>Mã SP</th>
            <th scope="text-center">Giá bán</th>
            <th scope="text-center">Đơn vị tính</th>

            <th scope="text-center">Tồn kho</th>
            <th scope="text-center">Hạn sử dụng theo lô</th>

            <th scope="text-center">Trạng thái</th>
          
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products as $key => $pro): ?>
            <tr>
                <th scope="row"><?php echo ($start + $key + 1); ?></th>
                <td><?php echo $pro->Name; ?></td>
                <td><?php echo $pro->Product_Code; ?></td>
                <td>
                    <?php if ($pro->Selling_price > 0): ?>
                        <?php if ($pro->Promotion > 0): ?>
                            <span style="text-decoration: line-through; color: red;">
                                <?php echo number_format($pro->Selling_price, 0, ',', '.'); ?> VNĐ
                            </span><br>
                            <span class="font-weight-bold text-success">
                                <?php $discounted_price = $pro->Selling_price * (1 - $pro->Promotion / 100);
                                echo number_format($discounted_price, 0, ',', '.'); ?>
                                VNĐ
                            </span>
                        <?php else: ?>
                            <span class="font-weight-bold text-success">
                                <?php echo number_format($pro->Selling_price, 0, ',', '.'); ?> VNĐ
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">Liên hệ</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($pro->Unit); ?></td>

                <td><?php echo $pro->total_remaining; ?></td>
                <td>
                    <?php if (!empty($pro->batches)): ?>

                        <ul style="padding-left: 20px; margin: 0;">
                            <?php foreach ($pro->batches as $batch): ?>
                                <li>Lô #<?php echo $batch->Batch_ID; ?>:
                                    <b><?php echo $batch->remaining_quantity; ?></b> sản phẩm
                                    (Hạn: <?php echo date('d/m/Y', strtotime($batch->Expiry_date)); ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span class="text-muted">Không có lô hàng</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($pro->Status == 1): ?>
                        <span class="badge badge-success">Active</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Inactive</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<div class="text-center"><?php echo $links; ?></div>