<div style="width: 50%" class="container">
    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success') ?></div>
    <?php } elseif ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
    <?php } ?>
    <h1 style="color: #FE980F">Nhập vào mã xác thực</h1>
    <form action="<?php echo base_url('change-password-verify-token'); ?>" method="POST">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="phone" value="<?php echo $phone; ?>">
        <div class="form-group">
            <label for="token">Mã xác thực, lưu ý chỉ nhập mã xác thực 1 lần</label>
            <input type="text" class="form-control" id="token" name="token" placeholder="Mã xác thực gồm 9 ký tự" required>
        </div>
        <button style="margin-bottom: 100px" type="submit" class="btn btn-primary">Xác thực</button>
    </form>
</div>