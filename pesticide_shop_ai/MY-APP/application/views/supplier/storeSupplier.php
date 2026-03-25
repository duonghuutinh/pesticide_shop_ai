<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('supplier/storage') ?>" method="post" class="box">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin nhà cung cấp</div>
                    <div class="panel-description">
                        - Nhập thông tin chung của nhãn hàng
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
                                    <label class="control-label text-left">Tên nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Name" value="<?php echo set_value('Name', isset($input['Name']) ? $input['Name'] : ''); ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <span class="text-danger">
                                        <?php echo isset($errors['Name']) ? $errors['Name'] : ''; ?>
                                    </span>
                                </div>


                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên người đại diện<span class="text-danger">*</span></label>
                                    <input name="Contact" value="<?php echo set_value('Contact', isset($input['Contact']) ? $input['Contact '] : ''); ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <span class="text-danger">
                                        <?php echo isset($errors['Contact']) ? $errors['Contact'] : ''; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Số điện thoại nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Phone" value="<?php echo set_value('Phone', isset($input['Phone']) ? $input['Phone'] : ''); ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <span class="text-danger">
                                        <?php echo isset($errors['Phone']) ? $errors['Phone'] : ''; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Địa chỉ nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Address" value="<?php echo set_value('Address', isset($input['Address']) ? $input['Address'] : ''); ?>" type="text"
                                        class="form-control" placeholder="Nhập địa chỉ nhà cung cấp">

                                    <span class="text-danger">
                                        <?php echo isset($errors['Address']) ? $errors['Address'] : ''; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Email nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Email" value="<?php echo set_value('Email', isset($input['Email']) ? $input['Email'] : ''); ?>" type="text"
                                        class="form-control" placeholder="abc@gmail.com">

                                    <span class="text-danger">
                                        <?php echo isset($errors['Email']) ? $errors['Email'] : ''; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo set_select('Status', '1', isset($input['Status']) && $input['Status'] == '1'); ?>>Active</option>
                                        <option value="0" <?php echo set_select('Status', '0', isset($input['Status']) && $input['Status'] == '0'); ?>>Inactive</option>
                                    </select>
                                </div>
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
</form>