

<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<div class="row mt20">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div style="display: flex; justify-content: space-between" class="ibox-title title-table">
                <div class=""><h2><?php echo $title ?></h2></div>
                <a href="<?php echo base_url('discount-code/create') ?>" class="btn btn-danger mb0 btn-sm" style="border-radius: 5px;">
                        <i class="fa fa-plus mr5"></i> Thêm mới mã giảm giá
                    </a>
            </div>
            <div class="ibox-content">
                <?php $this->load->view('discount/component/filter'); ?>
                <?php $this->load->view('discount/component/discountTable'); ?>
            </div>
        </div>
    </div>
</div>
