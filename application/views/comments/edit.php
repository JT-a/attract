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
<?php echo form_open("sequences/edit/" . $sequence['sequence_id'], $attributes);?>
<?php echo form_hidden('sequence_id', $sequence['sequence_id']); ?>
<fieldset>

<!-- Form Name -->
<legend>Sequence details</legend>

<!-- Text input-->
<div class="control-group">
	<label class="control-label" for="sequence_name">Sequence name</label>
	<div class="controls">
		<input id="sequence_name" name="sequence_name" value="<?php print_r($sequence['sequence_name']); ?>" class="input-xlarge" required="" type="text">
		<p class="help-block">enter the sequence name, e.g. "Tube"</p>
	</div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="sequence_description">Sequence description</label>
  <div class="controls">
    <input id="sequence_description" name="sequence_description" value="<?php print_r($sequence['sequence_description']); ?>" class="input-xlarge" required="" type="text">
    <p class="help-block">a brief description of the sequence</p>
  </div>
</div>


<!-- Button -->
<div class="control-group">
	<label class="control-label" for="submit">Submit</label>
	<div class="controls">
		<button id="submit" name="submit" class="btn btn-inverse">Edit sequence</button>
		<a href="/sequences/" class="btn btn-warning">Cancel</a>
	</div>
</div>


</fieldset>
<?php echo form_close();?>
</div>

