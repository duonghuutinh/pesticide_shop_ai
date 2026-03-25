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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <nav class="nav nav-borders">
                <a class="nav-link" style="color: crimson;" href="<?php echo base_url('/') ?>">Trở về trang chủ</a>
                <a class="nav-link  ms-0" href="<?php echo base_url('profile-user') ?>">Chi tiết thông tin người dùng</a>
                <a class="nav-link active  ms-0"
                    href="<?php echo base_url('customer/edit/' . $profile_user->UserID) ?>">Chỉnh sửa thông tin</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row">

                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Ảnh đại diện</div>
                        <form action="<?php echo base_url('customer/update-avatar/' . $profile_user->UserID) ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body text-center">
                                <img class="img-account-profile rounded-circle mb-2"
                                    src="<?php echo base_url('uploads/user/' . $profile_user->Avatar) ?>"
                                    alt="Hình ảnh người dùng"><br>
                                <input name="Avatar" type="file" class="form-control form-control-sm" id="formFileSm">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Thông tin tài khoản</div>
                        <div class="card-body">
                            <!-- Form Group (username)-->
                            <form class="row" action="<?php echo base_url('customer/update/' . $profile_user->UserID) ?>"
                                method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername"><b>Họ và tên</b></label>
                                    <input name="Name" class="form-control" id="inputUsername" type="text"
                                        placeholder="Enter your username" value="<?php echo $profile_user->Name ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmail"><b>Email</b></label>
                                    <input name="Email" class="form-control" id="inputEmail" type="text"
                                        placeholder="Enter your email" value="<?php echo $profile_user->Email ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputAddress"><b>Địa chỉ</b></label>
                                    <input name="Address" class="form-control" id="inputAddress" type="text"
                                        placeholder="Enter your address" value="<?php echo $profile_user->Address ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPhone"><b>Số điện thoại</b></label>
                                    <input name="Phone" class="form-control" id="inputPhone" type="tel"
                                        placeholder="Enter your phone number" value="<?php echo $profile_user->Phone ?>">
                                </div>
                                <button class="btn btn-primary" type="submit">Lưu lại thay đổi</button>
                        </div>
                        </form>
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