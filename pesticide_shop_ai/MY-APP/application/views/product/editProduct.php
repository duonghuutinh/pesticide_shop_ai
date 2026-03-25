<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('product/update/' . $product->ProductID) ?>" method="post" class="box"
    enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung của sản phẩm</div>
                    <div class="panel-description">
                        - Nhập thông tin chung của Thông tin chung của sản phẩm
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Name">Tên sản phẩm<span class="text-danger">(*)</span></label>
                                    <input name="Name" value="<?php echo $product->Name ?>" type="text"
                                        class="form-control" id="slug" onkeyup="ChangeToSlug();"
                                        placeholder="Nhập tên sản phẩm">
                                    <input type="hidden" name="Slug" value="<?php echo $product->Slug ?>" type="text"
                                        class="form-control" id="convert_slug" placeholder="Nhập slug">
                                    <?php echo '<span class="text-danger">' . form_error('Name') . '</span>' ?>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="BrandID">Thương hiệu<span class="text-danger">(*)</span></label>
                                        <select name="BrandID" class="form-control setupSelect2">
                                            <?php foreach ($brand as $key => $bra) { ?>
                                                <option value="<?php echo $bra->BrandID ?>"
                                                    <?php echo ($product->BrandID == $bra->BrandID) ? 'selected' : '' ?>>
                                                    <?php echo $bra->Name ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <?php echo '<span class="text-danger">' . form_error('brand') . '</span>' ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Product_Code">Mã sản phẩm<span class="text-danger">(*)</span></label>
                                        <input name="Product_Code" value="<?php echo $product->Product_Code ?>"
                                            type="text" class="form-control" placeholder="Nhập mã sản phẩm">
                                        <?php echo '<span class="text-danger">' . form_error('selling_price') . '</span>' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="CategoryID">Danh mục<span class="text-danger">(*)</span></label>
                                        <select name="CategoryID" class="form-control setupSelect2">
                                            <?php foreach ($category as $key => $cate) { ?>
                                                <option value="<?php echo $cate->CategoryID ?>"
                                                    <?php echo ($product->CategoryID == $cate->CategoryID) ? 'selected' : '' ?>>
                                                    <?php echo $cate->Name ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <?php echo '<span class="text-danger">' . form_error('category') . '</span>' ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Unit">Đơn vị tính của sản phẩm<span class="text-danger">(*)</span></label>
                                        <input name="Unit" value="<?php echo $product->Unit ?>" type="text"
                                            class="form-control" placeholder="Nhập đơn vị tính">
                                        <?php echo '<span class="text-danger">' . form_error('unit') . '</span>' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Selling_price">Giá bán<span class="text-danger">(*)</span></label>
                                    <input name="Selling_price" value="<?php echo $product->Selling_price ?>"
                                        type="number" class="form-control" placeholder="Nhập giá bán">
                                    <?php echo '<span class="text-danger">' . form_error('selling_price') . '</span>' ?>
                                </div>


                            </div>
                            <div class="col-lg-6">

                                <div class="form-row">
                                    <label for="Promotion">Khuyến mãi</label>
                                    <input name="Promotion" value="<?php echo $product->Promotion ?>" type="number"
                                        class="form-control" placeholder="Giảm giá (%)">
                                    <?php echo '<span class="text-danger">' . form_error('discount') . '</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Mô tả chi tiết sản phẩm và công dụng sản phẩm</div>
                    <div class="panel-description">
                        - Nhập thông tin giá và đơn vị tính của sản phẩm
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Description">Mô tả<span class="text-danger">(*)</span></label>
                                    <textarea name="Description" class="form-control" rows="5"
                                        placeholder="Nhập mô tả sản phẩm"><?php echo $product->Description ?></textarea>
                                    <?php echo '<span class="text-danger">' . form_error('Description') . '</span>' ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Description">Công dụng của sản phẩm<span class="text-danger">(*)</span></label>
                                        <textarea name="Product_uses" class="form-control" rows="5"
                                            placeholder="Nhập mô tả sản phẩm"><?php echo $product->Product_uses ?></textarea>
                                        <?php echo '<span class="text-danger">' . form_error('Description') . '</span>' ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">
                        Trạng thái và hình ảnh sản phẩm
                    </div>
                    <!-- <div class="panel-description">
                            - Nhập thông tin mô tả và hình ảnh của sản phẩm
                            <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                        </div> -->
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Status">Trạng thái</label>
                                    <select name="Status" class="form-control setupSelect2">
                                        <option value="1" <?php echo $product->Status == 1 ? 'selected' : '' ?>>Active
                                        </option>
                                        <option value="0" <?php echo $product->Status == 0 ? 'selected' : '' ?>>
                                            Inactive
                                        </option>
                                    </select>
                                    <?php echo '<span class="text-danger">' . form_error('status') . '</span>' ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="Image">Hình ảnh<span class="text-danger">(*)</span></label>
                                    <input name="Image" type="file" class="form-control-file">
                                    <img src="<?php echo base_url('uploads/product/' . $product->Image) ?>" alt=""
                                        width="150" height="150">
                                    <small class="text-danger"><?php if (isset($error))
                                                                    echo $error ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="text-right mb15 mr20">
                <button type="submit" name="send" value="send" class="btn btn-primary">Lưu lại</button>
            </div>
        </div>

</form>