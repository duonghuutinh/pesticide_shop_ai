<table class="table table-striped table-bordered mt20 mb20">
    <thead>
        <tr>
            <th scope="text-center">STT</th>
            <th scope="text-center">Tên vai trò</th>
            <th scope="text-center">Mô tả</th>
            <th scope="text-center">Số lượng người dùng</th>
            <th scope="text-center">Manage</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($roles as $key => $role): ?>
            <tr>
                <th scope="row"><?php echo ($start + $key + 1); ?></th>
                <td><?php echo $role->Role_name ?></td>
                <td><?php echo $role->Description ?></td>
                <td>
                    <ul style="padding-left: 20px; margin: 0;">
                        <li>Tổng số tài khoản: <b><?php echo $role->Total_Users ?></b></li>
                        <li>Tài khoản hoạt động: <b><?php echo $role->Active_Users ?></b></li>
                        <li>Tài khoản bị khoá: <b><?php echo $role->Locked_Users ?></b></li>
                    </ul>
                </td>
                <td style="width: 100px" class="text-center">
                    <a href="<?php echo base_url('manage-role/edit/' . $role->Role_ID) ?>" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<div class="text-center">
    <?php echo $links; ?>
</div>