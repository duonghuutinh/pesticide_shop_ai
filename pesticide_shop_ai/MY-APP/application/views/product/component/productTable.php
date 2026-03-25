<form method="post" action="<?= base_url('product/list/bulkUpdate') ?>" class="">
    <div class="mb-2 update-multi-order-select mb20 mt20 float-right">
        <select name="new_status" class="form-control d-inline-block w-auto setupSelect2">
            <option value="">-- Cập nhật trạng thái --</option>
            <option value="1">Kích hoạt</option>
            <option value="0">Ẩn sản phẩm</option>
        </select>
        <button type="submit" name="action" value="update_status" class="btn btn-primary ml10">Cập nhật trạng thái</button>

    </div>
    <div class="mb-2 update-multi-order-select mb20 mt20 float-right ">
        <input style="width: 150px" type="number" name="promotion"
            placeholder="Giảm giá %" class="form-control ml20" min='0' max='100'>
        <button type="submit" name="action" value="update_promotion" class="btn btn-primary mr30 ml10">Giảm giá đồng loạt</button>
    </div>
    <table class="table table-striped table-bordered mt20 mb20">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th scope="col">STT</th>
                <th scope="col">Tên SP</th>
                <th scope="col">Mã SP</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Đơn vị tính</th>
                <th scope="col">Tồn kho</th>
                <th scope="col">Hạn sử dụng theo lô</th>
                <th scope="col">Giảm giá</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $key => $pro): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="product_ids[]" value="<?php echo $pro->ProductID ?>" class="row-checkbox">
                    </td>
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
                        <span style="color: <?php echo ($pro->Promotion > 0) ? 'blue' : 'black'; ?>">
                            <?php echo $pro->Promotion ? $pro->Promotion . ' %' : '0%'; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($pro->Status == 1): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="width: 100px" class="text-center">
                        <a href="<?php echo base_url('product/list/edit/' . $pro->ProductID); ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <!-- <a href="<?php echo base_url('product/delete/' . $pro->ProductID); ?>"
                        onclick="return confirm('Bạn chắc chắn muốn xóa?');" class="btn btn-danger"><i
                            class="fa fa-trash"></i></a> -->
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<div class="text-center"><?php echo $links; ?></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('check_all');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        function toggleRowHighlight(checkbox) {
            checkbox.closest('tr').classList.toggle('table-active', checkbox.checked);
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                toggleRowHighlight(this);
            });

            if (cb.checked) {
                toggleRowHighlight(cb);
            }
        });

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                toggleRowHighlight(cb);
            });
        });
    });
</script>