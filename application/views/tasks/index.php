<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<?php 
if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>


<div class="<?php echo $span_value ?>">

	<h2><?php echo $title ?></h2>
	
	<?php if (isset($flashdata)):?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo $flashdata ?>
	</div>
	<?php endif ?>

	
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="tasks">
		<thead>
			<tr>
				<th>Task ID</th>
				<th>Task name</th>
			</tr>
		</thead>
		<tbody>
			
		<?php foreach ($tasks as $task): ?>
	    	<tr>
	    		<td><?php echo $task['task_id'] ?></td>
                        <td><a href="#" task="<?php echo site_url("/tasks/edit/{$task['task_id']}") ?>" data-toggle="modal"><?php echo $task['task_name'] ?></a></td>
	    	</tr>
		<?php endforeach ?>
			
		</tbody>
		<tfoot>
			<tr>
				<th>Task ID</th>
				<th>Task name</th>
			</tr>
		</tfoot>
	</table>
	
        <a class="btn btn-default btn-lg btn-block" href="<?php echo site_url("/tasks/create/"); ?>">Add task</a>
	
</div><!--/span-->


<script>
$(document).ready(function() {
	// Support for AJAX loaded modal window.
	// Focuses on first input textbox after it loads the window.
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('task');
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
