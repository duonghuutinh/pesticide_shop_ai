<form method="post" action="<?= base_url('supplier/list/bulkUpdate') ?>" class="">

    <div class="mb-2 update-multi-order-select mb20 mt20 float-right">
        <select name="new_status" class="form-control d-inline-block w-auto setupSelect2" required>
            <option>-- Cập nhật trạng thái --</option>
            <option value="1">Kích hoạt</option>
            <option value="0">Không kích hoạt</option>
        </select>
        <button type="submit" class="btn btn-primary ml10">Cập nhật trạng thái</button>
    </div>
    <table class="table table-striped table-bordered mt20 mb20">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th scope="col">#</th>
                <th scope="col">Tên nhà cung cấp</th>
                <th scope="col">Tên người đại diện</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Email</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($suppliers as $key => $supplier): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="supplier_ids[]" value="<?php echo $supplier->SupplierID ?>" class="row-checkbox">
                    </td>
                    <th scope="row"><?php echo ($start + $key + 1); ?></th>
                    <td><?php echo $supplier->Name; ?></td>
                    <td style="max-width: 500px"><?php echo $supplier->Contact; ?></td>
                    <td><?php echo $supplier->Phone; ?></td>
                    <td style="max-width: 500px"><?php echo $supplier->Address ?></td>
                    <td><?php echo $supplier->Email; ?></td>
                    <td>
                        <span class="badge <?php echo $supplier->Status == 1 ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $supplier->Status == 1 ? 'Kích hoạt' : 'Không kích hoạt'; ?>
                        </span>
                    </td>
                    <td style="width: 100px" class="text-center">
                        <a href="<?php echo base_url('supplier/list/edit/' . $supplier->SupplierID); ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
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