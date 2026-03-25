<!-- <form id="filterForm" action="" method="get" class="mt20">
    <div class="filter-wapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <?php
                    $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 1;
                    ?>
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <select name="perpage" class="form-control input-sm perpage filter mr10 setupSelect2">
                            <?php for ($i = 10; $i <= 100; $i += 10) { ?>
                                <option <?php echo ($perpage == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>">
                                    <?php echo $i; ?> bản ghi
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="mr10 filter-date-order">
                        <label for="date_from">Chọn ngày bắt đầu</label>
                        <input type="date" name="date_from" id="date_from"
                            value="<?php echo isset($date_from) ? $date_from : ''; ?>" class="form-control" style="width: 150px;">
                    </div>

                    <div class="mr10 filter-date-order">
                        <label for="date_to">Chọn ngày kết thúc</label>
                        <input type="date" name="date_to" id="date_to"
                            value="<?php echo isset($date_to) ? $date_to : ''; ?>" class="form-control" style="width: 150px;">
                    </div>
                    <div class="">
                        <?php
                        $status = isset($status) ? $status : '';
                        $statusOptions = [
                            '' => 'Tất cả trạng thái',
                            '1' => 'Active',
                            '0' => 'Inactive'
                        ];
                        ?>
                        <select name="status" class="form-control setupSelect2">
                            <?php foreach ($statusOptions as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?php echo ((string)$status === (string)$key) ? 'selected' : ''; ?>>
                                    <?php echo $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                        <div class="input-group">
                            <?php
                            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                            ?>
                            <input style="width: 250px" type="text" name="keyword" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Nhập từ khóa bạn muốn tìm kiếm..." class="form-control ml10">
                            <span class="input-group-btn">
                                <button style="border-radius: 0 5px 5px 0;" type="submit" class="btn btn-primary mb0 btn-sm">
                                    Tìm Kiếm
                                </button>
                            </span>
                        </div>
                    </div>
                    <a style="border-radius: 5px;" href="<?php echo base_url('discount-code/create') ?>" class="btn btn-danger mb0 btn-sm">
                        <i class="fa fa-plus mr5"></i>Thêm mới mã giảm giá
                    </a>
                </div>
            </div>
        </div>
    </div>
</form> -->



<form id="filterForm" action="" method="get" class="mt20">
    <div class="filter-wapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <?php
                    $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 5;
                    ?>
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <select name="perpage" class="form-control input-sm perpage filter mr10 setupSelect2">
                            <?php for ($i = 10; $i <= 100; $i += 10) { ?>
                                <option <?php echo ($perpage == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>">
                                    <?php echo $i; ?> bản ghi
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="mr10 filter-date-order">
                        <label for="date_from">Chọn ngày bắt đầu</label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>" class="form-control" style="width: 150px;">
                    </div>

                    <div class="mr10 filter-date-order">
                        <label for="date_to">Chọn ngày kết thúc</label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>" class="form-control" style="width: 150px;">
                    </div>

                    <div>
                        <select name="status" class="form-control setupSelect2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" <?php echo (isset($_GET['status']) && $_GET['status'] == 1) ? 'selected' : ''; ?>>Còn hiệu lực</option>
                            <option value="0" <?php echo (isset($_GET['status']) && $_GET['status'] == 0) ? 'selected' : ''; ?>>Đã hết hạn</option>
                        </select>
                    </div>
                    <div class="ml10">
                        <select name="Discount_type" class="form-control setupSelect2">
                            <option value="">Tất cả loại giảm giá</option>
                            <option value="Percentage" <?php echo (isset($_GET['Discount_type']) && $_GET['Discount_type'] == 'Percentage') ? 'selected' : ''; ?>>Phần trăm</option>
                            <option value="Fixed" <?php echo (isset($_GET['Discount_type']) && $_GET['Discount_type'] == 'Fixed') ? 'selected' : ''; ?>>Giảm thẳng</option>
                        </select>
                    </div>

                    <div class="uk-search uk-flex uk-flex-middle">
                        <div class="input-group">
                            <input type="text" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập từ khóa bạn muốn tìm kiếm..." class="form-control ml10" style="width: 250px;">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary mb0 btn-sm" style="border-radius: 0 5px 5px 0;">Tìm Kiếm</button>
                            </span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>
