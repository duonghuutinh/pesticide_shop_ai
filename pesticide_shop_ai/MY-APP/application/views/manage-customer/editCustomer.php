<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('manage-customer/update/' . $customers->UserID) ?>" method="post" class="box"
    enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $customers->UserID ?>">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung của người dùng</div>
                    <div class="panel-description">
                        - Thông tin chung của người dùng
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Name">Tên người dùng<span class="text-danger">(*)</span></label>
                                    <input name="Name" value="<?php echo $customers->Name ?>" type="text"
                                        class="form-control" placeholder="Nhập tên người dùng">
                                    <?php echo '<span class="text-danger">' . form_error('title') . '</span>' ?>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Email">Email<span class="text-danger">(*)</span></label>
                                    <input name="Email" value="<?php echo $customers->Email ?>" type="text"
                                        class="form-control" id="convert_slug" placeholder="Nhập email">
                                    <?php echo '<span class="text-danger">' . form_error('Email') . '</span>' ?>
                                </div>
                            </div>



                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Địa chỉ<span class="text-danger">(*)</span></label>
                                        <input name="Address" type="text" class="form-control" id="address"
                                            value="<?php echo $customers->Address ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Phone" class="form-label">Số điện thoại<span class="text-danger">(*)</span></label>
                                        <input name="Phone" type="text" class="form-control" id="phone"
                                            value="<?php echo $customers->Phone ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Avatar" class="form-label">Ảnh đại diện</label>
                                        <input name="Avatar" type="file" class="form-control-file" id="image">
                                        <div class="mt-2">
                                            <img src="<?php echo base_url('uploads/user/' . $customers->Avatar) ?>"
                                                alt="Avatar" width="150" height="150">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="status" class="form-label">Trạng thái tài khoản</label>
                                    <select name="Status" class="form-control setupSelect2" id="">
                                        <option value="1" <?php echo ($customers->Status == 1) ? 'selected' : ''; ?>>Kích
                                            hoạt</option>
                                        <option value="0" <?php echo ($customers->Status == 0) ? 'selected' : ''; ?>>Khóa
                                            tài khoản
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Phân quyền người dùng</div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="role_id" class="form-label">Vai trò của người dùng</label>
                                    <select name="Role_ID" class="form-control setupSelect2" id="=">
                                        <option value="1" <?php echo ($customers->Role_ID == 1) ? 'selected' : ''; ?>>Admin</option>
                                        <option value="2" <?php echo ($customers->Role_ID == 2) ? 'selected' : ''; ?>>Khách hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button type="submit" name="send" value="send" class="btn btn-primary">Lưu lại</button>
        </div>
</form>