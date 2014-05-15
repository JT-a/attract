<div class="modal-dialog">
    <div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        	<h4 class="modal-title">User details</h4>
		</div>
		<div class="modal-body">
			<?php $attributes = array('id' => 'new-user'); ?>
			<?php echo form_open(site_url("admin/create_user/"), $attributes);?>
			
			<!-- Text input-->
			<div class="form-group">
				<label class="control-label" for="first_name">First name</label>
				<input id="first_name" name="first_name" class="form-control" type="text" required="">
				<p class="help-block">enter first name, e.g. "Katniss"</p>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
				<label class="control-label" for="last_name">Last name</label>
				<input id="last_name" name="last_name" class="form-control" type="text" required="">
				<p class="help-block">enter last name, e.g. "Everdeen"</p>
			</div>
			
			<!-- Email input-->
			<div class="form-group">
				<label class="control-label" for="email">Email address</label>
				<input id="email" name="email" class="form-control" type="email" required="">
				<p class="help-block">katniss@district12.panem</p>
			</div>
			
			<!-- Password input-->
			<div class="form-group">
				<label class="control-label" for="password">Password</label>
				<input id="password" name="password" value="" class="form-control" type="password">
			</div>
			
			<!-- Password input-->
			<div class="form-group">
				<label class="control-label" for="password_confirm">Confirm password </label>
				<input id="password_confirm" name="password_confirm" value="" class="form-control" type="password">
			</div>
			
			<?php echo form_close();?>
		</div>
		<div class="modal-footer">
			<button type="submit" id="submit" class="btn btn-primary" >Add User</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo assets_url(); ?>/js/jquery.validate.min.js"></script>
<script>	
	var validator = $( "#new-user" ).validate({
		 rules: {
			password: {
				required: true,
				minlength: 8
			}
		},
		messages: {
			password: {
			required: "Choose a password please",
			minlength: jQuery.format("At least {0} characters required!")
			}
		}
	});
		
	$('#submit').click(function(){
		if (validator.form()) {
			$('.modal-body > form').submit();
		} else {
			return false;
		}
		
	});
</script>

