<!-- Mainly scripts -->
<script src="<?php echo base_url('frontend/dashboard/js/jquery-3.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('frontend/dashboard/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('frontend/dashboard/js/plugins/metisMenu/jquery.metisMenu.js') ?>"></script>
<script src="<?php echo base_url('frontend/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>

<!-- Flot -->


<!-- Peity -->
<script src="<?php echo base_url('frontend/dashboard/js/plugins/peity/jquery.peity.min.js') ?>"></script>
<script src="<?php echo base_url('frontend/dashboard/js/demo/peity-demo.js') ?>"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('frontend/dashboard/js/inspinia.js') ?>"></script>
<script src="<?php echo base_url('frontend/dashboard/js/plugins/pace/pace.min.js') ?>"></script>

<!-- jQuery UI -->
<script src="<?php echo base_url('frontend/dashboard/js/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>


<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const inputs = this.querySelectorAll('input[name], select[name]');
        inputs.forEach(input => {
            const value = input.value;
            if (value === '') {
                input.removeAttribute('name');
            }
        });
    });
</script>






<script>
	$(document).ready(function () {
		toastr.options = {
			"closeButton": true,
			"progressBar": true, 
			"positionClass": "toast-top-right",
			"timeOut": 5000,
			"extendedTimeOut": 3000,
			"showEasing": "swing", 
			"hideEasing": "linear",
			"showMethod": "fadeIn", 
			"hideMethod": "fadeOut"
		};

		var successMessage = "<?php echo $this->session->flashdata('success'); ?>";
		var errorMessage = "<?php echo $this->session->flashdata('error'); ?>";
		var infoMessage = "<?php echo $this->session->flashdata('info'); ?>";

		if (successMessage) {
			toastr.success(successMessage, '', { timeOut: 5000 });
		}

		if (errorMessage) {
			toastr.error(errorMessage, '', { timeOut: 5000 });
		}

		if (infoMessage) {
			toastr.info(infoMessage, '', { timeOut: 5000 });
		}
	});
</script>





<script type="text/javascript">

	function ChangeToSlug() {
		var slug;

		//Lấy text từ thẻ input title 
		slug = document.getElementById("slug").value;
		slug = slug.toLowerCase();
		//Đổi ký tự có dấu thành không dấu
		slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
		slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
		slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
		slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
		slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
		slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
		slug = slug.replace(/đ/gi, 'd');
		//Xóa các ký tự đặt biệt
		slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
		//Đổi khoảng trắng thành ký tự gạch ngang
		slug = slug.replace(/ /gi, "-");
		//Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
		//Phòng trường hợp người nhập vào quá nhiều ký tự trắng
		slug = slug.replace(/\-\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-/gi, '-');
		slug = slug.replace(/\-\-/gi, '-');
		//Xóa các ký tự gạch ngang ở đầu và cuối
		slug = '@' + slug + '@';
		slug = slug.replace(/\@\-|\-\@|\@/gi, '');
		//In slug ra textbox có id “slug”
		document.getElementById('convert_slug').value = slug;
	}

</script>