<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">Danh sách thương hiệu</div>
        <div class="card-body">
            <a href="<?php echo base_url('brand/create'); ?>" class="btn btn-success mb-3">Thêm thương hiệu</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($brand as $key => $bra): ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; ?></th>
                                <td><?php echo $bra->title; ?></td>
                                <td><?php echo $bra->slug; ?></td>
                                <td style="max-width: 400px;"><?php echo substr($bra->description, 0, 100) . '...'; ?></td>
                                <td>
                                    <img src="<?php echo base_url('uploads/brand/' . $bra->image); ?>" alt="" width="150" height="150">
                                </td>
                                <td>
                                    <span class="badge <?php echo $bra->status == 1 ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $bra->status == 1 ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('brand/delete/' . $bra->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?');"><i class="fa fa-trash"></i> Xóa</a>
                                    <a href="<?php echo base_url('brand/edit/' . $bra->id); ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i> Sửa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php echo $pagination ?? ''; ?>
            </div>
        </div>
    </div>
</div>
