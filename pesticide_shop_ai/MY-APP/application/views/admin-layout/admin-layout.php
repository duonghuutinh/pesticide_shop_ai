<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('admin-layout/component-admin/head'); ?>
</head>

<body>

    <div id="wrapper">
        <?php $this->load->view('admin-layout/component-admin/sidebar'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php $this->load->view('admin-layout/component-admin/nav'); ?>
            <?php $this->load->view($template); ?>
            <?php $this->load->view('admin-layout/component-admin/footer'); ?>
        </div>

    </div>

    <?php $this->load->view('admin-layout/component-admin/script'); ?>
</body>

</html>