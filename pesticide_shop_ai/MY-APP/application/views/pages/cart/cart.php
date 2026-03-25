<section  id="cart_items">
	<div class="container">
		<?php $this->load->view("pages/component/breadcrumb.php");?>
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
											<?php
											if ($items['qty'] > $items['options']['in_stock']) {
												?>
												<input class="cart_quantity_input" type="number" min="1" name="quantity"
													value="<?php echo $items['options']['in_stock'] ?>" autocomplete="off">
												<?php
											} else {
												?>
												<input class="cart_quantity_input" type="number" min="1" name="quantity"
													value="<?php echo $items['qty'] ?>" autocomplete="off">
												<?php
											}
											?>
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
								<td class="cart_delete">
									<a class="cart_quantity_delete"
										href="<?php echo base_url('delete-item/' . $items['rowid']) ?>"><i
											class="fa fa-times"></i></a>
								</td>
							</tr>


							<?php
						}
						?>

					</tbody>

				</table>
				<div style="position: relative; width: 100%; height: 100px">

			
				<div style=" display: flex; position: absolute; right: 15px; top: -10px;">
                        <h3>TỔNG THANH TOÁN:<h3 style="color: #FE980F; margin-left: 10px">
                        <?php echo number_format($total,0, ',','.') ?> VNĐ</h3></h3>
						
                </div>

				<div style=" display: flex; position: absolute; right: 15px; top: 55px;">	
				<a style="margin-right: 30px" href="<?php echo base_url('delete-all-cart') ?>"
							class="btn btn-danger">Xóa tất cả</a>
				<a href="<?php echo base_url('checkout') ?>" class="btn btn-success">Đặt hàng</a>
				</div>
				


						
				</div>
				
				<?php
			} else {
				echo '<span class="text text-danger">Hãy thêm sản phẩm vào giỏ hàng</span>';
			}

			?>
		</div>
	</div>
</section> <!--/#cart_items-->