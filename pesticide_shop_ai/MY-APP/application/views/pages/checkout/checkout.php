<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Checkout</li>
			</ol>
		</div>
		<div class="table-responsive cart_info">
			<?php
			if ($this->cart->contents()) {
			?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td scope="col" class="description">Image</td>
							<td scope="col" class="image">Item</td>
							<td scope="col" class="price">Price</td>
							<td scope="col" class="quantity">Quantity</td>
							<td scope="col" class="in_stock">In Stock</td>
							<td scope="col" class="total">Total</td>
							<td scope="col"></td>
						</tr>
					</thead>
					<tbody>
						<?php
						$subtotal = 0;
						$total = 0;
						foreach ($this->cart->contents() as $items) {
							$subtotal = $items['qty'] * $items['price'];
							$total += $subtotal;
						?>
							<tr>
								<td style="width: 200px;" class="cart_product">
									<img src="<?php echo base_url('uploads/product/' . $items['options']['image']) ?>"
										width="150" height="150" alt="<?php echo $items['name'] ?>">
								</td>
								<td style="width: 200px;" class="cart_description">
									<h4>
										<p><?php echo $items['name'] ?></p>
									</h4>
								</td>
								<td class="cart_price">
									<p><?php echo number_format($items['price'], 0, ',', '.') ?> VND</p>
								</td>
								<td class="cart_quantity">
									<form action="<?php echo base_url('update-cart-item') ?>" method="POST">

										<div class="cart_quantity_button">
											<input type="hidden" value="<?php echo $items['rowid'] ?>" name="rowid">
											<input class="cart_quantity_input" type="number" min="1" name="quantity"
												value="<?php echo $items['qty'] ?>" autocomplete="off">
											<input type="submit" name="capnhat" class="btn btn-warning"
												value="Cập nhật"></input>

										</div>
									</form>
								</td>
								<td class="in_stock">
									<p><?php echo $items['options']['in_stock'] ?></p>
								</td>
								<td class="cart_total">
									<p class="cart_total_price"><?php echo number_format($subtotal, 0, ',', '.') ?> VND</p>
								</td>

							</tr>

						<?php
						}
						?>
					</tbody>
				</table>
				<div class="coupon_wrapper">
					<div class="coupon_code">
						<form method="POST" action="<?php echo base_url('apply-coupon'); ?>">
							<div class="display-flex">
								<div class="mt15">
									<input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" class="form-control" style="width: 200px;">
								</div>
								<div class="">
									<button type="submit" class="btn btn-primary">Áp dụng</button>
								</div>
								
							</div>
						</form>
						<div>
							<h3>
								TỔNG THANH TOÁN:
								<span style="color: #FE980F;">
									<?php echo number_format($total, 0, ',', '.') ?> VNĐ
								</span>
							</h3>

							<?php if ($this->session->userdata('coupon_discount')): ?>
								<h4>
									Giảm giá:
									<span style="color: green;">
										-<?php echo number_format($this->session->userdata('coupon_discount'), 0, ',', '.') ?> VNĐ
									</span>
								</h4>
								<h3>
									TỔNG SAU GIẢM:
									<span style="color: #FE980F;">
										<?php echo number_format($total - $this->session->userdata('coupon_discount'), 0, ',', '.') ?> VNĐ
									</span>
								</h3>
							<?php endif; ?>
						</div>

					</div>
				</div>

			<?php
			} else {
				echo '<span class="text text-danger">Hãy thêm sản phẩm vào giỏ hàng</span>';
			}

			?>
		</div>
		<section id="form"><!--form-->
			<h1 style="text-align: center">VUI LÒNG ĐIỀN THÔNG TIN BÊN DƯỚI</h1>
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-form"><!--login form-->

							<form action="confirm-checkout-method" onsubmit="return confirm('Xác nhận đặt hàng')"
								method="POST">
								<label>Name</label>
								<input type="text" name="name" placeholder="Name" />
								<?php echo form_error('name'); ?>
								<label>Address</label>
								<input type="text" name="address" placeholder="Address" />
								<?php echo form_error('address'); ?>
								<label>Phone</label>
								<input type="text" name="phone" placeholder="Phone" />
								<?php echo form_error('phone'); ?>
								<label>Email</label>
								<input type="text" name="email" placeholder="Email" />
								<?php echo form_error('email'); ?>
								<label>Hình thức thanh toán</label> <br>
								<select style="width: 100px" class="" name="checkout_method" id="">
									<option value="COD">COD</option>
									<option value="VNPAY">VNPAY</option>
								</select>
								<button type="submit" class="btn btn-default">Xác nhận thanh toán</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

</section>