<div class="modal-dialog">
    <div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        	<h4 class="modal-title">Sequence details</h4>
		</div>
		<div class="modal-body">
			<?php $attributes = array('id' => 'new-sequence'); ?>
			<?php echo form_open(site_url("sequences/edit/" . $sequence['sequence_id']), $attributes);?>
			<?php echo form_hidden('sequence_id', $sequence['sequence_id']); ?>
			
			<!-- Text input-->
			<div class="form-group">
				<label class="control-label" for="sequence_name">Sequence name</label>
				<input id="sequence_name" name="sequence_name" value="<?php print_r($sequence['sequence_name']); ?>" class="form-control" type="text" required="">
				<p class="help-block">enter the sequence name, e.g. "Tube"</p>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="control-label" for="sequence_description">Sequence description</label>
			  <input id="sequence_description" name="sequence_description" value="<?php print_r($sequence['sequence_description']); ?>" class="form-control" required="" type="text">
			  <p class="help-block">a brief description of the sequence</p>
			</div>
		
			<?php echo form_close();?>
		</div>
		<div class="modal-footer">
			<a href="/sequences/delete/<?php echo $sequence['sequence_id']; ?>" id="delete" class="btn btn-danger pull-left"><i class="glyphicon glyphicon-fire icon-white"></i> Delete</a>
			<button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo assets_url(); ?>/js/jquery.validate.min.js"></script>
<script>	
	var validator = $( "#new-sequence" ).validate();
		
	$('#submit').click(function(){
		if (validator.form()) {
			$('.modal-body > form').submit();
		} else {
			return false;
		}
		
	});
</script>

