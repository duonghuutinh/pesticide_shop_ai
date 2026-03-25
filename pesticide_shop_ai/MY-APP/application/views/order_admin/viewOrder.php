<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row mb15">

                        <div class="col-lg-8">
                            <?php
                            $previous_Order_Code = null;
                            $order_totals = [];
                            foreach ($order_details as $key => $ord):
                                // Tính tổng tiền của từng đơn hàng
                                if (isset($ord->Promotion) && $ord->Promotion != 0) {
                                    $Promotioned_price = $ord->Selling_price * (1 - $ord->Promotion / 100);
                                    $subtotal = $ord->qty * $Promotioned_price;
                                } else {
                                    $subtotal = $ord->qty * $ord->Selling_price;
                                }
                                if (!isset($order_totals[$ord->Order_Code])) {
                                    $order_totals[$ord->Order_Code] = 0;
                                }
                                $order_totals[$ord->Order_Code] += $subtotal;
                            ?>
                                <div class="row">
                                    <table style="height: 207px;" class="table table-bordered table-hover">
                                        <thead class="">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Image</th>
                                                <th scope="col">Order Code</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Price</th>
                                                <th scope="col">Sale</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Payment Form</th>
                                                <th scope="col">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <th scope="row"><?php echo $key + 1 ?></th>
                                                <td><img src="<?php echo base_url('uploads/product/' . $ord->Image) ?>"
                                                        alt="" class="img-fluid" style="max-width: 144px; height: 144px;">
                                                </td>
                                                <td><?php echo $ord->Order_Code ?></td>
                                                <td><?php echo $ord->Name ?></td>

                                                <td>
                                                    <?php
                                                    if (isset($ord->Promotion) && $ord->Promotion != 0) {
                                                        $Promotioned_price = $ord->Selling_price * (1 - $ord->Promotion / 100);
                                                        echo '<del class="text-muted text-decoration-line-through" style="font-size: 1.2rem;">' . number_format($ord->Selling_price, 0, ',', '.') . ' VNĐ</del><br>';
                                                        echo '<span class="text-success" style="font-size: 1.4rem; font-weight: bold;">' . number_format($Promotioned_price, 0, ',', '.') . ' VNĐ</span>';
                                                    } else {
                                                        echo '<span class="text-success" style="font-size: 1.4rem; font-weight: bold;">' . number_format($ord->Selling_price, 0, ',', '.') . ' VNĐ</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $ord->Promotion ?>%</td>
                                                <td><?php echo $ord->qty ?></td>
                                                <td><?php echo $ord->checkout_method ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($ord->Promotion) && $ord->Promotion != 0) {
                                                        $Promotioned_price = $ord->Selling_price * (1 - $ord->Promotion / 100);
                                                        echo '<span class="text-success" style="font-size: 1.4rem; font-weight: bold;">' . number_format($ord->qty * $Promotioned_price, 0, ',', '.') . ' VNĐ</span>';
                                                    } else {
                                                        echo '<span class="text-success" style="font-size: 1.4rem; font-weight: bold;">' . number_format($ord->qty * $ord->Selling_price, 0, ',', '.') . ' VNĐ</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <table style="width: 350px;" class="table table-bordered table-hover" data-order-code="<?php echo $ord->Order_Code; ?>">
                                        <thead class="">
                                            <tr>
                                                <th>Batches</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (!empty($ord->product_qty_in_batches['batches'])) {
                                                foreach ($ord->product_qty_in_batches['batches'] as $key => $quantity_in_batch):
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($quantity_in_batch['Batch_ID']); ?></td>
                                                        <td><?php echo htmlspecialchars($quantity_in_batch['QuantityToTake']); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="2">Không có dữ liệu nào để hiển thị.</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div>
                                        <h3>Tổng số lượng lấy được:
                                            <span
                                                class="text-success"><?php echo htmlspecialchars($ord->product_qty_in_batches['totalQuantity']); ?>
                                            </span>
                                        </h3>
                                        <h3>Số lượng còn thiếu:
                                            <span
                                                class="text-danger"><?php echo htmlspecialchars($ord->product_qty_in_batches['shortage']); ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-lg-4">
                            <table class="table table-bordered table-hover">
                                <?php foreach ($order_totals as $Order_Code => $total): ?>
                                    <thead class="">
                                        <tr>

                                            <th scope="col">Tổng tiền của đơn: <span
                                                    style="color: blue"><?php echo $Order_Code; ?></span></th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="font-weight: 900;" class="text-danger">
                                                    <?php echo number_format($order_details[0]->TotalAmount, 0, ',', '.') . ' VNĐ'; ?>
                                                </h1>
                                            </td>
                                        </tr>

                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                            <?php if (!empty($order_details[0]->DiscountID) && !empty($order_details[0]->Discount_value)): ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Số tiền đã được giảm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 style="font-weight: 600;" class="text-info">
                                                    <?php echo number_format($order_details[0]->Discount_value, 0, ',', '.') . ' VNĐ'; ?>
                                                </h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <table class="table table-bordered table-hover">
                                <?php foreach ($order_totals as $Order_Code => $total): ?>
                                    <thead class="">
                                        <tr>

                                            <th scope="col">Trạng thái thanh toán<span style="color: blue"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($ord->payment_status == 1) {
                                                ?>
                                                    <h3 style="font-weight: 900; color: green">
                                                        Đã thanh toán
                                                    </h3>

                                                <?php
                                                } else {
                                                ?>
                                                    <h3 style="font-weight: 900;" class="text-danger">
                                                        Chưa được thanh toán
                                                    </h3>

                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                    </tbody>
                                <?php endforeach; ?>
                            </table>

                            <table class="table table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="height: 58px;">
                                            <?php foreach ($order_details as $key => $ord): ?>
                                                <?php if ($ord->Order_Code != $previous_Order_Code): ?>
                                                    <?php

                                                    if ($ord->product_qty_in_batches['shortage'] > 0) {
                                                        echo '<h3 style="color: red;">Số lượng hiện tại trong kho không đủ</h3>';
                                                    } else {
                                                        if ($ord->checkout_method == 'COD' && $ord->order_status != 4) {
                                                    ?>
                                                            <select class="form-control form-control-sm order_status setupSelect2"
                                                                data-order-code="<?php echo $ord->Order_Code; ?>">
                                                                <option value="-1" <?= ($ord->order_status == 0) ? 'selected' : ''; ?>>Chọn
                                                                    trạng thái đơn hàng</option>
                                                                <option value="1" <?= ($ord->order_status == 1) ? 'selected' : ''; ?>>Đơn
                                                                    hàng đang được xử lý</option>
                                                                <option value="2" <?= ($ord->order_status == 2) ? 'selected' : ''; ?>>Đang
                                                                    chuẩn bị hàng</option>
                                                                <option value="3" <?= ($ord->order_status == 3) ? 'selected' : ''; ?>>Đơn
                                                                    đã giao cho đơn vị vận chuyển</option>
                                                                <option value="4" <?= ($ord->order_status == 4) ? 'selected' : ''; ?>>Đã
                                                                    thanh toán, giao hàng thành công</option>
                                                                <option value="5" <?= ($ord->order_status == 5) ? 'selected' : ''; ?>>Hủy đơn
                                                                </option>
                                                            </select>
                                                            <button style="float: right;"
                                                                class="btn btn-primary btn-sm save-status mt20"
                                                                data-order-code="<?php echo $ord->Order_Code ?>">Lưu</button>
                                                        <?php
                                                        } elseif ($ord->checkout_method == 'VNPAY' && $ord->order_status != 4) {
                                                        ?>
                                                            <select class="form-control form-control-sm order_status setupSelect2"
                                                                data-order-code="<?php echo $ord->Order_Code ?>">
                                                                <option value="0" <?php echo $ord->order_status == 0 ? 'selected' : '' ?>>
                                                                    Chọn trạng thái đơn hàng</option>
                                                                <option value="1" <?php echo $ord->order_status == 1 ? 'selected' : '' ?>>
                                                                    Đơn hàng đang được xử lý</option>
                                                                <option value="2" <?php echo $ord->order_status == 2 ? 'selected' : '' ?>>
                                                                    Đang chuẩn bị hàng</option>
                                                                <option value="3" <?php echo $ord->order_status == 3 ? 'selected' : '' ?>>
                                                                    Đơn đã giao cho đơn vị vận chuyển</option>
                                                                <option value="4" <?php echo $ord->order_status == 4 ? 'selected' : '' ?>>
                                                                    Giao hàng thành công</option>
                                                                <option value="5" <?php echo $ord->order_status == 5 ? 'selected' : '' ?>>
                                                                    Hủy</option>
                                                            </select>
                                                            <button style="float: right;"
                                                                class="btn btn-primary btn-sm save-status mt20"
                                                                data-order-code="<?php echo $ord->Order_Code ?>">Lưu</button>
                                                    <?php
                                                        } else {
                                                            echo '<h3>Đơn hàng đã hoàn tất</h3>';
                                                        }
                                                    }
                                                    ?>
                                                    <?php $previous_Order_Code = $ord->Order_Code; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.save-status', function() {
        const button = $(this);
        const orderCode = button.data('order-code');
        const value = $(`.order_status[data-order-code="${orderCode}"]`).val();

        if (value == 0) {
            alert('Hãy chọn trạng thái đơn hàng');
        } else {
            // Lấy dữ liệu batches
            let product_qty_in_batch = [];
            $(`table[data-order-code="${orderCode}"] tbody tr`).each(function() {
                const batch_id = $(this).find('td:eq(0)').text().trim();
                const quantity = $(this).find('td:eq(1)').text().trim();

                if (batch_id && quantity) {
                    product_qty_in_batch.push({
                        Batch_ID: batch_id,
                        QuantityToTake: quantity
                    });
                }
            });

            console.log('Dữ liệu gửi đi:', JSON.stringify(product_qty_in_batch));
            console.log('Order Code:', orderCode);
            console.log('Order Status:', value);

            // $.ajax({
            //     url: '/order_admin/update-order-status',
            //     method: 'POST',
            //     data: {
            //         value: value,
            //         Order_Code: orderCode,
            //         product_qty_in_batch: product_qty_in_batch
            //     },
            //     beforeSend: function() {
            //         button.prop('disabled', true).text('Đang lưu...');
            //     },
            //     // success: function(response) {
            //     //     alert('Cập nhật trạng thái đơn hàng thành công');
            //     //     // location.reload();
            //     // },
            //     success: function(response) {
            //         alert(response.message);
            //         location.reload();
            //     },

            //     error: function(xhr, status, error) {
            //         alert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng');
            //         button.prop('disabled', false).text('Lưu');
            //     }
            // });


            $.ajax({
                url: '/order_admin/update-order-status',
                method: 'POST',
                dataType: 'json',
                data: {
                    value: value,
                    Order_Code: orderCode,
                    product_qty_in_batch: product_qty_in_batch
                },
                beforeSend: function() {
                    button.prop('disabled', true).text('Đang lưu...');
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Lỗi: ' + response.message);
                        button.prop('disabled', false).text('Lưu');
                    }
                },

                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng');
                    button.prop('disabled', false).text('Lưu');
                }
            });

        }
    });
</script>