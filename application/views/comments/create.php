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
<?php echo form_open("comments/create", $attributes);?>
<fieldset>

<!-- Form Name -->
<legend>Comment details</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="shot_id">Comment name</label>
  <div class="controls">
    <input id="shot_id" name="shot_id" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">enter the comment name, e.g. "Tube"</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="user_id">Comment description</label>
  <div class="controls">
    <input id="user_id" name="user_id" placeholder="" class="input-xlarge" required="" type="text">
    <p class="help-block">a brief description of the comment</p>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="comment_body">Commend body</label>
  <div class="controls">                     
    <textarea id="comment_body" name="comment_body"></textarea>
  </div>
</div>



<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit">Submit</label>
  <div class="controls">
    <button id="submit" name="submit" class="btn btn-inverse">Create comment</button>
  </div>
</div>


</fieldset>
<?php echo form_close();?>

