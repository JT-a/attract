<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<?php echo form_open("user/profile/");?>

<!-- Text input-->
<div class="form-group">
	<label class="control-label" for="first_name">First name</label>
	<input id="first_name" name="first_name" value="<?php print_r($user['first_name']); ?>" class="form-control" type="text" required="">
</div>

<!-- Text input-->
<div class="form-group">
	<label class="control-label" for="last_name">Last name</label>
	<input id="last_name" name="last_name" value="<?php print_r($user['last_name']); ?>" class="form-control" type="text" required="">
</div>

<!-- Text input-->
<div class="form-group">
	<label class="control-label" for="email">Email</label>
	<input id="email" name="email" value="<?php print_r($user['email']); ?>" class="form-control" type="text" required="">
</div>

<!-- Text input-->
<div class="form-group">
	<label class="control-label" for="company">Studio</label>
	<input id="company" name="company" value="<?php print_r($user['company']); ?>" class="form-control" type="text">
</div>


<button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>

<?php echo form_close();?>

</div><!--/span-->



