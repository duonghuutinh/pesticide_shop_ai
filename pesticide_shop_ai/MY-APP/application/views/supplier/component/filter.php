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
                    <div class="mr20">
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
                    <div class="uk-search uk-flex uk-flex-middle">
                        <div class="input-group">
                            <?php
                            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                            ?>
                            <input style="width: 250px" type="text" name="keyword" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Tên nhà cung cấp / SĐT / Email" class="form-control ml20">
                            <span class="input-group-btn">
                                <button style="border-radius: 0 5px 5px 0;" type="submit" class="btn btn-primary mb0 btn-sm">
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