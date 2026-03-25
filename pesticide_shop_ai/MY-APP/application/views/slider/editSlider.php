




<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('success') ?></div>
<?php } elseif ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
<?php } ?>

<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('slider/update/' . $slider->id) ?>" method="post" class="box"
    enctype="multipart/form-data">
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
                                    <label for="" class="control-label">Tên banner<span class="text-danger"
                                            required>(*)</span></label>
                                    <input name="title" value="<?php echo $slider->title ?>" type="text" class="form-control"
                                        id="slug" onkeyup="ChangeToSlug();" placeholder="Nhập tên banner">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control setupSelect2">
                                        <?php
                                        if ($slider->status == 1) {
                                            ?>
                                            <option selected value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="image">Hình ảnh</label>
                                        <input name="image" type="file" class="form-control-file">
                                        <img style="width: 100%; height: 150px;" src="<?php echo base_url('uploads/sliders/' . $slider->image) ?>" alt=""
                                           >
                                        <small class="text-danger"><?php if (isset($error))
                                            echo $error ?></small>
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