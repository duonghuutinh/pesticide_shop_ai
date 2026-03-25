<form method="post" action="<?= base_url('order_admin/bulkUpdate') ?>" class="">
    <div class="mb-2 update-multi-order-select mb20">
        <select name="new_status" class="form-control d-inline-block w-auto setupSelect2" required>
            <option>-- Cập nhật trạng thái --</option>
            <option value="1">Đơn hàng đanh được xử lý</option>
            <option value="2">Đang chuẩn bị hàng</option>
            <option value="3">Đã giao cho đơn vị vận chuyển</option>
            <option value="4">Đã thanh toán, giao hàng thành công</option>
            <option value="5">Huỷ đơn</option>
        </select>
        <button type="submit" class="btn btn-primary ml10">Cập nhật trạng thái</button>
    </div>
    <button type="submit" formaction="<?= base_url('order_admin/bulkPrint') ?>" class="btn btn-success float-right" formtarget="_blank">
        In đơn hàng
    </button>


    <table class="table table-striped table-bordered table-hover mt20 mb20">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th>Order code</th>
                <th>Customer name</th>
                <th>Customer phone</th>
                <th>Customer address</th>
                <th class="payment-method">Payment method</th>
                <th>Date order</th>
                <th>Status</th>
                <th class="action-order">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($order)): ?>
                <?php foreach ($order as $key => $ord): ?>
                    <tr class="order-row">
                        <td>
                            <input type="checkbox" name="order_ids[]" value="<?= $ord->Order_Code ?>" class="row-checkbox">
                        </td>
                        <td><?= $ord->Order_Code ?></td>
                        <td><?= $ord->name ?></td>
                        <td><?= $ord->phone ?></td>
                        <td style="width: 300px;"><?= $ord->address ?></td>
                        <td><?= $ord->checkout_method ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($ord->Date_Order)); ?></td>
                        <td>
                            <?php
                            switch ($ord->Order_Status) {
                                case -1:
                                    echo '<span class="badge badge-primary">Đơn hàng mới</span>';
                                    break;
                                case 1:
                                    echo '<span class="badge badge-warning">Đang chờ xử lý</span>';
                                    break;
                                case 2:
                                    echo '<span class="badge badge-warning">Đang chuẩn bị hàng</span>';
                                    break;
                                case 3:
                                    echo '<span class="badge badge-success">Đã giao cho đơn vị vận chuyển</span>';
                                    break;
                                case 4:
                                    echo '<span class="badge badge-info">Đơn hàng đã được thanh toán</span>';
                                    break;
                                default:
                                    echo '<span class="badge badge-danger">Đã hủy</span>';
                                    break;
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('order_admin/viewOrder/' . $ord->Order_Code) ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?= base_url('order_admin/printOrder/' . $ord->Order_Code) ?>" class="btn btn-success btn-sm" target="_blank">
                                <i class="fa-solid fa-file-export"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center text-danger">
                        <h3>Không có đơn hàng nào</h3>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>

<div class="text-center">
    <?= $links ?>
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