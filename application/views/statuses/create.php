<?php 
$validation_errors = validation_errors();

if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>
<div class="col-md-12">
	<h2><?php echo $title ?></h2>
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
	
	<?php $attributes = array('class' => 'form-horizontal', 'role' => 'form'); ?>
	<?php echo form_open(site_url("statuses/create"), $attributes);?>

	
	<!-- Text input-->
	<div class="form-group">
		<label class="col-sm-2 control-label" for="status_name">Status name</label>
	  	<div class="col-sm-4">
	    	<input id="status_name" name="status_name" placeholder="" class="form-control" required="" type="text">
	    	<p class="help-block">enter the status name, e.g. "in_progress"</p>
		</div>
	</div>
	<!-- Button -->
	<div class="form-group">
		<label class="col-sm-2 control-label" for="submit">Submit</label>
		<div class="col-sm-4">
			<button id="submit" name="submit" class="btn btn-default">Create status</button>
		</div>
	</div>
	
	<?php echo form_close();?>
</div>
