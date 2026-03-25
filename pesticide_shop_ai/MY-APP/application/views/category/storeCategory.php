<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('category/storage') ?>" method="post" class="box" enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin danh mục</div>
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
                                    <label for="" class="control-label text-left">Tên danh mục<span
                                            class="text-danger">(*)</span></label>
                                    <input name="Name" type="text" class="form-control"
                                        id="slug" onkeyup="ChangeToSlug();" placeholder="Nhập tên danh mục"
                                        value="<?php echo set_value('Name', isset($input['Name']) ? $input['Name'] : ''); ?>">
                                    <span class="text-danger">
                                        <?php echo isset($errors['Name']) ? $errors['Name'] : ''; ?>
                                    </span>

                                    <input name="Slug" type="hidden" class="form-control" id="convert_slug"
                                        value="<?php echo set_value('Slug', isset($input['Slug']) ? $input['Slug'] : ''); ?>">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Description">Mô tả<span
                                        class="text-danger">(*)</span></label>
                                        <textarea name="Description" type="text" class="form-control" rows="4"
                                            placeholder="Nhập mô tả danh mục"><?php echo set_value('Description', isset($input['Description']) ? $input['Description'] : ''); ?></textarea>
                                        <span class="text-danger"><?php echo isset($errors['Description']) ? $errors['Description'] : ''; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo set_select('Status', '1', isset($input['Status']) && $input['Status'] == '1'); ?>>Active</option>
                                        <option value="0" <?php echo set_select('Status', '0', isset($input['Status']) && $input['Status'] == '0'); ?>>Inactive</option>
                                    </select>

                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Image">Hình ảnh<span
                                        class="text-danger">(*)</span></label>
                                        <input name="Image" type="file" class="form-control-file">
                                        <span class="text-danger">
                                            <?php
                                            if (isset($errors['Image'])) echo $errors['Image'];
                                            elseif (isset($error)) echo $error;
                                            ?>
                                        </span>
                                    </div>
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