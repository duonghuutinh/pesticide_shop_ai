<form method="post" action="<?= base_url('brand/list/bulkUpdate') ?>" class="">

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
                <th scope="text-center">#</th>
                <th scope="text-center">Image</th>
                <th scope="text-center">Name</th>
                <th scope="text-center">Description</th>
                <th scope="text-center">Status</th>
                <th scope="text-center">Manage</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($brand as $key => $bra): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="brand_ids[]" value="<?php echo $bra->BrandID ?>" class="row-checkbox">
                    </td>
                    <th scope="row"><?php echo ($start + $key + 1); ?></th>
                    <td>
                        <img style="height: 20px; width: 20px" src="<?php echo base_url('uploads/brand/' . $bra->Image); ?>"
                            alt="" width="150" height="150">
                    </td>
                    <td><?php echo $bra->Name; ?></td>

                    <td style="max-width: 700px"><?php echo $bra->Description ?></td>

                    <td>
                        <span class="badge <?php echo $bra->Status == 1 ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $bra->Status == 1 ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td style="width: 100px" class="text-center">
                        <a href="<?php echo base_url('brand/list/edit/' . $bra->BrandID); ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <!-- <a href="<?php echo base_url('brand/delete/' . $bra->BrandID); ?>"
                        onclick="return confirm('Bạn chắc chắn muốn xóa?');" class="btn btn-danger"><i
                            class="fa fa-trash"></i></a> -->
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