<div class="modal-dialog">
    <div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        	<h4 class="modal-title">Task details</h4>
		</div>
		<div class="modal-body">
			<?php $attributes = array('id' => 'the-task'); ?>
			<?php echo form_open(site_url("tasks/edit/" . $task['task_id']), $attributes);?>
			<?php echo form_hidden('task_id', $task['task_id']); ?>
			
			<!-- Text input-->
			<div class="form-group">
				<label class="control-label" for="task_name">Task name</label>
				<input id="task_name" name="task_name" value="<?php echo $task['task_name'] ?>" class="form-control" type="text" required="">
				<p class="help-block">Enter the task name, e.g. "Animation"</p>
			</div>
		
			<?php echo form_close();?>
		</div>
		<div class="modal-footer">
                        <a href="<?php echo site_url("/tasks/delete/{$task['task_id']}"); ?>" id="delete" class="btn btn-danger pull-left"><i class="glyphicon glyphicon-fire icon-white"></i> Delete</a>
			<button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo assets_url(); ?>/js/jquery.validate.min.js"></script>
<script>	
	var validator = $( "#the-task" ).validate();
		
	$('#submit').click(function(){
		if (validator.form()) {
			$('.modal-body > form').submit();
		} else {
			return false;
		}
		
	});
</script>

