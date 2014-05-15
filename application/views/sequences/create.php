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
	<?php echo form_open(site_url("sequences/create"), $attributes);?>
	
		<!-- Text input for sequence name -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sequence_name">Sequence name</label>
			<div class="col-sm-4">
				<input id="sequence_name" name="sequence_name" placeholder="" class="form-control" required="" type="text">
				<p class="help-block">Enter the sequence name, e.g. "Roach fighting"</p>
			</div>
		</div>
		
		<!-- Text input for sequence description -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sequence_description">Sequence description</label>
			<div class="col-sm-4">
				<input id="sequence_description" name="sequence_description" placeholder="" class="form-control" type="text">
				<p class="help-block">Enter a brief description of the sequence</p>
			</div>
		</div>
		
		<!-- Button -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="submit">Submit</label>
			<div class="col-sm-4">
				<button id="submit" name="submit" class="btn btn-default">Create sequence</button>
			</div>
		</div>

	<?php echo form_close();?>
</div>
