/*! Automatically Highlight Active Menu Link */
$(document).ready(function () {
	var url = window.location;
	// Will only work if string in href matches with location
	$('ul.nav a[href="' + url + '"]').parent().addClass('active');

	// Will also work for relative and absolute hrefs
	$('ul.nav a').filter(function () {
		return this.href == url;
	}).parent().addClass('active').parent().parent().addClass('active');
});	

//Date-Picker Start
$('#datetime').datetimepicker({
	format: 'DD/MM/YYYY H:mm',
});
$('#datepicker').datetimepicker({
	format: 'DD/MM/YYYY',
});
$('#datepicker2').datetimepicker({
	format: 'DD/MM/YYYY',
});

$('#datepicker3').datetimepicker({
	format: 'DD/MM/YYYY',
});

$('#datepicker4').datetimepicker({
	format: 'DD/MM/YYYY',
});
$('#timepicker').datetimepicker({
	format: 'h:mm A', 
});
$("#date1").datetimepicker({
 format: 'DD-MM-YYYY',
});
$("#date2").datetimepicker({
  format: "DD-MM-YYYY"
});
$("#date3").datetimepicker({
  format: "DD-MM-YYYY"
});
//turn off autocomplete for date fields
$('#date1').attr('autocomplete','off');
$('#date2').attr('autocomplete','off');
$('#date3').attr('autocomplete','off');
//Select2
$('.basic').select2({
	theme: "bootstrap"
});
$('.basic2').select2({
	theme: "bootstrap"
});
$('.basic3').select2({
	theme: "bootstrap"
});
$('.basic4').select2({
	theme: "bootstrap"
});
$('.basic5').select2({
	theme: "bootstrap"
});

$('#multiple').select2({
	theme: "bootstrap"
});

$('#multiple-states').select2({
	theme: "bootstrap"
});

$('#tagsinput').tagsinput({
	tagClass: 'badge-info'
});

//Price Slider
$( function() {
	$( "#slider" ).slider({
		range: "min",
		max: 100,
		value: 40,
	});
	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 75, 300 ]
	});
} );

//Datatables
$(document).ready(function() {
	$('#basic-datatables').DataTable({
		"pageLength": 25,
	});

	$('#multi-filter-select').DataTable( {
		"pageLength": 5,
		initComplete: function () {
			this.api().columns().every( function () {
				var column = this;
				var select = $('<select class="form-control"><option value=""></option></select>')
				.appendTo( $(column.footer()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
						);

					column
					.search( val ? '^'+val+'$' : '', true, false )
					.draw();
				} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	});

	// Add Row
	$('#add-row').DataTable({
		"pageLength": 5,
	});

	var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

	$('#addRowButton').click(function() {
		$('#add-row').dataTable().fnAddData([
			$("#addName").val(),
			$("#addPosition").val(),
			$("#addOffice").val(),
			action
			]);
		$('#addRowModal').modal('hide');

	});


//select2 get name
});

// Alert Auto Close
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 6000);