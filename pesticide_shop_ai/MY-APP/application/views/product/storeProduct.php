<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<form action="<?php echo base_url('product/store') ?>" method="post" class="box" enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
    
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung của sản phẩm</div>
                    <div class="panel-description">
                        - Nhập thông tin chung của sản phẩm
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Name">Tên sản phẩm<span class="text-danger">(*)</span></label>
                                    <input name="Name" type="text" class="form-control" id="slug" onkeyup="ChangeToSlug();" placeholder="Nhập tên sản phẩm" value="<?php echo set_value('Name'); ?>">
                                    <span class="text-danger"><?php echo form_error('Name'); ?></span>
                                </div>
                                <input type="hidden" name="Slug" id="convert_slug" value="<?php echo set_value('Slug'); ?>">
                               
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="BrandID">Thương hiệu<span class="text-danger">(*)</span></label>
                                    <select name="BrandID" class="form-control setupSelect2">
                                    <?php foreach ($brand as $bra): ?>
                                            <option value="<?php echo $bra->BrandID ?>" <?php echo set_select('BrandID', $bra->BrandID); ?>><?php echo $bra->Name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('BrandID'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Product_Code">Mã sản phẩm<span class="text-danger">(*)</span></label>
                                    <input name="Product_Code" type="text" class="form-control" placeholder="Ví dụ: Selecron500EC" value="<?php echo set_value('Product_Code'); ?>">
                                    <span class="text-danger"><?php echo form_error('Product_Code'); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="CategoryID">Danh mục<span class="text-danger">(*)</span></label>
                                    <select name="CategoryID" class="form-control setupSelect2">
                                        <?php foreach ($category as $cate): ?>
                                            <option value="<?php echo $cate->CategoryID ?>" <?php echo set_select('CategoryID', $cate->CategoryID); ?>><?php echo $cate->Name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('CategoryID'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Unit">Đơn vị tính<span class="text-danger">(*)</span></label>
                                    <input name="Unit" type="text" class="form-control" placeholder="Ví dụ: Hộp / Túi / Chai..." value="<?php echo set_value('Unit'); ?>">
                                    <span class="text-danger"><?php echo form_error('Unit'); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Selling_price">Giá bán<span class="text-danger">(*)</span></label>
                                    <input name="Selling_price" type="number" class="form-control" placeholder="Giá bán cao hơn giá gốc khoảng 30-50%" value="<?php echo set_value('Selling_price'); ?>">
                                    <span class="text-danger"><?php echo form_error('Selling_price'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Promotion">Khuyến mãi</label>
                                    <input name="Promotion" type="number" class="form-control" placeholder="Giảm giá (%)" value="<?php echo set_value('Promotion'); ?>">
                                    <span class="text-danger"><?php echo form_error('Promotion'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Mô tả và công dụng sản phẩm</div>
                    <div class="panel-description">
                        - Nhập mô tả và công dụng của sản phẩm
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Description">Mô tả<span class="text-danger">(*)</span></label>
                                    <textarea name="Description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm"><?php echo set_value('Description'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('Description'); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Product_uses">Công dụng của sản phẩm<span class="text-danger">(*)</span></label>
                                    <textarea name="Product_uses" class="form-control" rows="4" placeholder="Nhập công dụng sản phẩm"><?php echo set_value('Product_uses'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('Product_uses'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Trạng thái và hình ảnh sản phẩm</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo set_select('Status', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('Status', '0'); ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Image">Hình ảnh<span class="text-danger">(*)</span></label>
                                    <input name="Image" type="file" class="form-control-file">
                                    <span class="text-danger"><?php echo form_error('Image'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-4">
            <button type="submit" name="send" value="send" class="btn btn-primary">Lưu lại</button>
        </div>
    </div>
</form>