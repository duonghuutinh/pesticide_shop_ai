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
                        <select name="sort_totalamount" class="form-control setupSelect2">
                            <option value="">-- Sắp xếp lượng chi tiêu --</option>
                            <option value="desc" <?= ($this->input->get('sort_totalamount') == 'desc') ? 'selected' : '' ?>>Cao đến thấp</option>
                            <option value="asc" <?= ($this->input->get('sort_totalamount') == 'asc') ? 'selected' : '' ?>>Thấp đến cao</option>
                        </select>
                    </div>
                    <div class="mr20">
                        <?php
                        $status = isset($status) ? $status : '';
                        $statusOptions = [
                            '' => 'Tất cả trạng thái',
                            '1' => 'Bình thường',
                            '0' => 'Bị khoá'
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
                    <div class="">
                        <?php
                        $this->load->model('customerModel');
                        $roles = $this->customerModel->getAllRole();
                        ?>
                        <select name="role_id" class="form-control setupSelect2 mr20">
                            <option value="">Tất cả vai trò</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->Role_ID; ?>" <?php echo ($role_id == $role->Role_ID) ? 'selected' : ''; ?>>
                                    <?php echo $role->Role_name; ?>
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
                                placeholder="Tên / Email / SĐT" class="form-control ml20">
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