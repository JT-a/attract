<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); 

if ($this->session->flashdata('message') != '')
{
	$flashdata = $this->session->flashdata('message'); 
}

?>

<div class="<?php echo $span_value ?>">

<?php if (isset($flashdata)):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flashdata ?>
</div>
<?php endif ?>

<h2><?php echo $title ?></h2>

<script>

var make_status_dropdown = function(status) {
	
	// The following function generates a boostrap-style dropdown according
	// to the "status" input given. The content of the dropdown menu itself
	// can be loaded via further javascript, in order to reduce weight on 
	// the DOM.
	
	var btn_style = '';
	var label = '';
	
	if (status == "in_progress") {
		var btn_style = 'btn-warning';
		var label = 'In Progress';
	} else if (status == "todo") {
		var btn_style = 'btn-default';
		var label = 'To do';
	} else if (status == "fix") {
		var btn_style = 'btn-important';
		var label = 'Fix';
	} else if (status == "final_1") {
		var btn_style = 'btn-success';
		var label = 'Final 1';
	} else if (status == "review") {
		var btn_style = '';
		var label = 'Review';
	} 
	
	var markup = '<div class="btn-group btn-group-cell">';
	var markup = markup + '<a class="btn btn-mini dropdown-toggle dropdown-status ' + btn_style + '" data-toggle="dropdown" href="#">';
	var markup = markup + label;
	var markup = markup + '<span class="caret"></span></a><ul class="dropdown-menu dropdown-menu-statuses"></ul></div> ';

	return markup;
};

// THIS FUNCTION IS UNUSED AT THE MOMENT
var make_status_label = function(status) {
	
	// The following function generates a boostrap-style dropdown according
	// to the "status" input given. The content of the dropdown menu itself
	// can be loaded via further javascript, in order to reduce weight on 
	// the DOM.
	
	var btn_style = '';
	var label = '';
	
	if (status == "in_progress") {
		var btn_style = 'label-warning';
		var label = 'In Progress';
	} else if (status == "todo") {
		var btn_style = 'label-default';
		var label = 'To do';
	} else if (status == "fix") {
		var btn_style = 'label-important';
		var label = 'Fix';
	} else if (status == "final_1") {
		var btn_style = 'label-success';
		var label = 'Final 1';
	} else if (status == "review") {
		var btn_style = 'label-info';
		var label = 'Review';
	} else {
		var btn_style = 'label-inverse';
		var label = status;
	}
	
	var markup = '<span class="label ' + btn_style + '">';
	var markup = markup + label;
	var markup = markup + '</span>';

	return markup;
};


var trim_string = function(string, length) {
	if (string.length > length) {
		var trimmedString = string.substring(0, length);
		trimmedString = trimmedString + '...';
		return trimmedString;
	}
}

// DataTables functionality (we inizialize the table and call it shotsTable)
// then we replace the content of the 3rd and 4th column with some js generated code


$(document).ready(function() {
    var shotsTable = $('#shots').dataTable( {
    	"iDisplayLength": 50,
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			// we disable the status dropdown column
			// also, we are not parsing the status label, but we build it directly in the table
			//$('td:eq(3)', nRow).html(make_status_label(aData[3]));
			$('td:eq(1)', nRow).html(trim_string(aData[1], 40));
		},
		"aoColumns": [ 
			/* Name */   null,
			/* Description */  null,
			/* Duration */ { "bSearchable": false},
			/* Status */  { "bSearchable": false},
			/* Tasks */   { "bVisible":    false },
			/* Tasks */  // null,
			/* Notes */    null,
			/* Owners */   { "bSearchable": false}
			
		] 
	//shotsTable.fnStandingRedraw();
    });
    
	$('select', this).change( function () {
		options = $(this).val();
		if (options) {
			str = options.toString();
			str = str.replace(/,/g , " ");
			shotsTable.fnFilter( str, 1);
		} else {
			console.log('clean');
			shotsTable.fnFilterClear();
		}
		
	});

    // the next two functions populate dynamically the content of the dropdown menu
    // with two different lists build previously
    
    $(document).on("click", ".dropdown-status", function() {
		if(!$(this).hasClass('open')) {
       		$(this).next().html(statuses_list);
    	}
	});
	
	
	// this are the functions that actually set the new values in the database
	// and update the table structure
	
	$(document).on("click", ".dropdown-menu-statuses a", function() {
		var status_id = $(this).attr('status_id');
		var status_label = $(this).attr('status_label');
		var tableRow = $(this).parents("tr");
		var rowPosition = shotsTable.fnGetPosition(tableRow[0]);
		var shotID = tableRow.attr("id").split("_")[1];
		
		shotsTable.fnUpdate(status_label, rowPosition ,3);
		query = '/shots/edit_single/' + shotID + '/status_id/' + status_id;
		$.getJSON(query, function() {
			console.log('Shot status updated');	
		});
		
	});
	
	
	$(document).on("click", ".edit-shot", function() {
		
		var tableRow = $(this).parents("tr");
		var rowPosition = shotsTable.fnGetPosition(tableRow[0]);
		var shotID = tableRow.attr("id").split("_")[1];	
		//shotsTable.fnUpdate(stage_label, rowPosition ,4);
		
		query = '/shots/edit/' + shotID + '/1/';
		
		$.get(query, function(data) {
			$('#row_' + shotID).hide();
			$('#row_' + shotID).after('<tr class="expanded-edit"><td colspan=7">' + data + '<td><tr>');
			// TODO investigate why another <td> appears and why we have to remove it
			// with the following line
			$('#row_' + shotID).next().children('td:last').remove();
			//$('#test_load').html(data);
			//console.log('Shot status updated');
		});
		
		console.log(shotID);
		
		
		var scrollVal = tableRow.offset().top - 40;
		//console.log(scrollVal + 50);
		
		$('html, body').animate({
			scrollTop: scrollVal
		}, 500);
				
		
	});
	
	
	$(document).on("click", ".edit-shot-cancel", function() {
		
		var editRow = $(this).parents("tr");
		var originalRow = editRow.prev();
		
		$(editRow).remove();
		$(originalRow).show();
		
		console.log('Canceled any edit');

	});
	
	$(document).on("click", ".edit-shot-submit", function() {
		
		// That's how we get the shot id
		var editRow = $(this).parents("tr");
		var originalRow = editRow.prev();
		var rowPosition = shotsTable.fnGetPosition(originalRow[0]);
		var shotID = originalRow.attr("id").split("_")[1];	
		
		console.log('Submitting edit for shot ' + shotID);
		
		// Here we get all the data to submit for post
		var fields = $(".expanded-edit :input").serializeArray();
		//console.log(fields);
			
		$.post("/shots/edit/" + shotID, fields)
		.done(function(data) {
		  	//console.log("Data Loaded: " + data);
			console.log('success');
		  	$(editRow).remove();
			$(originalRow).show();
		  
		});
		
		//$(editRow).remove();
		//$(originalRow).show();
		
		//console.log('Canceled any edit');
		
	});
	
	$(document).on("click", ".add-task", function() {
		$(this).parent().before(dropdown_group());
		console.log('adding dropdowns');
	});
	
	$(".chzn-select").chosen();
	

});
</script>


<!-- <select class="chzn-select" multiple>
	<?php foreach($users as $owner): ?>
		<option value="<?php echo $owner['first_name']; ?>"><?php echo $owner['first_name']; ?></option>
	<?php endforeach ?>
</select>	 -->
   
   
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="shots">
	<thead>
		<tr>
			<th>Shot Name</th>
			<th>Description</th>
			<th>Duration</th>
			<th>Status</th>
			<th>Tasks</th>
			<th>Notes</th>
			<th width="8%"></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($shots as $shot): ?>
    	<tr id="row_<?php echo $shot['shot_id'] ?>">
    		<td><a href="<?php echo site_url("shots/view/{$shot['shot_id']}") ?>"><?php echo $shot['shot_name'] ?></a></td>
    		<td><?php echo $shot['shot_description'] ?></td>
    		<td><?php echo $shot['shot_duration'] ?></td>
    		<td><span class="label label-default" style="background-color:<?php echo $shot['status_color'] ?>"><?php echo $shot['status_name'] ?></span></td> 
    		<td><?php echo $shot['task_names'] ?></td>
    		<td><?php echo $shot['shot_notes'] ?></td>
    		<td><?php echo $shot['user_id']?> 
    			<!-- we temporarily disabled in-table shot editing, too much work for now -->
    			<!-- <a class="btn btn-default btn-xs edit-shot" href="#"><i class="icon-edit"></i> Edit</a> -->
    			<a class="btn btn-default btn-xs" href="<?php echo site_url("shots/edit/{$shot['shot_id']}") ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
    		</td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Shot Name</th>
			<th>Description</th>
			<th>Duration</th>
			<th>Status</th>
			<th>Tasks</th>
			<th>Notes</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<a class="btn btn-default btn-lg btn-block" data-toggle="modal" shot="<?php echo site_url("shots/create")?>" href="#">Add shot</a>

</div><!--/span-->

<script>
$(document).ready(function() {
	// Support for AJAX loaded modal window.
	// Focuses on first input textbox after it loads the window.
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('shot');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} else {
			$.get(url, function(data) {
				$('<div class="modal fade">' + data + '</div>').modal();
			}).success(function() { $('input:text:visible:first').focus(); });
		}
	});
});
</script>


