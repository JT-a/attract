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
<?php echo form_open(site_url("shows/create"), $attributes);?>
<fieldset>

<!-- Form Name -->
<legend>Show details</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="show_name">Show name</label>
  <div class="controls">
    <input id="show_name" name="show_name" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">enter the show name, e.g. "Tube"</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="show_description">Show description</label>
  <div class="controls">
    <input id="show_description" name="show_description" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">a brief description of the show</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="show_path">Show path</label>
  <div class="controls">
    <input id="show_path" name="show_path" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">the absolute path to the project's root</p>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit">Submit</label>
  <div class="controls">
    <button id="submit" name="submit" class="btn btn-inverse">Create show</button>
  </div>
</div>


</fieldset>
<?php echo form_close();?>

