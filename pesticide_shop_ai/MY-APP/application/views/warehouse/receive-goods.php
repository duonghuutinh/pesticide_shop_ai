<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<a style="border-radius: 5px; margin-top: -73px;" href="<?php echo base_url('product/create') ?>" class="btn btn-danger mb0 btn-sm float-right mt10 mb10">
    <i class="fa fa-plus mr5"></i>Thêm mới sản phẩm
</a>
<form action="<?php echo base_url('warehouse/receive-goods/enter-into-warehouse') ?>" method="POST" class="box"
    enctype="multipart/form-data">
    <div class="wrapper wrapper-content-receive-goods animated fadeInRight">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-1">
                            <img style="width: 100px" src="<?php echo base_url('frontend/image/logo.png') ?>"
                                alt="LOGO">
                        </div>
                        <div style="font-size: 16px;" class="col-lg-8">

                            <label class="form-label">CÔNG TY TNHH MTV PESTICIDE STORE</label>
                            <div class="form-group-receive-goods">
                                <label class="form-label">MST <span class="text-danger">(*)</span>:</label>
                                <input type="text" name="tax_identification_number"
                                    class="input-dots input-ma-so-thue width150"
                                    value="<?php echo isset($input['tax_identification_number']) ? $input['tax_identification_number'] : '0000000000001'; ?>">
                                <span
                                    class="error-message"><?php echo isset($errors['tax_identification_number']) ? $errors['tax_identification_number'] : ''; ?></span>

                            </div>
                            <label class="form-label">Địa chỉ: 38C, đường Trần Vĩnh Kiết, Quận Ninh Kiều, TP.Cần
                                Thơ</label>

                        </div>
                        <div class="col-lg-3">
                            <h3 class="float-right">Số: <?php echo isset($receipt_number) ? $receipt_number : ''; ?>
                            </h3>
                        </div>

                    </div>
                    <div class="row">
                        <div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
                            <div class="title-receive-goods">
                                <div>
                                    <h1>PHIẾU NHẬP KHO</h1>
                                </div>
                                <div class="date align-items-center" onclick="openDatePicker()">
                                    <div>
                                        <h4 id="display-date" class="m-0"><span class="text-danger">(*)</span> Ngày...
                                            Tháng... Năm....</h4>
                                    </div>
                                    <span
                                        class="error-message-date"><?php echo isset($errors['date']) ? $errors['date'] : ''; ?>
                                    </span>
                                    <div class="select_date">
                                        <span class="ms-2" onclick="openDatePicker()">
                                            <i class="bi bi-calendar-date"></i>
                                        </span>
                                        <input type="date" name="date" id="date-picker"
                                            value="<?php echo set_value('date', isset($input['date']) ? $input['date'] : ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row receive-goods-input">
                                <div class="col-lg-6">
                                    <div class="form-group-receive-goods">
                                        <label class="form-label">Họ và tên người giao <span
                                                class="text-danger">(*)</span>:</label>
                                        <input name="ho_ten_nguoi_giao" type="text" class="input-dots"
                                            value="<?php echo set_value('ho_ten_nguoi_giao', isset($input['ho_ten_nguoi_giao']) ? $input['ho_ten_nguoi_giao'] : ''); ?>">
                                        <span
                                            class="error-message"><?php echo isset($errors['ho_ten_nguoi_giao']) ? $errors['ho_ten_nguoi_giao'] : ''; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group-receive-goods">
                                        <label class="form-label">Đơn vị <span class="text-danger">(*)</span>:</label>
                                        <input name="donvi" type="text" class="input-dots"
                                            value="<?php echo set_value('donvi', isset($input['donvi']) ? $input['donvi'] : ''); ?>">
                                        <span class="error-message">
                                            <?php echo isset($errors['donvi']) ? $errors['donvi'] : ''; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row receive-goods-input">
                                <div class="col-lg-12">
                                    <div class="form-group-receive-goods">
                                        <label class="form-label">Địa chỉ <span class="text-danger">(*)</span>:</label>
                                        <input name="address" type="text" class="input-dots"
                                            value="<?php echo set_value('address', isset($input['address']) ? $input['address'] : ''); ?>">
                                        <span class="error-message">
                                            <?php echo isset($errors['address']) ? $errors['address'] : ''; ?></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row receive-goods-input">
                                <div class="col-lg-12">
                                    <div class="form-group-receive-goods">
                                        <label class="form-label">Theo phiếu giao nhận hàng số <span
                                                class="text-danger">(*)</span>:</label>
                                        <input name="phieu_giao_nhan_so" type="text" class="input-dots"
                                            value="<?php echo set_value('phieu_giao_nhan_so', isset($input['phieu_giao_nhan_so']) ? $input['phieu_giao_nhan_so'] : ''); ?>">
                                        <span
                                            class="error-message"><?php echo isset($errors['phieu_giao_nhan_so']) ? $errors['phieu_giao_nhan_so'] : ''; ?></span>
                                    </div>
                                </div>


                            </div>

                            <div class="row receive-goods-input">
                                <div class="col-lg-12">
                                    <div class="form-group-receive-goods">
                                        <label class="form-label">Nhập nội bộ từ kho <span
                                                class="text-danger">(*)</span>:</label>
                                        <input name="nhan_noi_bo_tu_kho" type="text" class="input-dots"
                                            value="<?php echo set_value('nhan_noi_bo_tu_kho', isset($input['nhan_noi_bo_tu_kho']) ? $input['nhan_noi_bo_tu_kho'] : ''); ?>">
                                        <span
                                            class="error-message"><?php echo isset($errors['nhan_noi_bo_tu_kho']) ? $errors['nhan_noi_bo_tu_kho'] : ''; ?></span>
                                    </div>
                                </div>

                            </div>


                            <div class="row receive-goods-input">
                                <div class="col-lg-12">
                                    <div class="form-group-receive-goods supplier-select">
                                        <label class="form-label">Nhà cung cấp <span class="text-danger">(*)</span>:
                                        </label>
                                        <select name="supplier_id" id="supplier_id"
                                            class="supplier_select form-control setupSelect2 width500">
                                            <option value="">-- Chọn nhà cung cấp --</option>
                                            <?php foreach ($allsuppliers as $supplier): ?>
                                                <option value="<?php echo $supplier->SupplierID; ?>" <?php echo (isset($input['supplier_id']) && $input['supplier_id'] == $supplier->SupplierID) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($supplier->Name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <span class="error-message-supplier">
                                            <?php echo isset($errors['supplier_id']) ? $errors['supplier_id'] : ''; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <h4>STT</h4>
                                        </th>
                                        <th class="width200">
                                            <h4>Tên nhãn hiệu, qui cách, phẩm chất hàng hoá, vật tư, dụng cụ</h4>
                                        </th>
                                        <th class="width120">
                                            <h4>Mã sản phẩm</h4>
                                        </th>
                                        <th class="width120">
                                            <h4>Đơn vị tính</h4>
                                        </th>
                                        <th>
                                            <h4>Giá nhập/đơn vị sản phẩm</h4>
                                        </th>
                                        <th class="width130">
                                            <h4>Hạn sử dụng</h4>
                                        </th>
                                        <th>
                                            <h4>Số lượng theo chứng từ</h4>
                                        </th>
                                        <th>
                                            <h4>Số lượng thực nhập</h4>
                                        </th>
                                        <th>
                                            <h4>Ghi chú</h4>
                                        </th>
                                        <th>
                                            <h4>Thêm/Xóa</h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <?php if (isset($input['products']) && count($input['products']) > 0): ?>
                                        <?php foreach ($input['products'] as $key => $product): ?>
                                            <!-- Hiển thị lỗi -->
                                            <tr class="table-product-receive">
                                                <td><?php echo $key + 1; ?></td>
                                                <?php
                                                // Tìm sản phẩm đang được chọn để lấy đơn vị
                                                $selectedProduct = array_filter($allproducts, function ($prod) use ($product) {
                                                    return $prod->ProductID == ($product['ProductID'] ?? '');
                                                });
                                                $selectedProduct = reset($selectedProduct);
                                                $unitValue = $selectedProduct->Unit ?? ''; // Nếu không tìm thấy thì để rỗng
                                                ?>
                                                <td>
                                                    <div>
                                                        <select name="products[<?php echo $key; ?>][ProductID]"
                                                            class="form-control product-select setupSelect2"
                                                            onchange="updateUnit(this); updateProductCode(this);">
                                                            <option value="">Chọn sản phẩm</option>
                                                            <?php foreach ($allproducts as $prod): ?>
                                                                <option <?= ($product['ProductID'] == $prod->ProductID) ? 'selected' : ''; ?> value="<?= $prod->ProductID; ?>"
                                                                    data-unit="<?= $prod->Unit; ?>"
                                                                    data-code="<?= $prod->Product_Code; ?>">
                                                                    <?= $prod->Name; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <span
                                                        class="error-message-table-product"><?php echo isset($errors["products[$key][ProductID]"]) ? $errors["products[$key][ProductID]"] : ''; ?></span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="display-product-code">
                                                            <?php echo !empty($product['code']) ? htmlspecialchars($product['code']) : '...'; ?>
                                                        </span>
                                                    </div>
                                                    <input type="hidden" name="products[<?php echo $key; ?>][code]"
                                                        class="form-control"
                                                        value="<?php echo set_value("products[$key][code]", $product['code']); ?>" readonly>
                                                    <span
                                                        class="error-message-table-product error-product-code"><?php echo isset($errors["products[$key][code]"]) ? $errors["products[$key][code]"] : ''; ?></span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="display-product-unit">
                                                            <?php echo !empty($unitValue) ? htmlspecialchars($unitValue) : '...'; ?>
                                                        </span>
                                                    </div>
                                                    <input type="hidden" name="products[<?php echo $key; ?>][unit]"
                                                        class="form-control"
                                                        value="<?php echo htmlspecialchars($unitValue); ?>"
                                                        readonly>
                                                    <span
                                                        class="error-message-table-product error-unit"><?php echo isset($errors["products[$key][unit]"]) ? $errors["products[$key][unit]"] : ''; ?></span>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control format-money" placeholder="VNĐ"
                                                        value="<?php echo set_value("products[$key][Import_price]", is_array($product) ? $product['Import_price'] : ''); ?>"
                                                        oninput="formatMoney(this)" onfocus="removeFormat(this)"
                                                        onblur="formatMoney(this)">
                                                    <input type="hidden" name="products[<?php echo $key; ?>][Import_price]" value="<?php echo set_value("products[$key][Import_price]", is_array($product) ? $product['Import_price'] : ''); ?>" class="real-value">
                                                    <span class="error-message-table-product">
                                                        <?php echo isset($errors["products[$key][Import_price]"]) ? $errors["products[$key][Import_price]"] : ''; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="date" name="products[<?php echo $key; ?>][Exp_date]"
                                                        class="form-control width130"
                                                        value="<?php echo set_value("products[$key][Exp_date]", is_array($product) ? ($product['Exp_date'] ?? '') : ''); ?>">
                                                    <span class="error-message-table-product">
                                                        <?php echo isset($errors["products[$key][Exp_date]"]) ? $errors["products[$key][Exp_date]"] : ''; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="number" min="0"
                                                        name="products[<?php echo $key; ?>][quantity_doc]" class="form-control"
                                                        value="<?php echo set_value("products[$key][quantity_doc]", is_array($product) ? $product['quantity_doc'] : ''); ?>">
                                                    <span class="error-message-table-product">
                                                        <?php echo isset($errors["products[$key][quantity_doc]"]) ? $errors["products[$key][quantity_doc]"] : ''; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="number" min="0"
                                                        name="products[<?php echo $key; ?>][quantity_real]" class="form-control"
                                                        value="<?php echo set_value("products[$key][quantity_real]", is_array($product) ? $product['quantity_real'] : ''); ?>">
                                                    <span class="error-message-table-product">
                                                        <?php echo isset($errors["products[$key][quantity_real]"]) ? $errors["products[$key][quantity_real]"] : ''; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="text" name="products[<?php echo $key; ?>][note]"
                                                        class="form-control"
                                                        value="<?php echo set_value("products[$key][note]", is_array($product) ? $product['note'] : ''); ?>">
                                                    <span class="error-message-table-product">
                                                        <?php echo isset($errors["products[$key][note]"]) ? $errors["products[$key][note]"] : ''; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-success btn-action"
                                                        onclick="addRow(this)">+</button>
                                                    <?php if ($key > 0): ?>
                                                        <button type="button" class="btn btn-danger btn-action"
                                                            onclick="deleteRow(this)">−</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- Truy cập lần đầu -->
                                        <tr class="table-product-receive">
                                            <td>1</td>
                                            <td>
                                                <select name="products[0][ProductID]"
                                                    class="form-control setupSelect2 product-select"
                                                    onchange="updateUnit(this); updateProductCode(this);">
                                                    <option value="">Chọn sản phẩm</option>
                                                    <?php foreach ($allproducts as $product): ?>
                                                        <option value="<?php echo $product->ProductID; ?>"
                                                            data-unit="<?php echo $product->Unit; ?>"
                                                            data-code="<?= $product->Product_Code; ?>">
                                                            <?php echo $product->Name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </td>
                                            <td>
                                                <span class="display-product-code">...</span>
                                                <input type="hidden" name="products[0][code]" value="">
                                            </td>
                                            <td>
                                                <span class="display-product-unit">...</span>
                                                <input type="hidden" name="products[0][unit]" value="">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control format-money" placeholder="VNĐ"
                                                    oninput="formatMoney(this)" onfocus="removeFormat(this)"
                                                    onblur="formatMoney(this)">
                                                <input type="hidden" name="products[0][Import_price]" class="real-value">
                                            </td>


                                            <td><input type="date" name="products[0][Exp_date]"
                                                    class="form-control width130" value="">

                                            </td>

                                            <td><input type="number" min="0" name="products[0][quantity_doc]"
                                                    class="form-control" value="">

                                            </td>
                                            <td><input type="number" min="0" name="products[0][quantity_real]"
                                                    class="form-control" value="">

                                            </td>
                                            <td><input type="text" name="products[0][note]" class="form-control" value="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-action"
                                                    onclick="addRow(this)">+</button>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right"><strong>Tổng cộng:</strong></td>
                                        <td colspan="2">
                                            <input type="text" id="totalAmount" class="form-control" readonly>
                                            <input type="hidden" name="sub_total" id="totalAmountHidden">
                                        </td>
                                    </tr>
                                </tfoot>


                            </table>
                            <div class="row text-center mt-4 signature">
                                <div class="col-md-4">
                                    <p>Người giao hàng <br> (Ký, ghi rõ họ tên)</p>
                                </div>
                                <div class="col-md-4">
                                    <p>Thủ kho <br> (Ký, ghi rõ họ tên)</p>
                                </div>
                                <div class="col-md-4">
                                    <p>Người lập phiếu <br> (Ký, ghi rõ họ tên)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="text-right mb15">
            <button type="submit" name="" value="" class="btn btn-primary">Tiến hành nhập kho</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let datePicker = document.getElementById("date-picker");
        if (datePicker.value) {
            let selectedDate = new Date(datePicker.value);
            let day = selectedDate.getDate();
            let month = selectedDate.getMonth() + 1; // Tháng bắt đầu từ 0
            let year = selectedDate.getFullYear();

            document.getElementById("display-date").innerHTML = `Ngày ${day} Tháng ${month} Năm ${year}`;
        }
    });

    document.getElementById("date-picker").addEventListener("change", function() {
        if (this.value) {
            let selectedDate = new Date(this.value);
            let day = selectedDate.getDate();
            let month = selectedDate.getMonth() + 1; // Tháng bắt đầu từ 0
            let year = selectedDate.getFullYear();

            document.getElementById("display-date").innerHTML = `Ngày ${day} Tháng ${month} Năm ${year}`;
        }
    });

    function openDatePicker() {
        let datePicker = document.getElementById("date-picker");
        datePicker.showPicker();
    }



    let rowIndex = <?php echo isset($input['products']) ? count($input['products']) : 1; ?>;

    function addRow(button) {
        let currentRow = button.closest("tr");
        let newRow = document.createElement("tr");
        newRow.classList.add("table-product-receive");
        newRow.innerHTML = `
        <td></td>
        <td>
            <select name="products[${rowIndex}][ProductID]" class="form-control product-select setupSelect2" onchange="updateUnit(this); updateProductCode(this);">
                <option value="">Chọn sản phẩm</option>
                <?php foreach ($allproducts as $prod): ?>                    
                    <option value="<?php echo $prod->ProductID ?>" data-unit="<?= $prod->Unit; ?>" data-code="<?= $prod->Product_Code; ?>">
                        <?php echo $prod->Name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
        </td>
        <td>
            
            <span class="display-product-code">...</span>
            <input type="hidden" name="products[${rowIndex}][code]" value="">
        </td>
        <td>
            
            <span class="display-product-unit">...</span>
            <input type="hidden" name="products[${rowIndex}][unit]" value="">
        </td>
        <td>
            <input type="text" name="products[${rowIndex}][Import_price]"
                class="form-control format-money" placeholder="VNĐ" value=""
                oninput="formatMoney(this)" onfocus="removeFormat(this)"
                onblur="formatMoney(this)">
            <input type="hidden" name="products[${rowIndex}][Import_price]" class="real-value">                             
        </td>
        <td>
            <input type="date" name="products[${rowIndex}][Exp_date]" class="form-control width130">
            
        </td>
        <td>
            <input type="number" min="0" name="products[${rowIndex}][quantity_doc]" class="form-control">
            
        </td>
        <td>
            <input type="number" min="0" name="products[${rowIndex}][quantity_real]" class="form-control">
            
        </td>
        <td>
            <input type="text" name="products[${rowIndex}][note]" class="form-control">
            
        </td>
        <td>
            <button type="button" class="btn btn-success btn-action" onclick="addRow(this)">+</button>
            <button type="button" class="btn btn-danger btn-action" onclick="deleteRow(this)">−</button>
        </td>
    `;

        currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
        rowIndex++;
        updateRowNumbers();
        HHT.select2();


        let productSelect = newRow.querySelector(".product-select");
        if (productSelect) {
            updateUnit(productSelect);
        }
    }

    function deleteRow(button) {
        let row = button.closest("tr");
        if (row) {
            row.remove();
            updateRowNumbers();
        }
    }

    function updateRowNumbers() {
        let rows = document.querySelectorAll("#table-body tr");
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;

            // Hiển thị lại nút xóa, trừ hàng đầu tiên
            let deleteButton = row.querySelector(".btn-danger");
            if (deleteButton) {
                deleteButton.style.display = index === 0 ? "none" : "inline-block";
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateRowNumbers();
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Gọi updateUnit cho tất cả các select khi trang load
        document.querySelectorAll(".product-select").forEach(select => {
            updateUnit(select);
        });
    });

    function updateProductCode(selectElement) {
        let selectedOption = selectElement.options[selectElement.selectedIndex];
        let productCode = selectedOption.getAttribute("data-code");
        let row = selectElement.closest("tr");

        let codeInput = row.querySelector("[name*='[code]']");
        let codeDisplay = row.querySelector(".display-product-code");

        if (codeInput) codeInput.value = productCode || "";
        if (codeDisplay) codeDisplay.textContent = productCode ? productCode : "...";
    }

    function updateUnit(selectElement) {
        let selectedOption = selectElement.options[selectElement.selectedIndex];
        let unitValue = selectedOption.getAttribute("data-unit");
        let row = selectElement.closest("tr");

        let unitInput = row.querySelector("[name*='[unit]']");
        let unitDisplay = row.querySelector(".display-product-unit");

        if (unitInput) unitInput.value = unitValue || "";
        if (unitDisplay) unitDisplay.textContent = unitValue ? unitValue : "...";
    }

    function getNumberFromFormatted(value) {
        return Number(value.replace(/\./g, "")) || 0;
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll("#table-body tr").forEach(row => {
            let priceInput = row.querySelector("[name*='[Import_price]']");
            let quantityInput = row.querySelector("[name*='[quantity_real]']");

            let price = priceInput ? getNumberFromFormatted(priceInput.value) : 0;
            let quantity = quantityInput ? parseInt(quantityInput.value, 10) || 0 : 0;

            total += price * quantity;
        });
        let formattedTotal = total.toLocaleString("vi-VN") + " VNĐ";
        document.getElementById("totalAmount").value = formattedTotal;
        document.getElementById("totalAmountHidden").value = total;
    }


    document.addEventListener("input", function(event) {
        if (event.target.matches("[name*='[Import_price]']") || event.target.matches("[name*='[quantity_real]']")) {
            calculateTotal();
        }
    });

    document.addEventListener("DOMContentLoaded", calculateTotal);



    function formatMoney(input) {
        let value = input.value.replace(/\D/g, "");
        if (!value) {
            input.value = "";
            return;
        }

        let formatted = parseInt(value, 10).toLocaleString("vi-VN");
        input.value = formatted;


        let hiddenInput = input.nextElementSibling;
        if (hiddenInput && hiddenInput.classList.contains("real-value")) {
            hiddenInput.value = value;
        }
    }

    function removeFormat(input) {
        input.value = input.value.replace(/\D/g, "");
    }
</script>