<div class="container">
    <div class="card">
        <div class="card-header">Danh sách khách hàng</div>
            <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success') ?></div>
            <?php } elseif($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
            <?php } ?>
        <div class="card-body">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ngày bình luận</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Status</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($comments as $key => $cmt){
                ?>
                <tr>
                    <th scope="row"><?php echo $key + 1 ?></th>
                    <td><?php echo $cmt->product_name?></td>
                    <td><?php echo $cmt->name?></td>
                    <td><?php echo $cmt->email?></td>
                    <td><?php echo $cmt->date_cmt?></td>
                    <td><?php echo $cmt->comment?></td>
                    <td><?php 
                        if($cmt->status == 1){
                            echo "Duyệt";
                        }else{
                            echo "Chưa duyệt";
                        }     
                    ?></td>
                    <td>
                        <!-- <a  class="btn btn-danger"><i class="fa-solid fa-trash"></i>Delete</a> -->
                        <a  class="btn btn-warning"><i class="fa-solid fa-wrench"></i>Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
    </div>
</div>