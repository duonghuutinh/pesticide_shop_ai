<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<div class="row mt20">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div style="display: flex; justify-content: space-between" class="ibox-title title-table">
                <div class="">
                    <h2><?php echo $title ?></h2>
                </div>
                <a style="border-radius: 5px;" href="<?php echo base_url('supplier/create') ?>" class="btn btn-danger mb0 btn-sm">
                    <i class="fa fa-plus mr5"></i>Thêm mới nhà cung cấp
                </a>
            </div>
            <div class="ibox-content">
                <?php $this->load->view('supplier/component/filter'); ?>
                <?php $this->load->view('supplier/component/supplierTable'); ?>
            </div>
        </div>
    </div>
</div>