<form id="filterForm" action="" method="get" class="mt20">
    <div class="filter-wapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <?php 
                   
                        $perpage = isset($_GET['perpage']) ? $_GET['perpage'] : '';
                    ?>
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <select name="perpage" class="form-control input-sm perpage filter mr10 setupSelect2">
                            <?php for($i = 20; $i <= 200; $i += 20) { ?>
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
                            // Lấy giá trị publish từ GET
                            $publish = isset($_GET['publish']) ? $_GET['publish'] : '';
                            // Mảng các trạng thái xuất bản
                            $publishOptions = array(
                                1 => 'Không xuất bản',
                                2 => 'Xuất bản'
                            );
                        ?>
                        <select name="publish" class="form-control setupSelect2">
                            <?php foreach ($publishOptions as $key => $value) { ?>
                                <option <?php echo ($publish == $key) ? 'selected' : ''; ?> value="<?php echo $key; ?>">
                                    <?php echo $value; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="uk-search uk-flex uk-flex-middle mr20">
                        <div class="input-group">
                            <?php 
                                // Lấy giá trị keyword từ GET
                                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                            ?>
                            <input style="width: 250px" type="text" name="keyword" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control ml20">
                            <span class="input-group-btn">
                                <button style="border-radius: 0 5px 5px 0;" type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">
                                    Tìm Kiếm
                                </button>
                            </span>
                        </div>
                    </div>
                    <a style="border-radius: 5px;" href="<?php echo base_url('brand/create')?>" class="btn btn-danger mb0 btn-sm">
                        <i class="fa fa-plus mr5"></i>Thêm mới nhãn hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
