<form id="filterForm" action="" method="get" class="mt20">
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

                    <div class="mr10">
                        <select name="rating" class="form-control setupSelect2">
                            <option value="">Tất cả đánh giá</option>
                            <option value="1" <?php echo ($_GET['rating'] ?? '') == '1' ? 'selected' : ''; ?>>Đánh giá 1 sao</option>
                            <option value="2" <?php echo ($_GET['rating'] ?? '') == '2' ? 'selected' : ''; ?>>Đánh giá 2 sao</option>
                            <option value="3" <?php echo ($_GET['rating'] ?? '') == '3' ? 'selected' : ''; ?>>Đánh giá 3 sao</option>
                            <option value="4" <?php echo ($_GET['rating'] ?? '') == '4' ? 'selected' : ''; ?>>Đánh giá 4 sao</option>
                            <option value="5" <?php echo ($_GET['rating'] ?? '') == '5' ? 'selected' : ''; ?>>Đánh giá 5 sao</option>
                        </select>
                    </div>
                    <div class="mr10">
                        <select name="is_active" class="form-control setupSelect2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" <?php echo ($_GET['is_active'] ?? '') == '1' ? 'selected' : ''; ?>>Đã duyệt</option>
                            <option value="0" <?php echo ($_GET['is_active'] ?? '') == '0' ? 'selected' : ''; ?>>Chưa duyệt</option>
                        </select>
                    </div>

                    <div class="uk-search uk-flex uk-flex-middle mr20">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button style="border-radius: 5px;" type="submit" class="btn btn-primary mb0 btn-sm">
                                    Tìm Kiếm
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>