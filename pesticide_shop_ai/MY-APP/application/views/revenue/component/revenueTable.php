<h1>Thống kê ngày hôm nay: <?= number_format($revenue_today->TotalRevenue, 0, ',', '.') ?> VNĐ</h1>
<h1>Thống kê theo tháng này: <?= number_format($revenue_month->TotalRevenue, 0, ',', '.') ?> VNĐ</h1>
<h1>Thống kê theo năm nay: <?= number_format($revenue_year->TotalRevenue, 0, ',', '.') ?> VNĐ</h1>
<br><br>

<!-- Thống kê theo ngày cụ thể -->
<form method="GET">
    <label>Chọn ngày:</label>
    <input type="date" name="date" value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>">
    <button type="submit">Thống kê</button>
</form>
<h1>Doanh thu ngày <?= isset($_GET['date']) ? $_GET['date'] : '' ?>: <?= isset($revenue_by_date->TotalRevenue) ? number_format($revenue_by_date->TotalRevenue, 0, ',', '.') : 'N/A' ?> VNĐ</h1>

<br><br>

<!-- Thống kê theo khoảng ngày -->
<form method="GET">
    <label>Ngày bắt đầu:</label>
    <input type="date" name="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
    <label>Ngày kết thúc:</label>
    <input type="date" name="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
    <button type="submit">Thống kê</button>
</form>

<?php if (isset($revenue_by_date_range)) : ?>
    <h1>Thống kê từ <?= $_GET['start_date'] ?> đến <?= $_GET['end_date'] ?>:</h1>
    <ul>
        <?php foreach ($revenue_by_date_range as $row) : ?>
            <li><?= $row->Date ?>: <?= number_format($row->TotalRevenue, 0, ',', '.') ?> VNĐ</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<br><br>

<!-- Thống kê theo khoảng tháng -->
<form method="GET">
    <label>Tháng bắt đầu:</label>
    <input type="month" name="start_month" value="<?= isset($_GET['start_month']) ? $_GET['start_month'] : '' ?>">
    <label>Tháng kết thúc:</label>
    <input type="month" name="end_month" value="<?= isset($_GET['end_month']) ? $_GET['end_month'] : '' ?>">
    <button type="submit">Thống kê</button>
</form>

<?php if (isset($revenue_by_month_range)) : ?>
    <h1>Thống kê từ <?= $_GET['start_month'] ?> đến <?= $_GET['end_month'] ?>:</h1>
    <ul>
        <?php foreach ($revenue_by_month_range as $row) : ?>
            <li>Tháng <?= $row->Month ?>: <?= number_format($row->TotalRevenue, 0, ',', '.') ?> VNĐ</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<br><br>

<!-- Thống kê theo khoảng năm -->
<form method="GET">
    <label>Năm bắt đầu:</label>
    <input type="number" name="start_year" min="2000" max="2100" value="<?= isset($_GET['start_year']) ? $_GET['start_year'] : '' ?>">
    <label>Năm kết thúc:</label>
    <input type="number" name="end_year" min="2000" max="2100" value="<?= isset($_GET['end_year']) ? $_GET['end_year'] : '' ?>">
    <button type="submit">Thống kê</button>
</form>

<?php if (isset($revenue_by_year_range)) : ?>
    <h1>Thống kê từ <?= $_GET['start_year'] ?> đến <?= $_GET['end_year'] ?>:</h1>
    <ul>
        <?php foreach ($revenue_by_year_range as $row) : ?>
            <li>Năm <?= $row->Year ?>: <?= number_format($row->TotalRevenue, 0, ',', '.') ?> VNĐ</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>