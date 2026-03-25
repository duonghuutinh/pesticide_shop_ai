<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>ĐĂNG NHẬP VỚI TÀI KHOẢN CỦA BẠN</h2>
						<form action="<?php echo base_url('login-customer')?>" method="POST">
							<input type="email" name="email" placeholder="Nhập vào email" />
							<?php echo form_error('email'); ?>
							<input type="password" name="password" placeholder="Nhập vào mật khẩu" />
							<?php echo form_error('password'); ?>
							<div style="display: flex; align-items: center;" class="">
							<button type="submit" class="btn btn-default">Đăng nhập</button>
							<a style="margin-left: 10px; margin-top: 20px" href="<?php echo base_url('forgot-password-layout')?>"><u>Quên mật khẩu</u></a>
							</div>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">HOẶC</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>ĐĂNG KÝ TÀI KHOẢN MỚI</h2>
						<form action="<?php echo base_url('dang-ky')?>" method="POST">
							<input type="text" name="fullname" placeholder="Họ tên"/>
							<?php echo form_error('fullname'); ?>
							<input type="text" name="phone" placeholder="Số điện thoại"/>
							<?php echo form_error('phone'); ?>
							<input type="text" name="address" placeholder="Số 120, xã An Hiệp, Châu thành, Đồng Tháp"/>
							<?php echo form_error('address'); ?>
							<input type="email" name="email" placeholder="abc@gamil.com"/>
							<?php echo form_error('email'); ?>
							<input type="password" name="password" placeholder="Mật khẩu ít nhất 6 ký tự"/>
							<?php echo form_error('password'); ?>
							<div style="display: flex;">
								<button type="submit" class="btn btn-default">Đăng ký</button>
								
							</div>
							
						</form>
						
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->