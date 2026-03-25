<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('discount-code/storage') ?>" method="post" class="box">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin mã giảm giá</div>
                    <div class="panel-description">
                        - Nhập thông tin chung của mã giảm giá
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
                                    <label for="Discount_type">Loại giảm giá (phần trăm hoặc giá tiền)<span class="text-danger">(*)</span></label>
                                    <select name="Discount_type" class="form-control setupSelect2">
                                        <option value="Percentage" <?php echo set_select('Discount_type', 'Percentage'); ?>>Phần trăm</option>
                                        <option value="Fixed" <?php echo set_select('Discount_type', 'Fixed'); ?>>Giảm thẳng vào tổng tiền</option>
                                    </select>
                                    <span class="text-danger">
                                        <?php echo form_error('Discount_type'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Discount_value" class="control-label text-left">Giá trị mã giảm giá<span class="text-danger">(*)</span></label>
                                    <input name="Discount_value" type="text" class="form-control" placeholder="Giá trị mã giảm giá (10%) hoặc (1000VNĐ)" value="<?php echo set_value('Discount_value'); ?>">
                                    <span class="text-danger">
                                        <?php echo form_error('Discount_value'); ?>
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Min_order_value" class="control-label text-left">Giá trị đơn tối thiểu<span class="text-danger">(*)</span></label>
                                    <input name="Min_order_value" type="text" class="form-control" placeholder="Ví dụ: 100000" value="<?php echo set_value('Min_order_value'); ?>">
                                    <span class="text-danger">
                                        <?php echo form_error('Min_order_value'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Start_date">Ngày bắt đầu hiệu lực<span class="text-danger">(*)</span></label>
                                        <input name="Start_date" type="date" class="form-control" value="<?php echo set_value('Start_date'); ?>">
                                        <span class="text-danger">
                                            <?php echo form_error('Start_date'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="End_date">Ngày hết hiệu lực<span class="text-danger">(*)</span></label>
                                        <input name="End_date" type="date" class="form-control" value="<?php echo set_value('End_date'); ?>">
                                        <span class="text-danger">
                                            <?php echo form_error('End_date'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo set_select('Status', '1'); ?>>Active</option>
                                        <option value="0" <?php echo set_select('Status', '0'); ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Number_of_discount_codes" class="control-label text-left">Số lượng mã giảm giá<span class="text-danger">(*)</span></label>
                                    <input name="Number_of_discount_codes" type="number" class="form-control" min="1" max="100" placeholder="Ví dụ: 10 - 100" value="<?php echo set_value('Number_of_discount_codes'); ?>">
                                    <span class="text-danger">
                                        <?php echo form_error('Number_of_discount_codes'); ?>
                                    </span>
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
    </div>
</form>