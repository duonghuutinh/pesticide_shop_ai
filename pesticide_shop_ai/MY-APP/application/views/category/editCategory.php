
<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('category/update/'.$category->CategoryID) ?>" method="post" class="box" enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin danh mục</div>
                    <div class="panel-description">
                        - Nhập thông tin chung của danh mục
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
                                    <label for="" class="control-label text-right">Tên danh mục<span
                                            class="text-danger" required>(*)</span></label>
                                    <input name="Name" value="<?php echo $category->Name ?>" type="text"
                                        class="form-control" id="slug" onkeyup="ChangeToSlug();"
                                        placeholder="Nhập tên danh mục">
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-right">Slug<span
                                            class="text-danger">(*)</span></label>
                                    <input name="Slug" value="<?php echo $category->Slug ?>" type="text"
                                        class="form-control" id="convert_slug" placeholder="Nhập slug">
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea name="Description" type="text" class="form-control" rows="7"
                                            placeholder="Nhập mô tả"><?php echo $category->Description ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Image">Hình ảnh</label>
                                        <input name="Image" type="file" class="form-control-file">
                                        <img src="<?php echo base_url('uploads/category/' . $category->Image) ?>" alt=""
                                            width="150" height="150">
                                        <small class="text-danger"><?php if (isset($error))
                                            echo $error ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="Status">Trạng thái</label>
                                        <select name="Status" class="form-control setupSelect2">
                                            <option value="1" <?php echo ($category->Status == 1) ? 'selected' : '' ?>>Active
                                        </option>
                                        <option value="0" <?php echo ($category->Status == 0) ? 'selected' : '' ?>>Inactive
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