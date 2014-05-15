<?php 
$validation_errors = validation_errors();

if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>

<div class="col-md-12">
	<h2><?php echo $title ?></h2>
	<?php if ($validation_errors):?>
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo $validation_errors ?>
	</div>
	<?php endif ?>
	
	<?php if (isset($flashdata)):?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo $flashdata ?>
	</div>
	<?php endif ?>
		
	<?php $attributes = array('class' => 'form-horizontal', 'role' => 'form'); ?>
	<?php echo form_open(site_url("tasks/create"), $attributes);?>
	
		<!-- Text input for task name -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="task_name">Task name</label>
			<div class="col-sm-4">
				<input id="task_name" name="task_name" placeholder="" class="form-control" required="" type="text">
				<p class="help-block">Enter the task name, e.g. "Animation"</p>
			</div>
		</div>
		
		<!-- Text input for task description -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="task_description">Task description</label>
			<div class="col-sm-4">
				<input id="task_description" name="task_description" placeholder="" class="form-control" type="text">
				<p class="help-block">Enter a brief description of the task</p>
			</div>
		</div>
		
		<!-- Button -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="submit">Submit</label>
			<div class="col-sm-4">
				<button id="submit" name="submit" class="btn btn-default">Create task</button>
			</div>
		</div>

	<?php echo form_close();?>
</div>
