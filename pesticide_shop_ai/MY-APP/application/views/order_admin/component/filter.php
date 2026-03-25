<form id="filterForm" action="" method="get" class="mt20">
    <div class="filter-wapper mb10  ">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">

            <!-- Bộ lọc số bản ghi -->
            <div class="perpage">
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
                    <div class="mr10 filter-date-order">
                        <label for="date_from">Chọn ngày bắt đầu</label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo $date_from; ?>" class="form-control" style="width: 150px;">
                    </div>

                    <div class="mr10 filter-date-order">
                        <label for="date_to">Chọn ngày kết thúc</label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo $date_to; ?>" class="form-control" style="width: 150px;">
                    </div>

                    <div class="mr10">
                        <?php $payment = isset($_GET['checkout_method']) ? $_GET['checkout_method'] : ''; ?>
                        <select name="checkout_method" class="form-control setupSelect2">
                            <option value="">Tất cả phương thức</option>
                            <option value="COD" <?php echo ($payment === 'COD') ? 'selected' : ''; ?>>COD</option>
                            <option value="VNPAY" <?php echo ($payment === 'VNPAY') ? 'selected' : ''; ?>>VNPAY</option>
                            <!-- <option value="MOMO" <?php echo ($payment === 'MOMO') ? 'selected' : ''; ?>>MOMO</option> -->
                        </select>
                    </div>

                    <div class="mr10">
                        <?php $status = isset($_GET['status']) ? $_GET['status'] : ''; ?>
                        <select name="status" class="form-control setupSelect2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="-1" <?php echo ($status === '-1') ? 'selected' : ''; ?>>Đơn hàng mới</option>
                            <option value="1" <?php echo ($status === '1') ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="2" <?php echo ($status === '2') ? 'selected' : ''; ?>>Chuẩn bị hàng</option>
                            <option value="3" <?php echo ($status === '3') ? 'selected' : ''; ?>>Đã giao đơn vị vận chuyển</option>
                            <option value="4" <?php echo ($status === '4') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="5" <?php echo ($status === '5') ? 'selected' : ''; ?>>Đã huỷ</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort_order" class="form-control setupSelect2">
                            <option value="">-- Sắp xếp theo thời gian --</option>
                            <option value="desc" <?= ($this->input->get('sort_order') == 'desc') ? 'selected' : '' ?>>Mới nhất đến cũ nhất</option>
                            <option value="asc" <?= ($this->input->get('sort_order') == 'asc') ? 'selected' : '' ?>>Cũ nhất đến mới nhất</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="filter-wapper float-right">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="action">
                <div class="uk-flex uk-flex-middle mb10">
                    <div class="mr10">
                        <select name="sort_total_amount" class="form-control setupSelect2">
                            <option value="">-- Sắp xếp tổng tiền --</option>
                            <option value="asc" <?= ($this->input->get('sort_total_amount') == 'asc') ? 'selected' : '' ?>>Tổng tiền tăng dần</option>
                            <option value="desc" <?= ($this->input->get('sort_total_amount') == 'desc') ? 'selected' : '' ?>>Tổng tiền giảm dần</option>
                        </select>
                    </div>
                    <div class="uk-search uk-flex uk-flex-middle">
                        <div class="input-group">
                            <?php $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>
                            <input style="width: 250px" type="text" name="keyword"
                                value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Mã đơn, tên, sđt, địa chỉ,..." class="form-control">
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