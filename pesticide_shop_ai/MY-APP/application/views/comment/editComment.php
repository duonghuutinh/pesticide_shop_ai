


<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<form action="<?php echo base_url('comment/update/'. $comments->id) ?>" method="post" class="box" enctype="multipart/form-data">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Cập nhật trạng thái bình luận</div>
                    <!-- <div class="panel-description">
                        - Nhập thông tin chung của nhãn hàng
                        <p>- Lưu ý: những trường được đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Tên khách hàng</label>
                                    <p><?php echo $comments->name?></p>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">Email khách hàng</label>
                                    <p><?php echo $comments->email?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="comment">Nội dung bình luận</label>
                                        <textarea name="comment" type="text" class="form-control" rows="7"
                                            placeholder="Nhập mô tả"><?php echo $comments->comment ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="status">Trạng thái</label>
                                        <select name="status" class="form-control setupSelect2">
                                            <option value="1" <?php echo ($comments->status == 1) ? 'selected' : '' ?>>Active
                                        </option>
                                        <option value="0" <?php echo ($comments->status == 0) ? 'selected' : '' ?>>Inactive
                                        </option>
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
    </div>
</form>


