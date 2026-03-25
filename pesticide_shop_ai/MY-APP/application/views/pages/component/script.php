
<script src="<?php echo base_url('frontend/js/jquery.js') ?>"></script>
<script src="<?php echo base_url('frontend/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('frontend/js/jquery.scrollUp.min.js') ?>"></script>
<script src="<?php echo base_url('frontend/js/price-range.js') ?>"></script>
<script src="<?php echo base_url('frontend/js/jquery.prettyPhoto.js') ?>"></script>
<script src="<?php echo base_url('frontend/js/main.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
	integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script>
	$(document).ready(function () {
		var active = location.search;
		$('#select-filter option[value="' + active + '"]').attr('selected', 'selected');
	});


	$('.select-filter').change(function () {
		// const value = $(this).val();

		const value = $(this).find(':selected').val();

		if (value != 0) {
			var url = value;
			window.location.replace(url);
		} else {
			alert('Hãy lọc sản phẩm');
		}

	});
</script>

<script>
	$('.price_from').val(<?php echo $min_price ?>);
	$('.price_to').val(<?php echo $max_price / 2 ?>);
	$(function () {
		$("#slider-range").slider({
			range: true,
			min: <?php echo $min_price ?>,
			max: <?php echo $max_price ?>,
			values: [<?php echo $min_price ?>, <?php echo $max_price / 2 ?>],
			slide: function (event, ui) {
				$("#amount").val(addPlus(ui.values[0]).toString() + "vnđ" + '-' + addPlus(ui.values[1]) + "vnđ");
				$('.price_from').val(ui.values[0]);
				$('.price_to').val(ui.values[1]);
			}

		});
		$("#amount").val(addPlus($("#slider-range").slider("values", 0)) +
			"vnđ" + '-' + addPlus($("#slider-range").slider("values", 1)) + 'vnđ');
	});
	function addPlus(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
</script>

<script>
	$('.write-comment').click(function () {
		var name_comment = $('.name_comment').val();
		var email_comment = $('.email_comment').val();
		var comment = $('.comment').val();
		var pro_id_cmt = $('.product_id_comment').val();
		if (name_comment == '' || email_comment == '' || comment == '') {
			alert('Hãy điền đầy đủ thông tin');
		} else {
			$.ajax({
				method: 'POST',
				url: '/comment/send',
				data: { name_comment: name_comment, email_comment: email_comment, comment: comment, pro_id_cmt: pro_id_cmt },
				success: function () {
					alert('Đánh giá của bạn đã được ghi nhận');
				}
			})
		}


	});
</script>

<!-- Check 2 ô nhập lại mật khẩu -->
<script>
	document.getElementById('password2').addEventListener('input', checkPasswordMatch);

	function checkPasswordMatch() {
		var password1 = document.getElementById('password1').value;
		var password2 = document.getElementById('password2').value;

		if (password1 !== password2) {
			document.getElementById('password2').setCustomValidity('Mật khẩu không khớp');
		} else {
			document.getElementById('password2').setCustomValidity('');
		}
	}
</script>









<script>
	window.addEventListener('beforeunload', function () {
		document.getElementById('loader').style.display = 'block';
	});

</script>



<script>
	$.ajax({
		url: '<?= base_url('search-by-disease') ?>',
		method: 'POST',
		data: { disease_name: 'Tên bệnh từ AI' },
		success: function (response) {
			$('#result-container').html(response);
		},
		error: function (err) {
			console.error('Lỗi:', err);
		}
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

