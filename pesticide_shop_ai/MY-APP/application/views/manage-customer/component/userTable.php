<form method="post" action="<?= base_url('manage-customer/bulkUpdate') ?>" class="">
    <div class="mb-2 update-multi-order-select mb20 mt20 float-right">
        <select name="new_status" class="form-control d-inline-block w-auto setupSelect2" required>
            <option>-- Cập nhật trạng thái --</option>
            <option value="1">Kích hoạt</option>
            <option value="0">Khoá tài khoản</option>
        </select>
        <button type="submit" class="btn btn-primary ml10">Cập nhật trạng thái</button>
    </div>
    <table class="table table-striped table-bordered mt20 mb20">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th scope="col">STT</th>
                <th scope="col">Ảnh đại diện</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">SĐT</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Vai trò</th>
                <th scope="col">Tổng chi tiêu</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($customers as $key => $cus): ?>
                <tr class="">
                    <td>
                        <input type="checkbox" name="customer_ids[]" value="<?php echo $cus->UserID ?>" class="row-checkbox">
                    </td>
                    <th scope="row"><?php echo ($start + $key + 1); ?></th>
                    <td><img src="<?php echo base_url('uploads/user/' . $cus->Avatar) ?>" alt="" class="img-thumbnail"
                            width="70" height="70"></td>
                    <td><?php echo $cus->Name ?></td>
                    <td><?php echo $cus->Email ?></td>
                    <td><?php echo $cus->Phone ?></td>
                    <td class="width250"><?php echo $cus->Address ?></td>
                    <td><?php echo $cus->Role_name ?></td>
                    <td><?php echo number_format($cus->total_spent, 0, ',', '.') . ' VNĐ'; ?></td>

                    <td>
                        <?php
                        if ($cus->Status == 1) {
                            echo "<span class='badge bg-success'>Bình thường</span>";
                        } else {
                            echo "<span class='badge bg-danger'>Bị khóa</span>";
                        }
                        ?>
                    </td>
                    <td style="width: 100px" class="text-center">
                        <a href="<?php echo base_url('manage-customer/list/edit/' . $cus->UserID) ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <!-- <a onclick="return confirm('Bạn chắc chắn muốn xóa khách hàng này chứ?')"
                        href="<?php echo base_url('manage-customer/delete/' . $cus->UserID) ?>" class="btn btn-danger"><i
                            class="fa fa-trash"></i></a> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</form>
<div class="text-center">
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