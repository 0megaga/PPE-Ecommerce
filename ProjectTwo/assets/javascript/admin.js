var usersTable,
	productsTable,
	categoriesTable;

$( document ).ready(function() {

/*
|===============================================================================
| users
|===============================================================================
*/

	usersTable = $('#usersTable').DataTable({
		"bLengthChange": false,
		"processing": true,
		"serverSide": true,
		"order": [],
		"columnDefs": [
			{
		      "targets": 0,
		      "orderable": false
		    },
		    {
		      "targets": 7,
		      "orderable": false
		    }
	    ],
		"ajax": {
			url: dt.u,
			type: "POST"
		},
		"fnDrawCallback": function(oSettings) {

	        if ( $('#usersTable_paginate span .paginate_button').length < 2 ) {
	            $('#usersTable_paginate').hide();
	        }
	    }
	});

/*
|===============================================================================
| Products
|===============================================================================
*/

	productsTable = $('#productsTable').DataTable({
		"bLengthChange": false,
		"processing": true,
		"serverSide": true,
		"order": [],
		"columnDefs": [
			{
				"targets": 4,
				"visible": false
			},
		    {
		      "targets": 8,
		      "orderable": false
		    }
	    ],
		"ajax": {
			url: dt.p,
			type: "POST"
		},
		"fnDrawCallback": function(oSettings) {

	        if ( $('#productsTable_paginate span .paginate_button').length < 2 ) {
	            $('#productsTable_paginate').hide();
	        }
	    }
	});

	$('#productsTable').on('draw.dt', function(e){

		$('.allowItem').on('click', function() {

			var nameProduct = $(this).closest('tr').find('td:eq(0)').text();

			if ( confirm("Are you sure you allow this product for sale : " + nameProduct + " ?" ) ) { //lang js after

				$.ajax({ 
					type: "POST",
					cache: false,
					url: aCmd.allowP, 
					data: { 'item_id': $(this).attr('data-i') },
					success: function( resp ){

						if ( $.trim(resp) == 1 )
						{
							swal( "Access denied" , "You must be an administrator to perform this action !", "warning");
						}
						else
						{
							swal(nameProduct, "is allowed for sale !", "success");
							productsTable.ajax.reload();
						}
					},
					error : function(){
						swal( "unexpected error" , "an error occurred during the update !", "error");
					}
				});
			}

		});

		$('.deleteItem').on('click', function() {

			var nameProduct = $(this).closest('tr').find('td:eq(0)').text();

			if ( confirm("sure delete : " + nameProduct + " ?" ) ) { //lang js after

				$.ajax({ 
					type: "POST",
					cache: false,
					url: aCmd.deleteP, 
					data: { 'item_id': $(this).attr('data-i') },
					success: function( resp ){

						if ( $.trim(resp) == 1 )
						{
							swal( "Access denied" , "You must be an administrator to perform this action !", "warning");
						}
						else
						{
							swal(nameProduct, "has been successfully removed !", "success");
							productsTable.ajax.reload();
						}
					},
					error : function(){
						swal( "unexpected error" , "an error occurred during deletion !", "error");
					}
				});
			}

		});

	});

/*
|===============================================================================
| Categories
|===============================================================================
*/

	categoriesTable = $('#categoriesTable').DataTable({
		"bLengthChange": false,
		"processing": true,
		"serverSide": true,
		"order": [],
		"columnDefs": [
			{
		      "targets": 1,
		      "orderable": false
		    }
	    ],
		"ajax": {
			url: dt.c,
			type: "POST"
		},
		"fnDrawCallback": function(oSettings) {

	        if ( $('#categoriesTable_paginate span .paginate_button').length < 2 ) {
	            $('#categoriesTable_paginate').hide();
	        }
	    }
	});

});