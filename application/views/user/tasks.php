<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="tasks">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Task</th>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($shots as $shot): ?>
    	<tr>
    		<td><a href="/shots/view/<?php echo $shot['shot_id'] ?>"><?php echo $shot['shot_name'] ?></a></td>
    		<td><?php echo $shot['shot_description'] ?></td>
    		<td><?php echo $shot['task_name'] ?></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Task</th>
		</tr>
	</tfoot>
</table>

</div><!--/span-->



