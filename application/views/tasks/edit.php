<?php $span_value = ($use_sidebar == TRUE ? "span9" : "span12"); ?>
<div class="<?php echo $span_value ?>">
<?php 
$validation_errors = validation_errors();

if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>
<?php if($validation_errors):?>
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

<?php $attributes = array('class' => 'form-horizontal'); ?>
<?php echo form_open(site_url("tasks/edit/" . $task['task_id']), $attributes);?>
<?php echo form_hidden('task_id', $task['task_id']); ?>
<fieldset>

<!-- Form Name -->
<legend>Task details</legend>

<!-- Text input-->
<div class="control-group">
	<label class="control-label" for="task_name">Task name</label>
	<div class="controls">
		<input id="task_name" name="task_name" value="<?php print_r($task['task_name']); ?>" class="input-xlarge" required="" type="text">
		<p class="help-block">enter the stage name, e.g. "animation"</p>
	</div>
</div>

<!-- Button -->
<div class="control-group">
	<label class="control-label" for="submit">Submit</label>
	<div class="controls">
		<button id="submit" name="submit" class="btn btn-inverse">Edit task</button>
		<a href="<?php echo site_url('/tasks/') ?>" class="btn btn-warning">Cancel</a>
	</div>
</div>


</fieldset>
<?php echo form_close();?>
</div>

