<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<?php echo form_open("user/password/");?>

<!-- Password input-->
<div class="form-group">
	<label class="control-label" for="password">New password</label>
	<input id="password" name="password" value="" class="form-control" type="password">
</div>

<!-- Password input-->
<div class="form-group">
	<label class="control-label" for="password_confirm">Confirm password </label>
	<input id="password_confirm" name="password_confirm" value="" class="form-control" type="password">
</div>
<button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>

<?php echo form_close();?>

</div><!--/span-->



