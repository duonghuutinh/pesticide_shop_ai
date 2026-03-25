



<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">Danh sách danh mục</div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card-body">
            <a href="<?php echo base_url('category/create'); ?>" class="btn btn-success mb-3">Thêm danh mục</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category as $key => $cate): ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; ?></th>
                                <td><?php echo $cate->Name; ?></td>
                                <td><?php echo $cate->Slug; ?></td>
                                <td style="max-width: 400px;"><?php echo substr($cate->Description, 0, 100) . '...'; ?></td>
                                <td>
                                    <img src="<?php echo base_url('uploads/category/' . $cate->Image); ?>" alt="" width="150" height="150">
                                </td>
                                <td>
                                    <span class="badge <?php echo $cate->Status == 1 ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $cate->Status == 1 ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('category/delete/' . $cate->CategoryID); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?');"><i class="fa fa-trash"></i> Xóa</a>
                                    <a href="<?php echo base_url('category/edit/' . $cate->CategoryID); ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i> Sửa</a>
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
