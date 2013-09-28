<?php 
$validation_errors = validation_errors();

if ($this->session->flashdata('message') != '')
	{
	    $flahsdata = $this->session->flashdata('message'); 
	}
?>
<?php if($validation_errors):?>
<div class="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $validation_errors ?>
</div>
<?php endif ?>

<?php if (isset($flahsdata)):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flahsdata ?>
</div>
<?php endif ?>

<?php $attributes = array('class' => 'form-horizontal'); ?>
<?php echo form_open("tasks/create", $attributes);?>
<fieldset>

<!-- Form Name -->
<legend>Task details</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="task_name">Task name</label>
  <div class="controls">
    <input id="task_name" name="task_name" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">enter the stage name, e.g. "animation"</p>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit">Submit</label>
  <div class="controls">
    <button id="submit" name="submit" class="btn btn-inverse">Create task</button>
  </div>
</div>


</fieldset>
<?php echo form_close();?>
