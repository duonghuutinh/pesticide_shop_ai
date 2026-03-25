
<form id="filterForm" action="" method="get" class="mt20">
    <div class="filter-wapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage mr10">
                <?php $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 10; ?>
                <select name="perpage" class="form-control input-sm perpage filter mr10 setupSelect2">
                    <?php for ($i = 10; $i <= 100; $i += 10) { ?>
                        <option value="<?php echo $i; ?>" <?php echo ($perpage == $i) ? 'selected' : ''; ?>>
                            <?php echo $i; ?> bản ghi
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="mr10 filter-date-receive">
                        <label for="date_from">Chọn ngày bắt đầu</label>
                        <input type="date" name="start_date" class="form-control mr10" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>" placeholder="Từ ngày">
                    </div>

                    <div class="mr10 filter-date-receive">
                        <label for="date_to">Chọn ngày kết thúc</label>
                        <input type="date" name="end_date" class="form-control mr10" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>" placeholder="Đến ngày">
                    </div>
                    <div class="mr10">
                        <?php
                        $selected_supplier = $_GET['supplier_id'] ?? '';
                        ?>
                        <select name="supplier_id" class="form-control mr10 setupSelect2">
                            <option value="">Tất cả nhà cung cấp</option>
                            <?php foreach ($suppliers as $supplier): ?>
                                <option value="<?= $supplier->SupplierID ?>" <?= $selected_supplier == $supplier->SupplierID ? 'selected' : '' ?>>
                                    <?= $supplier->Name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class=" mr10">
                        <?php
                        $sort_by = $_GET['sort_by'] ?? '';
                        ?>
                        <select style="width: 180px" name="sort_by" class="form-control mr10 setupSelect2">
                            <option value="">-- Sắp xếp --</option>
                            <option value="sub_total_asc" <?= $sort_by == 'sub_total_asc' ? 'selected' : '' ?>>Tổng tiền tăng dần</option>
                            <option value="sub_total_desc" <?= $sort_by == 'sub_total_desc' ? 'selected' : '' ?>>Tổng tiền giảm dần</option>
                            <option value="total_quantity_asc" <?= $sort_by == 'total_quantity_asc' ? 'selected' : '' ?>>Tổng số lượng tăng dần</option>
                            <option value="total_quantity_desc" <?= $sort_by == 'total_quantity_desc' ? 'selected' : '' ?>>Tổng số lượng giảm dần</option>
                        </select>
                    </div>

                    <div class="uk-search uk-flex uk-flex-middle">
                        <div class="input-group">
                            <?php $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>
                            <input style="width: 250px" type="text" name="keyword"
                                value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Tên người giao / Phiếu nhập số" class="form-control">
                            <span class="input-group-btn">
                                <button style="border-radius: 0 5px 5px 0;" type="submit"
                                    class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- 
<script>
    document.querySelector('select[name="perpage"]').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
</script> -->