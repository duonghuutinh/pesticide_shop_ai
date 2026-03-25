<div style="min-height: 500px;" class="container">
    <div class="card">
        <h1 class="title">Danh sách đơn hàng</h1>

        <div class="card-body">
        <?php if (!empty($order_items)): ?>
            <?php
            $orders_by_code = [];
            foreach ($order_items as $order_item) {
                $orders_by_code[$order_item->Order_Code][] = $order_item;
            }
            ?>
            <?php foreach ($orders_by_code as $order_code => $order_items_group) { ?>
                <h2>Mã đơn: <span class="text-primary"><?php echo $order_item->Order_Code; ?></span></h2>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên SP</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_sub = 0;
                        foreach ($order_items_group as $key => $order_item) {
                            $total_sub += $order_item->Subtotal;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; ?></th>
                                <td><img src="<?php echo base_url('uploads/product/' . $order_item->product_details->Image) ?>" alt="" width="150" height="150"></td>
                                <td><?php echo $order_item->product_details->Name; ?></td>
                                <td><?php echo $order_item->Quantity; ?></td>
                                <td style="color: #FE980F;"><?php echo number_format($order_item->Subtotal, 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <?php
                                    if ($order_item->Order_Status == -1) {
                                        echo '<span  class="text text-info">Đang chờ xử lý</span>';
                                    } elseif ($order_item->Order_Status == 1) {
                                        echo '<span class="text text-info">Đang được tiếp nhận</span>';
                                    } elseif ($order_item->Order_Status == 2) {
                                        echo '<span class="text text-info">Đang chuẩn bị hàng</span>';
                                    } elseif ($order_item->Order_Status == 3) {
                                        echo '<span class="text text-info">Đã giao cho đơn vị vận chuyển</span>';
                                    } elseif ($order_item->Order_Status == 4) {
                                        echo '<span class="text text-success">Đơn hàng đã được thanh toán</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Đã hủy</span>';
                                    }
                                    ?>
                                </td>
                                <!-- <td>
                                    <a href="<?php echo base_url('order_customer/viewOrder/' . $order_item->Order_Code) ?>" class="btn btn-warning btn-sm">Xem chi tiết</a>
                                    <?php if ($order_item->Order_Status == 4): ?>
                                        <a href="<?php echo base_url('review/order/' . $order_item->Order_Code) ?>" class="btn btn-success btn-sm mt-1">Đánh giá</a>
                                    <?php endif; ?>
                                </td> -->

                                <td>
                                    <a href="<?php echo base_url('order_customer/viewOrder/' . $order_item->Order_Code) ?>" class="btn btn-warning btn-sm">Xem chi tiết</a>
                                </td>
                                <td>
                                    <?php if ($order_item->Order_Status == 4): ?>
                                        <?php if (empty($order_item->has_reviewed_all_products)): ?>
                                            <a href="<?= base_url('review/order/' . $order_item->Order_Code) ?>" class="btn btn-success btn-sm mt-1">Đánh giá</a>
                                        <?php else: ?>
                                            <span class="btn btn-success btn-sm mt-1">Đã đánh giá</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div style="width: 100%; height:100px; position: relative; border-bottom: 3px solid #FE980F">
                    <div style="display: flex; position: absolute; right: 0px; top: -30px;">
                        <h3>TỔNG THANH TOÁN:
                            <h3 style="color: #FE980F; margin-left: 10px">
                                <?php echo number_format($total_sub, 0, ',', '.'); ?> VNĐ
                            </h3>
                        </h3>
                    </div>
                </div>
            <?php } ?>
            <?php else: ?>
        <div class="text-center py-5">
            <h3 class="text-muted">Không có đơn hàng nào!</h3>
        </div>
    <?php endif; ?>
        </div>
    </div>
</div>