<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>


<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="shows">
	<thead>
		<tr>
			<th>Show name</th>
			<th>Show description</th>
			<th>Show path</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($shows as $show): ?>
    	<tr id="show_<?php echo $show['show_id'] ?>" <?php echo ($current_show['setting_value'] == $show['show_id'] ? "class=\"success\"" : ""); ?>>
            <td><a href="<?php echo site_url("/shows/edit/{$show['show_id']}") ?>"><?php echo $show['show_name'] ?></a></td>
    		<td><?php echo $show['show_description'] ?></td>
    		<td><?php echo $show['show_path'] ?></td>
    		<td><a class="make-current btn btn-default btn-xs" href="#"><i class="glyphicon glyphicon-glass"></i> Make current</a></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Show name</th>
			<th>Show description</th>
			<th>Show path</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<a class="btn btn-default btn-lg btn-block" href="<?php echo site_url("/shows/create") ?>">Add show</a>
</div><!--/span-->

<script>
	
	$(document).ready(function() {
		$(document).on("click", ".make-current", function() {
			var showID = $(this).parents("tr").attr("id").split("_")[1];
			$.post( "/settings/edit/current_show", { setting_name : "current_show", setting_value: showID, setting_id : "1" } )
			.done(function( data ) {
    			$('tr').removeClass('success');
    			$('#show_' + showID).addClass('success');
    		});
		});
	});
</script>


