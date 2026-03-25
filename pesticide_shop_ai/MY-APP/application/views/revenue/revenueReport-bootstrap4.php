<div class="mt20 animated fadeInRight">
	<div class="ibox">
		<div class="ibox-content">
			<div class="container-fluid">
				<div class="row mb-4 text-center">
					<h1 class="font-weight-bold text-primary">Báo cáo doanh thu</h1>
				</div>
				<div class="row mb-4">
					<form method="GET" action="<?php echo base_url('revenueReport') ?>">
						<div class="row">
							<div class="col-md-3">
								<label for="time-type" class="font-weight-bold">Chọn loại thời gian</label>
								<select class="form-control" id="time-type">
									<option value="day">Theo ngày</option>
									<option value="month">Theo tháng</option>
									<option value="year">Theo năm</option>
								</select>
							</div>
							<div class="col-md-3">
								<label for="start-date" class="font-weight-bold">Chọn ngày bắt đầu</label>
								<input name="start_date" type="date" class="form-control" id="start-date"
									value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
							</div>
							<div class="col-md-3">
								<label for="end-date" class="font-weight-bold">Chọn ngày kết thúc</label>
								<input name="end_date" type="date" class="form-control" id="end-date"
									value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 mt20 text-center">
								<button type="submit" class="btn btn-primary btn-block">Xem báo cáo</button>
							</div>
						</div>
					</form>
				</div>

				<!-- Hiển thị tổng doanh thu, tổng vốn, lợi nhuận -->
				<div class="row mt20 text-center">
					<div class="col-lg-4">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa-solid fa-dollar-sign fa-2x text-success"></i>
								<h5 class="mt-2">Doanh thu</h5>
								<p class="font-weight-bold text-primary">
									<?= isset($profits['totalRevenueAll']) ? number_format($profits['totalRevenueAll']) . ' VND' : '0 VND' ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa-solid fa-dollar-sign fa-2x text-warning"></i>
								<h5 class="mt-2">Tổng vốn</h5>
								<p class="font-weight-bold text-primary">
									<?= isset($profits['totalCostAll']) ? number_format($profits['totalCostAll']) . ' VND' : '0 VND' ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="card shadow-sm">
							<div class="card-body">
								<i class="fa-solid fa-dollar-sign fa-2x text-danger"></i>
								<h5 class="mt-2">Lợi nhuận</h5>
								<p class="font-weight-bold text-primary">
									<?= isset($profits['totalProfitAll']) ? number_format($profits['totalProfitAll']) . ' VND' : '0 VND' ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-4">
				<!-- Tabs -->
				<ul class="nav nav-tabs" id="myTabs">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tab1">Tổng quan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " data-toggle="tab" href="#tab2">Chi tiết</a>
					</li>
				</ul>
				<!-- Nội dung của Tabs -->

				<div class="tab-content mt-3">
					<!-- Tab 1: Báo cáo doanh thu -->
					<div id="tab1" class="tab-pane fade ">
						<?php if (!empty($profits['dailyTotals'])): ?>
							<canvas id="revenueChart" width="300" height="200"></canvas>
						<?php else: ?>
							<p class="text-center text-danger font-weight-bold mt20">Không có dữ liệu</p>
						<?php endif; ?>
					</div>

					<!-- Tab 2: Danh sách sản phẩm -->
					<div id="tab2" class="tab-pane fade">
						<h3 class="text-success">Danh sách sản phẩm</h3>
						<p>Đây là nội dung danh sách sản phẩm.</p>
						<div class="float-right row mb-3">
							<div class="col-md-6">
								<input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm mã đơn hàng...">
							</div>
						</div>
						<script>
							document.getElementById('searchInput').addEventListener('keyup', function() {
								const filter = this.value.toUpperCase();
								const rows = document.querySelectorAll('#tab2 tbody tr');
								rows.forEach(row => {
									const orderCode = row.cells[0].textContent || row.cells[0].innerText;
									row.style.display = orderCode.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
								});
							});
						</script>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Mã đơn hàng</th>
									<th>Ngày thanh toán</th>
									<th>Doanh thu</th>
									<th>Chi phí</th>
									<th>Lợi nhuận</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($profits['orderProfits'])): ?>
									<?php foreach ($profits['orderProfits'] as $order): ?>
										<tr>
											<td><?= htmlspecialchars($order->Order_Code) ?></td>
											<td><?= htmlspecialchars($order->Payment_Date) ?></td>
											<td><?= number_format($order->Total_Revenue) ?> VND</td>
											<td><?= number_format($order->Total_Cost) ?> VND</td>
											<td><?= number_format($order->Total_Profit) ?> VND</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="5" class="text-center">Không có dữ liệu</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		console.log("Script đã được tải"); // Kiểm tra script có chạy không

		const timeTypeSelect = document.getElementById("time-type");
		const startDateInput = document.getElementById("start-date");
		const endDateInput = document.getElementById("end-date");

		if (!timeTypeSelect || !startDateInput || !endDateInput) {
			console.error("Không tìm thấy phần tử HTML");
			return;
		}

		timeTypeSelect.addEventListener("change", function() {
			console.log("Sự kiện change đã được kích hoạt"); // Kiểm tra sự kiện
			const selectedValue = timeTypeSelect.value;
			console.log("Loại thời gian được chọn:", selectedValue);

			if (selectedValue === "day") {
				startDateInput.type = "date";
				endDateInput.type = "date";
				console.log("Đã chuyển sang định dạng ngày");
			} else if (selectedValue === "month") {
				startDateInput.type = "month";
				endDateInput.type = "month";
				console.log("Đã chuyển sang định dạng tháng");
			} else if (selectedValue === "year") {
				startDateInput.type = "number";
				endDateInput.type = "number";
				startDateInput.placeholder = "Nhập năm bắt đầu";
				endDateInput.placeholder = "Nhập năm kết thúc";
				startDateInput.min = "1900";
				startDateInput.max = "2100";
				endDateInput.min = "1900";
				endDateInput.max = "2100";
				console.log("Đã chuyển sang định dạng năm");
			}
		});
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	// Dữ liệu từ PHP
	const chartData = {
		labels: [
			<?php foreach ($profits['dailyTotals'] as $date => $totals): ?> "<?= htmlspecialchars($date) ?>",
			<?php endforeach; ?>
		],
		revenue: [
			<?php foreach ($profits['dailyTotals'] as $totals): ?>
				<?= $totals['Total_Revenue'] ?>,
			<?php endforeach; ?>
		],
		cost: [
			<?php foreach ($profits['dailyTotals'] as $totals): ?>
				<?= $totals['Total_Cost'] ?>,
			<?php endforeach; ?>
		],
		profit: [
			<?php foreach ($profits['dailyTotals'] as $totals): ?>
				<?= $totals['Total_Profit'] ?>,
			<?php endforeach; ?>
		]
	};

	document.addEventListener("DOMContentLoaded", function() {
		const ctx = document.getElementById('revenueChart').getContext('2d');
		const revenueChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: chartData.labels, // Trục X: Ngày
				datasets: [{
						label: 'Doanh thu',
						data: chartData.revenue, // Dữ liệu doanh thu
						backgroundColor: 'rgba(10, 120, 193, 0.7)',
						borderColor: 'rgba(10, 120, 193, 0.7)',
						borderWidth: 1
					},
					{
						label: 'Tổng vốn',
						data: chartData.cost, // Dữ liệu tổng vốn
						backgroundColor: 'rgba(246, 55, 55, 0.7)', 
						borderColor: 'rgba(246, 55, 55, 0.7)',
						borderWidth: 1
					},
					{
						label: 'Lợi nhuận',
						data: chartData.profit, // Dữ liệu lợi nhuận
						backgroundColor: 'rgba(48, 224, 95, 0.7)', 
						borderColor: 'rgba(48, 224, 95, 0.7)',
						borderWidth: 1
					}
				]
			},
			options: {
				responsive: true,
				scales: {
					x: {
						title: {
							display: true,
							text: 'Thời gian (Ngày)'
						}
					},
					y: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Số tiền (VND)'
						}
					}
				},
				plugins: {
					legend: {
						position: 'top'
					},
					tooltip: {
						callbacks: {
							label: function(context) {
								return context.dataset.label + ': ' + new Intl.NumberFormat().format(context.raw) + ' VND';
							}
						}
					}
				}
			}
		});
	});
</script>