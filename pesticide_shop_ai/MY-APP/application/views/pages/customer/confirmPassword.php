<div style="width: 50%" class="container">
            <?php if($this->session->flashdata('success')) { ?>
				<div class="alert alert-success"><?php echo $this->session->flashdata('success') ?></div>
			<?php } elseif($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
			<?php } ?>
    <h1 style="color: #FE980F">Nhập mật khẩu để tiếp tục</h1>
    <form action="<?php echo base_url('enterPasswordNow'); ?>" method="POST">
        <div class="form-group">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="password" class="form-control" id="password1" name="password" placeholder="Nhập vào mật khẩu" required>
        <br>

        <button style="margin-bottom: 100px" type="submit" class="btn btn-primary">Xác nhận</button>
    </form>
</div>