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
	<?php echo form_open("scenes/create", $attributes);?>
	
		<!-- Text input for scene name -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="scene_name">Scene name</label>
			<div class="col-sm-4">
				<input id="scene_name" name="scene_name" placeholder="" class="form-control" required="" type="text">
				<p class="help-block">Enter the scene name, e.g. "a1s07"</p>
			</div>
		</div>
		
		<!-- Text input for scene description -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="scene_description">Scene description</label>
			<div class="col-sm-4">
				<input id="scene_description" name="scene_description" placeholder="" class="form-control" type="text">
				<p class="help-block">Enter a brief description of the scene</p>
			</div>
		</div>
		
		<!-- Select Basic -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sequence_id">Sequence</label>
		  	<div class="col-sm-4">
		    	<select id="sequence_id" name="sequence_id" class="form-control">
		    		<?php foreach ($sequences as $sequence): ?>
		      		<option value="<?php echo $sequence['sequence_id']; ?>"><?php echo $sequence['sequence_name']; ?></option>
		      		<?php endforeach; ?>
		    	</select>
		  	</div>
		</div>
		
		<!-- Button -->
		<div class="form-group">
			<label class="col-sm-2 control-label" for="submit">Submit</label>
			<div class="col-sm-4">
				<button id="submit" name="submit" class="btn btn-default">Create scene</button>
			</div>
		</div>

	<?php echo form_close();?>
</div>
