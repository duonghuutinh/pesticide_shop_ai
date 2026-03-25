<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('manage-role/update/' . $role->Role_ID) ?>" method="post" class="box">
    <input type="hidden" name="id" value="<?php echo $role->Role_ID ?>">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung của nhóm người dùng</div>
                    <div class="panel-description">
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="Name">Tên vai trò</label>
                                    <input name="Role_name" value="<?php echo $role->Role_name ?>" type="text"
                                        class="form-control" placeholder="Nhập tên người dùng">
                                    <?php echo '<span class="text-danger">' . form_error('title') . '</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="Description">Mô tả</label>
                                    <textarea name="Description" class="form-control" rows="5"
                                        placeholder="Nhập mô tả vai trò"><?php echo $role->Description ?></textarea>
                                    <?php echo '<span class="text-danger">' . form_error('Description') . '</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="text-right mb15">
                <button type="submit" name="send" value="send" class="btn btn-primary">Lưu lại</button>
            </div>
        </div>
    </div>
</form>