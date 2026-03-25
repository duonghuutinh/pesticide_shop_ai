<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>

<div style="display: flex; justify-content: space-between" class="ibox-title title-table">
    <div>
        <h2>Danh sách sản phẩm theo lô hàng</h2>
    </div>
</div>

<!-- Input tìm kiếm -->
<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control width300 mb10" placeholder="Tìm kiếm mã sản phẩm hoặc tên sản phẩm...">
    </div>
</div>

<div class="ibox-content">
    <div class="table-responsive">
        <table id="productTable" class="table table-bordered table-batches table-striped table-bordered mt20 mb20">
            <thead class="table-light">
                <tr>
                    <th class="align-top">STT</th>
                    <th class="align-top">Tên sản phẩm</th>
                    <th class="align-top">Mã sản phẩm</th>
                    <th class="align-top">Chi tiết lô hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($batches)): ?>
                    <?php foreach ($batches as $index => $product): ?>
                        <tr class="product-row">
                            <td class="align-top"><?= $index + 1 ?></td>
                            <td class="align-top product-name">
                                <a href="<?php echo base_url('product/edit/' . $product['ProductID']) ?>"><?= htmlspecialchars($product['Product_Name']) ?></a>
                            </td>
                            <td class="align-top product-code"><?= htmlspecialchars($product['Product_Code']) ?></td>
                            <td>
                                <table class="table table-sm table-bordered table-sub">
                                    <thead class="table-secondary text-center">
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã lô hàng</th>
                                            <th>Giá nhập</th>
                                            <th>Số lượng</th>
                                            <th>Tổng chi phí</th>
                                            <th>Đã bán</th>
                                            <th>Doanh thu</th>
                                            <th>Số tiền cần hoàn vốn</th>
                                            <th>Lợi nhuận</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($product['Batches'] as $batchIndex => $batch): ?>
                                            <?php
                                            $remainingAmount = $batch['Remaining_Amount'];
                                            $profit = ($remainingAmount < 0) ? abs($remainingAmount) : 0; // Tiền lời
                                            $remainingAmountDisplay = ($remainingAmount < 0) ? 0 : $remainingAmount; // Nếu âm thì hiển thị 0
                                            ?>
                                            <tr>
                                                <td><?= $batchIndex + 1 ?></td>
                                                <td><?= htmlspecialchars($batch['Batch_ID']) ?></td>
                                                <td><?= number_format($batch['Import_price']) ?> VND</td>
                                                <td><?= htmlspecialchars($batch['Total_Quantity']) ?></td>
                                                <td><?= number_format($batch['Total_Cost']) ?> VND</td>
                                                <td><?= htmlspecialchars($batch['Total_Sold']) ?></td>
                                                <td><?= number_format($batch['Total_Revenue']) ?> VND</td>
                                                <td><?= number_format($remainingAmountDisplay) ?> VND</td> <!-- Số tiền cần hoàn vốn -->
                                                <td><?= number_format($profit) ?> VND</td> <!-- Tiền lời -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-danger fw-bold">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script tìm kiếm -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.trim().toUpperCase();
        const rows = document.querySelectorAll('#productTable tbody .product-row');

        rows.forEach(row => {
            const productNameElement = row.querySelector('.product-name');
            const productCodeElement = row.querySelector('.product-code');

            // Kiểm tra nếu phần tử tồn tại trước khi truy cập textContent
            const productName = productNameElement ? productNameElement.textContent.trim().toUpperCase() : '';
            const productCode = productCodeElement ? productCodeElement.textContent.trim().toUpperCase() : '';

            // Kiểm tra nếu từ khóa khớp với Tên sản phẩm hoặc Mã sản phẩm
            if (productName.includes(filter) || productCode.includes(filter)) {
                row.style.display = ''; // Hiển thị hàng
            } else {
                row.style.display = 'none'; // Ẩn hàng
            }
        });
    });
</script>