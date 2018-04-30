		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});

$( document ).ready(function() {

	$('#applyCouponBtn').on("click", function() {
		var coupon = $('input[name="coupon-code"]').val();
		if ( coupon == "" ) {
			swal( "Coupon Code" , "is empty !", "warning");
		}
		else {
			$.ajax({ 
				type: "POST",
				cache: false,
				url: url.ac, 
				data: {
					'c': coupon
				},
				success: function( datas ){
					if ( $.trim( datas ) == 0 ) {
						swal( "Coupon Code" , "is invalid !", "error");
					} else {
						swal( "Coupon Code : " + coupon , "is successfully added !", "success");
						$(".table-shopping-cart tbody .table-row").remove();
						$(".table-shopping-cart tbody").append( datas );
						changeQuantities();
						removeTableCartItem();
					}
				},
				error : function(){
					swal( "unexpected error" , "an error occurred when adding !", "error");
				},
			});
		}
	});

	$('#buyNow').on( "click", function() {
		$.ajax({ 
			type: "POST",
			cache: false,
			url: url.bn, 
			success: function( datas )
			{
				if ( $.trim( datas ) === "" ) {
					alert('okey');
				}
				else if ( $.trim( datas ) == 1 )
				{
					swal( "Not connected" , "Please make sure you are logged in before !", "error");
				}
				else if ( $.trim( datas ) == 2 )
				{
					swal( "Empty cart" , "please make sure you have added products to your cart before ordering !", "warning");
				}
			},
			error : function(){
				swal( "unexpected error" , "an error occurred during deletion !", "error");
			},
		});
	});
	
	changeQuantities();
	removeTableCartItem();

	/*$('#updateCart').on('click', function() {
		$.ajax({ 
			type: "POST",
			cache: false,
			url: url.ac, 
			data: {
				'c': coupon
			},
			success: function( datas ){
				if ( $.trim( datas ) == 0 ) {
					swal( "Coupon Code" , "is invalid !", "error");
				} else {
					swal( "Coupon Code : " + coupon , "is successfully added !", "success");
					$(".table-shopping-cart tbody .table-row").remove();
					$(".table-shopping-cart tbody").append( datas );
				}
			},
			error : function(){
				swal( "unexpected error" , "an error occurred when adding !", "error");
			},
		});
	});*/
});

function removeTableCartItem()
{
	$('.table-shopping-cart .table-row .cart-img-product').on('click', function() {

		if ( $(this).data("p") === "cp")
		{
			$.ajax({ 
				type: "POST",
				cache: false,
				url: url.rc, 
				data: {
					'c': "cp"
				},
				success: function( datas )
				{
					$('.table-row').remove();
					$('.table-shopping-cart tbody').append( datas );
					changeQuantities();
					removeTableCartItem();
				},
				error : function(){
					swal( "unexpected error" , "an error occurred during deletion !", "error");
				},
			});
		}
		else 
		{
			$( '.header-cart-item[data-i="' + $(this).attr('data-i') + '"]:visible' ).find('.header-cart-item-img').trigger( "click" );

			$.ajax({ 
				type: "POST",
				cache: false,
				url: url.rci, 
				data: {
					'v': "table",
					'i': $(this).attr("data-i")
				},
				success: function( datas )
				{
					if ( $.trim( datas ) == "" )
					{
						$('.container').html("<div>panier vide</div>");
					}
					else
					{
						$('.table-row').remove();
						$('.table-shopping-cart tbody').append( datas );
						changeQuantities();
						removeTableCartItem();
					}
				},
				error : function(){
					swal( "unexpected error" , "an error occurred during deletion !", "error");
				},
			});
		}

	});
}

function changeQuantities()
{
	changeQuantitiesBtn();

	// display new value
	$('.btn-num-product-down, .btn-num-product-up').on('click', function() {
		var quantities = $(this).parents('.table-row').find('.num-product').val();
		var price = $(this).parents('.table-row').find('.column-3').text().replace("$", "");
		$(this).parents('.table-row').find('.column-5').text( "$" + (quantities * price) );
	});
}