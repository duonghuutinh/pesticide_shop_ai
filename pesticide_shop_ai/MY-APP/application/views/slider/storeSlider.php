<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('slider/store') ?>" method="post" class="box" enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin banner</div>
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
                                    <label for="" class="control-label">Tên banner<span class="text-danger">(*)</span></label>
                                    <input name="title" type="text" class="form-control" 
                                        placeholder="Nhập tên banner">
                                    <span class="text-danger"><?php echo isset($errors['title']) ? $errors['title'] : ''; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control setupSelect2">
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="image">Hình ảnh<span class="text-danger">(*)</span></label>
                                        <input name="image" type="file" class="form-control-file">
                                        <span class="text-danger">
                                            <?php
                                            if (isset($errors['image'])) echo $errors['image'];
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