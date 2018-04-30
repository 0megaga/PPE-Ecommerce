		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});

		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				var productId = $(this).parents('.block2').find('.block2-name').attr('data-p');
				var quantities = 1;
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

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});

		/*[ No ui ]
	    ===========================================================*/
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 50, 200 ],
	        connect: true,
	        range: {
	            'min': 50,
	            'max': 200
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]) ;
	    });