<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title><?php echo $this->config->config['pageTitle'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url('frontend/image/icon-logo.png') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url('frontend/css/main.css') ?>" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            background-color: #f2f6fc;
            color: #69707a;
        }

        .img-account-profile {
            height: 10rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }

        .card .card-header {
            font-weight: 500;
        }

        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }

        .form-control,
        .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }

        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
    </style>
</head>

<body>
<div id="loader" class="loader"></div>
    <div class="container-xl px-4 mt-4">
        <h1>Thông tin tài khoản</h1>
        <?php if (isset($profile_user)) { ?>
            <nav style="font-size: 16px" class="nav nav-borders">
                <a class="nav-link" style="color: crimson;" href="<?php echo base_url('/') ?>">Trở về trang
                    chủ</a>
                <a class="nav-link active   ms-0" href="<?php echo base_url('profile-user/') ?>">Chi tiết
                    thông tin người dùng</a>
                <a class="nav-link ms-0" href="<?php echo base_url('customer/edit/' . $profile_user->UserID) ?>"
                   >Chỉnh sửa thông tin</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row">
                <div class="col-xl-6">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Ảnh đại diện</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2"
                                src="<?php echo base_url('uploads/user/' . $profile_user->Avatar) ?>"
                                alt="Hình ảnh người dùng">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Thông tin tài khoản</div>

                        <div class="card-body">
                            <form>
                                <!-- Form Group (username) -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">
                                        <p><b>Họ và tên: </b><?php echo $profile_user->Name; ?></p>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmail">
                                        <p><b>Email: </b><?php echo $profile_user->Email; ?></p>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputAddress">
                                        <p><b>Địa chỉ: </b><?php echo $profile_user->Address; ?></p>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPhone">
                                        <p><b>SĐT: </b><?php echo $profile_user->Phone; ?></p>
                                    </label>
                                </div>
                                <!-- Save changes button -->
                                <div class="d-flex">
                                <div class="">
                                    <a style="width: 10px" href="<?php echo base_url('customer/edit/' . $profile_user->UserID) ?>">
                                        <button class="btn btn-primary" type="button">Chỉnh sửa</button>
                                    </a>
                                </div>
                                <div class="">
                                    <a style="margin-left: 10px" href="<?php echo base_url('confirmPassword') ?>">
                                        <button onclick="return confirm('Bạn chắc chắn muốn đổi mật khẩu?')" class="btn btn-primary" type="button">Đổi mật khẩu</button>
                                    </a>

                                </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>
<script>
	// Hiển thị vòng xoay khi trang được tải lại
	window.addEventListener('beforeunload', function () {
		document.getElementById('loader').style.display = 'block';
	});

</script>
</html>