<div style="width: 50%" class="container">

    <h1 style="color: #FE980F">Nhập vào mã xác thực</h1>
    <form action="<?php echo base_url('verify-token'); ?>" method="POST">
        <input type="hidden" name="email" value="<?= $email ?>">
        <div class="form-group">
            <label for="token">Mã xác thực, lưu ý chỉ nhập mã xác thực 1 lần</label>
            <input type="text" class="form-control" id="token" name="token" placeholder="Mã xác thực gồm 9 ký tự" required>
        </div>
        <button style="margin-bottom: 100px" type="submit" class="btn btn-primary">Xác thực</button>
    </form>
</div>