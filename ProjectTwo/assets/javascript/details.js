		//select2

		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});

		// sweetalert

		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});

		// add to cart
		$('.btn-addcart-product-detail').each(function(){
			var nameProduct = $('.product-detail-name').html();
			$(this).on('click', function(){
				var productId = $('.containerProduct').attr('data-p');
				var quantities = $('.num-product').val();
				$.ajax({ 
					type: "POST",
					cache: false,
					url: url.atc, 
					data: {
						'i': productId,
						'q': quantities
					},
					success: function( datas ){
						$('.header-wrapicon2').find('*').not('#cartIcon').remove();
						$(".header-wrapicon2").append( datas );
						removeCartItem();
						swal(nameProduct, "is added to your cart !", "success");
					},
					error : function(){
						swal( "unexpected error" , "an error occurred when adding !", "error");
					},
				});
				
			});
		});