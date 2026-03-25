<section>
	<div class="container">
		<div class="row">
			<?php $this->load->view('pages/component/sidebar'); ?>

			<div class="col-sm-9 padding-right">
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center"><?php echo $Name ?></h2>
					<?php
					foreach ($allproductbybrand_pagination as $key => $braPro) {
						?>
						<form action="<?php echo base_url('add-to-cart') ?>" method="POST">
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<input type="hidden" value="<?php echo $braPro->ProductID ?>" name="ProductID">
									<input type="hidden" value="1" name="Quantity">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="<?php echo base_url('uploads/product/' . $braPro->Image) ?>"
												alt="<?php echo $braPro->Name ?>" />
											<h2><?php echo number_format($braPro->Selling_price, 0, ',', '.') ?> VND</h2>
											<p><?php echo $braPro->Name ?></p>
											<a href="<?php echo base_url('san-pham/' . $braPro->ProductID . '/' . $braPro->Slug) ?>"
												class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Details</a>
											<button type="submit" class="btn btn-fefault cart">
												<i class="fa fa-shopping-cart"></i>
												Add to cart
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					<?php } ?>
					<?php echo $links ?>
				</div><!--features_items-->


			</div>
		</div>
	</div>
</section>