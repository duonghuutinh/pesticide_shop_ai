<table class="table table-striped table-bordered mt20 mb20">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" class="input-checkbox">
            </th>
            <th scope="text-center">#</th>
            <th scope="text-center">Tên sản phẩm</th>
            <th scope="text-center">Tên khách hàng</th>
            <th scope="text-center">Email</th>
            <th scope="text-center">Ngày bình luận</th>
            <th scope="text-center">Nội dung</th>
            <th scope="text-center">Status</th>
            <th scope="text-center">Manage</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($comments as $key => $cmt): ?>
            <tr>
                <td>
                    <input type="checkbox" value="" class="input-checkbox checkBoxItem">
                </td>
                <th scope="row"><?php echo $key + 1; ?></th>
                <td>Tên sản phẩm lấy ra từ bảng product</td>
                <td><?php echo $cmt->name ?></td>
                <td><?php echo $cmt->email ?></td>
                <td><?php echo $cmt->date_cmt ?></td>
                <td><?php echo $cmt->comment ?></td>
               
            

                <td>
                    <span class="badge <?php echo $cmt->status == 1 ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $cmt->status == 1 ? 'Đã duyệt' : 'Chưa duyệt'; ?>
                    </span>
                </td>
                <td style="width: 100px" class="text-center">
                    <a href="<?php echo base_url('comment/list/edit/'.$cmt->id) ?>" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>
                    <a onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này chứ?')" href="<?php echo base_url('comment/delete/'.$cmt->id) ?>" class="btn btn-danger"><i
                            class="fa fa-trash"></i></a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>