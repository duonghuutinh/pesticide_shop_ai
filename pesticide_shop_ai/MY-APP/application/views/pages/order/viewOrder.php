<div style="margin-top: -42px;" class="container">
    <div class="card">
        <h1 style="text-align: center; margin-bottom: 30px; color: #FE980F;">Chi tiết đơn hàng</h1>
        <div class="card-body">
            <table class="table">
                <thead style="border-bottom: 3px solid #FE980F;" class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã đơn</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">tên SP</th>
                        <th scope="col">Giá gốc</th>
                        <th scope="col">Giảm</th>
                        <th scope="col">Giá bán</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Phương thức thanh toán</th>
                        <th class="width100" scope="col">Trạng thái</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_sub = 0;
                    foreach ($order_details as $key => $ord_details) {
                        $price_after_discount = $ord_details->Selling_price * (1 - $ord_details->Promotion / 100);
                        $subtotal = $price_after_discount * $ord_details->qty;
                        $total_sub += $subtotal;
                    ?>
                        <tr style="border-bottom: 2px solid #FE980F;">
                            <th scope="row"><?php echo $key + 1 ?></th>
                            <td><?php echo $ord_details->Order_Code ?></td>
                            <td><img src="<?php echo base_url('uploads/product/' . $ord_details->Image) ?>" alt="" width="150" height="150"></td>
                            <td><?php echo $ord_details->Name ?></td>
                            <td><?php echo number_format($ord_details->Selling_price, 0, ',', '.') ?> vnd</td>
                            <td><?php echo $ord_details->Promotion ?>%</td>
                            <td><?php echo number_format($price_after_discount, 0, ',', '.') ?> vnd</td>
                            <td><?php echo $ord_details->qty ?></td>
                            <td><?php echo $ord_details->checkout_method ?></td>
                            <td>
                                <?php
                                if ($ord_details->order_status == -1) {
                                    echo '<span  class="text text-info">Đang chờ xử lý</span>';
                                } elseif ($ord_details->order_status == 1) {
                                    echo '<span class="text text-info">Đang được tiếp nhận</span>';
                                } elseif ($ord_details->order_status == 2) {
                                    echo '<span class="text text-info">Đang chuẩn bị hàng</span>';
                                } elseif ($ord_details->order_status == 3) {
                                    echo '<span class="text text-info">Đã giao cho đơn vị vận chuyển</span>';
                                } elseif ($ord_details->order_status == 4) {
                                    echo '<span class="text text-success">Đơn hàng đã được thanh toán</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Đã hủy</span>';
                                }
                                ?>
                            </td>

                            <?php if (in_array($ord_details->order_status, [-1, 1, 2])) { ?>
                                <td>
                                    <a onclick="return confirm('Bạn chắc chẳn huỷ đơn hàng này chứ')"
                                        href="<?php echo base_url('order_customer/customerCancelOrder/' . $ord_details->Order_Code) ?>"
                                        class="btn btn-danger">Huỷ đơn hàng</a>
                                </td>
                            <?php } elseif ($ord_details->order_status == 3) { ?>
                                <td style="color: #FE980F; width: 150px;">Đơn đang giao đến bạn, không thể hủy đơn</td>
                            <?php } elseif ($ord_details->order_status == 4) { ?>
                                <td style="color: green; width: 150px;">Đơn hàng đã giao thành công</td>
                            <?php } elseif ($ord_details->order_status == 5) { ?>
                                <td style="color: r ed; width: 150px;">Bạn đã huỷ đơn hàng này</td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="width: 100%; height:100px; position: relative;">
                <div style="display: flex; position: absolute; right: 0px; top: -30px;">
                    <h3>TỔNG THANH TOÁN:
                        <h3 style="color: #FE980F; margin-left: 10px">
                            <?php echo number_format($total_sub, 0, ',', '.') ?> VNĐ
                        </h3>
                    </h3>
                </div>
            </div>
        </div>
    </div>