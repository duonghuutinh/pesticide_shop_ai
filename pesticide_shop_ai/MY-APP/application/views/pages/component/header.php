<header id="header">
	<div class="header-middle"><!--header-middle-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="logo pull-left">
						<a href="<?php echo base_url('/') ?>"><img style="width: 100px" src="<?php echo base_url('frontend/image/logo.png') ?>" alt="" />PESTICIDE SHOP</a>
					</div>

				</div>
				<div class="col-sm-8">
	<div class="shop-menu pull-right">
		<ul class="nav navbar-nav">
			<?php if ($this->session->userdata('logged_in_customer') || $this->session->userdata('logged_in_admin')): ?>
				<?php
				$session_data = $this->session->userdata('logged_in_customer') ?? $this->session->userdata('logged_in_admin');
				?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user"></i>
						<b><?php echo $session_data['username'] ?></b>
						<i class="fa-solid fa-caret-down"></i>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="text-align: center;">
						<a class="dropdown-item" href="<?php echo base_url('profile-user'); ?>">
							<h5>Thông tin cá nhân</h5>
						</a>
					</div>
				</li>

				<?php if ($this->session->userdata('logged_in_admin')): ?>
					<li>
						<a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-cogs"></i>Trang quản lý</a>
					</li>
				<?php endif; ?>

				<li>
					<a href="<?php echo base_url('checkout') ?>"><i class="fa fa-crosshairs"></i> Thanh toán</a>
				</li>
				<li>
					<a href="<?php echo base_url('dang-xuat') ?>"><i class="fa fa-lock"></i> Đăng xuất</a>
				</li>
			<?php else: ?>
				<li>
					<a href="<?php echo base_url('dang-nhap') ?>"><i class="fa fa-lock"></i> Đăng nhập</a>
				</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo base_url('gio-hang') ?>"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a>
			</li>
			<li>
				<a href="<?php echo base_url('order_customer/listOrder') ?>"><i class="fa fa-list"></i> Lịch sử đặt hàng</a>
			</li>
		</ul>
	</div>
</div>


			</div>
		</div>
	</div><!--/header-middle-->

	<div class="header-bottom"><!--header-bottom-->
		<div class="container">
			<div class="row">
				<div class="col-sm-7">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
							data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="mainmenu pull-left">
						<ul class="nav navbar-nav collapse navbar-collapse">
							<li><a href="<?php echo base_url('/') ?>" class="active">Trang chủ</a></li>
							<li class="dropdown"><a href="#">Cửa hàng<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<?php
									foreach ($category as $key => $cate) {
									?>
										<li><a
												href="<?php echo base_url('danh-muc/' . $cate->CategoryID . '/' . $cate->Slug) ?>"><?php echo $cate->Name ?></a>
										</li>
									<?php } ?>
								</ul>
							</li>
							<!-- <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
									</ul>
								</li>
								<li><a href="404.html">404</a></li>
								<li><a href="contact-us.html">Contact</a></li> -->
							<li><a href="<?php echo base_url('predict') ?>">Chẩn đoán bệnh</a></li>
							<li><a href="<?php echo base_url('product-on-sale') ?>">Sản phẩm đang được giảm giá</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="search_box pull-right">
						<form action="<?php echo base_url('search-product') ?>" method="GET">
							<input type="text" name="keyword" placeholder="Tên sản phẩm..." id="searchKeyword" value="<?php echo $this->input->get('keyword'); ?>" />
							<input type="submit" class="btn btn-default" value="Tìm kiếm" />
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</header>