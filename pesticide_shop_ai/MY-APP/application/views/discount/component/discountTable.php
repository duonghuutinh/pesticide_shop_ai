<form method="post" action="<?= base_url('discount-code/list/bulkUpdate') ?>" class="">

    <div class="mb-2 update-multi-order-select mb20 mt20 float-right">
        <select name="new_status" class="form-control d-inline-block w-auto setupSelect2" required>
            <option>-- Cập nhật trạng thái --</option>
            <option value="1">Kích hoạt</option>
            <option value="0">Không kích hoạt</option>
        </select>
        <button type="submit" class="btn btn-primary ml10">Cập nhật trạng thái</button>
    </div>
    <?php if (!empty($discountSummary)): ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Loại giảm giá</th>
                    <th>Tổng số mã</th>
                    <th>Số mã còn hiệu lực</th>
                    <th>Số mã hết hiệu lực</th> <!-- Cột mới -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($discountSummary as $summary): ?>
                    <tr>
                        <td><?= ucfirst($summary->Discount_type) ?></td>
                        <td><?= $summary->total ?></td>
                        <td><?= $summary->active ?></td>
                        <td><?= $summary->expired ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <table class="table table-striped table-bordered mt20 mb20">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th scope="col">#</th>
                <th scope="col">Mã nhập</th>
                <th scope="col">Loại giảm giá</th>
                <th scope="col">Giá trị giảm giá</th>
                <th scope="col">Áp dụng giá tối thiểu</th>
                <th scope="col">Áp dụng giá tối đa</th>
                <th scope="col">Bắt đầu - Kết thúc</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($DiscountCodes as $key => $dis_code): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="discount_code_ids[]" value="<?php echo $dis_code->DiscountID ?>" class="row-checkbox">
                    </td>
                    <th scope="row"><?php echo ($start + $key + 1); ?></th>
                    <td><?php echo $dis_code->Coupon_code; ?></td>
                    <td><?php echo $dis_code->Discount_type; ?></td>
                    <td><?php echo $dis_code->Discount_value; ?></td>
                    <td><?php echo $dis_code->Min_order_value; ?></td>
                    <td><?php echo $dis_code->Discount_value; ?></td>

                    <td><?php echo date('d/m/Y', strtotime($dis_code->Start_date)); ?> - <?php echo date('d/m/Y', strtotime($dis_code->End_date)); ?></td>


                    <td>
                        <span class="badge <?php echo ($dis_code->Status == 1 && strtotime($dis_code->End_date) >= strtotime('today')) ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo ($dis_code->Status == 1 && strtotime($dis_code->End_date) >= strtotime('today')) ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>

                    <td style="width: 100px" class="text-center">
                        <a href="<?php echo base_url('discount-code/list/edit/' . $dis_code->DiscountID); ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="<?php echo base_url('discount-code/delete/' . $dis_code->DiscountID); ?>"
                            onclick="return confirm('Bạn chắc chắn muốn xóa?');" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</form>
<div class="mt-3 text-center">
    <?php echo $links; ?>
</div>

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