$( document ).ready(function() {

    removeCartItem();

});

function removeCartItem()
{
	$('.header-cart-item-img').on( "click", function(){

    	$.ajax({ 
			type: "POST",
			cache: false,
			url: url.rci, 
			data: {
				'i': $(this).parent().attr("data-i")
			},
			success: function( datas ){
				$('.header-wrapicon2').find('*').not('#cartIcon').remove();
				$(".header-wrapicon2").append( datas );
				removeCartItem();
			},
			error : function(){
				swal( "unexpected error" , "an error occurred during deletion !", "error");
			},
		});

    });
}

function changeQuantitiesBtn()
{
	$('.btn-num-product-down').on('click', function(e){
        e.preventDefault();
        var numProduct = Number($(this).next().val());
        if(numProduct > 1) $(this).next().val(numProduct - 1);
    });

	// old
    /*$('.btn-num-product-up').on('click', function(e){
        e.preventDefault();
        var numProduct = Number($(this).prev().val());
        $(this).prev().val(numProduct + 1);
    });*/

    $('.btn-num-product-up').on('click', function(e){
        e.preventDefault();
        var numProduct = Number($(this).prev().val());
        if ( numProduct < $(this).attr('data-m') ) $(this).prev().val(numProduct + 1);
    });
}