<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-primary pull-right">Hôm nay</span>
					<h5>Doanh thu</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins"><?= number_format($todayRevenue) ?> VNĐ</h1>
					<small>Tổng doanh thu</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-primary pull-right">Hôm nay</span>
					<h5>Lợi nhuận</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins"><?= number_format($todayProfit) ?> VNĐ</h1>
					<small>Tổng lợi nhuận</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<!-- <span class="label label-primary pull-right">Hôm nay</span> -->
					<h5>Đơn hàng</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins"><?= $todayNewOrders ?></h1>
					<small>Đơn hàng mới</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-primary pull-right">Hôm nay</span>
					<h5>Người dùng</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins"><?= $todayNewUsers ?></h1>
					<small>Người dùng mới</small>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Biểu đồ doanh thu từ tháng 1 đến tháng 12 năm <?= date('Y') ?></h5>
					</div>
					<div class="ibox-content">
						<div id="chart-container">
							<canvas id="revenueChart" width="400" height="200"></canvas>
						</div>
					</div>
				</div>

				<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
				<script>
					// Dữ liệu từ PHP
					const chartData = {
						labels: [
							<?php foreach ($profits['monthlyTotals'] as $month => $totals): ?> "<?= htmlspecialchars($month) ?>",
							<?php endforeach; ?>
						],
						revenue: [
							<?php foreach ($profits['monthlyTotals'] as $totals): ?>
								<?= $totals['Total_Revenue'] ?>,
							<?php endforeach; ?>
						],
						cost: [
							<?php foreach ($profits['monthlyTotals'] as $totals): ?>
								<?= $totals['Total_Cost'] ?>,
							<?php endforeach; ?>
						],
						profit: [
							<?php foreach ($profits['monthlyTotals'] as $totals): ?>
								<?= $totals['Total_Profit'] ?>,
							<?php endforeach; ?>
						]
					};

					document.addEventListener("DOMContentLoaded", function() {
						const ctx = document.getElementById('revenueChart').getContext('2d');
						const revenueChart = new Chart(ctx, {
							type: 'bar',
							data: {
								labels: chartData.labels,
								datasets: [{
										label: 'Doanh thu',
										data: chartData.revenue,
										backgroundColor: 'rgba(10, 120, 193, 0.7)',
										borderColor: 'rgba(10, 120, 193, 0.7)',
										borderWidth: 1
									},
									{
										label: 'Tổng vốn',
										data: chartData.cost,
										backgroundColor: 'rgba(246, 55, 55, 0.7)',
										borderColor: 'rgba(246, 55, 55, 0.7)',
										borderWidth: 1
									},
									{
										label: 'Lợi nhuận',
										data: chartData.profit,
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
											text: 'Tháng'
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
			</div>
		</div>
	</div>
</div>