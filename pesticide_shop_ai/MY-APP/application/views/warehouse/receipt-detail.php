<?php $this->load->view('admin-layout/component-admin/breadcrumb'); ?>
<div class="row wrapper wrapper-content-receive-goods animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-1">
                        <img style="width: 100px" src="<?php echo base_url('frontend/image/logo.png') ?>" alt="LOGO">
                    </div>
                    <div style="font-size: 16px;" class="col-lg-8">
                        <label class="form-label">CÔNG TY TNHH MTV PESTICIDE STORE</label>
                        <div class="form-group-receive-goods">
                            <label class="form-label">MST:</label>
                            <label class="form-label"><span class="font-weight-normal"><?php echo $receipt_detail['tax_identification_number']; ?></span></label>
                        </div>
                        <label class="form-label">Địa chỉ: 38C, đường Trần Vĩnh Kiết, Quận Ninh Kiều, TP.Cần Thơ</label>
                    </div>
                    <div class="col-lg-3">
                        <h3 class="float-right">
                            <strong>Số:</strong> <span class="font-weight-normal"><?php echo $receipt_detail['warehouse_receipt_id']; ?></span>
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
                                    <h4 id="display-date" class="m-0">Ngày: <span class="font-weight-normal"><?php echo date('d/m/Y', strtotime($receipt_detail['created_at'])); ?></span></h4>
                                </div>
                            </div>
                        </div>

                        <div class="row receive-goods-input">
                            <div class="col-lg-6">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Họ và tên người giao: </label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['name_of_delivery_person']; ?></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Đơn vị: </label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['delivery_unit']; ?></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row receive-goods-input">
                            <div class="col-lg-12">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Địa chỉ: </label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['address']; ?></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row receive-goods-input">
                            <div class="col-lg-12">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Theo phiếu giao nhận hàng số: </label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['delivery_note_number']; ?></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row receive-goods-input">
                            <div class="col-lg-12">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Nhập nội bộ từ kho:</label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['warehouse_from']; ?></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row receive-goods-input">
                            <div class="col-lg-12">
                                <div class="form-group-receive-goods">
                                    <label class="form-label">Nhà cung cấp:</label>
                                    <label><span class="font-weight-normal"><?php echo $receipt_detail['supplier_name']; ?></span></label>
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
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php if (!empty($receipt_detail['product_items'])): ?>
                                    <?php foreach ($receipt_detail['product_items'] as $key => $item): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $item['product_name']; ?></td>
                                            <td><?php echo $item['product_code']; ?></td>
                                            <td><?php echo $item['product_unit']; ?></td>
                                            <td><?php echo number_format($item['unit_import_price'], 0, ',', '.'); ?> VNĐ</td>
                                            <td><?php echo date('d/m/Y', strtotime($item['expiry_date'])); ?></td>
                                            <td><?php echo $item['quantity_document']; ?></td>
                                            <td><?php echo $item['quantity_actual']; ?></td>
                                            <td><?php echo $item['notes']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Không có sản phẩm nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right"><strong>Tổng cộng:</strong></td>
                                    <td colspan="2"><?php echo number_format($receipt_detail['sub_total'], 0, ',', '.'); ?> VNĐ</td>
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
</div>