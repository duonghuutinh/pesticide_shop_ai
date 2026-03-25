<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('supplier/update/' . $supplier->SupplierID) ?>" method="post" class="box" enctype="multipart/form-data">
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
                                    <input name="Name" value="<?php echo set_value('Name', $supplier->Name) ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <small class="text-danger"><?php echo form_error('Name'); ?></small>
                                </div>


                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên người đại diện<span class="text-danger">*</span></label>
                                    <input name="Contact" value="<?php echo set_value('Contact', $supplier->Contact) ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <small class="text-danger"><?php echo form_error('Contact'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Số điện thoại nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Phone" value="<?php echo set_value('Phone', $supplier->Phone) ?>" type="text"
                                        class="form-control" placeholder="Nhập tên nhà cung cấp">

                                    <small class="text-danger"><?php echo form_error('Phone'); ?></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Địa chỉ nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Address" value="<?php echo set_value('Address', $supplier->Address) ?>" type="text"
                                        class="form-control" placeholder="Nhập địa chỉ nhà cung cấp">

                                    <small class="text-danger"><?php echo form_error('Address'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Email nhà cung cấp<span class="text-danger">*</span></label>
                                    <input name="Email" value="<?php echo set_value('Email', $supplier->Email) ?>" type="text"
                                        class="form-control" placeholder="abc@gmail.com">

                                    <small class="text-danger"><?php echo form_error('Email'); ?></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo ($supplier->Status == 1) ? 'selected' : '' ?>>Kích hoạt
                                        </option>
                                        <option value="0" <?php echo ($supplier->Status == 0) ? 'selected' : '' ?>>Không kích hoạt
                                        </option>
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