<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<?php 
if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>

<div class="<?php echo $span_value ?>">

<script>
	// we generate dropdown menus from the $tasks and $statuses tables
	
	var dropdown_group = '<div class="row row-task">' +
		'<div class="col-md-2">' +
	    	'<select class="task_id_new form-control">' +
	    		'<option>Select Task</option>' +
	    		<?php foreach ($tasks as $task): ?>
					'<option value="<?php echo $task['task_id'] ?>"><?php echo $task['task_name'] ?></option>' +
				<?php endforeach ?>
			'</select>' +
		'</div>' +
		'<div class="col-md-2">' +
			'<select class="status_id_new form-control">' +
		      	<?php foreach ($statuses as $status): ?>
					'<option value="<?php echo $status['status_id'] ?>"><?php echo $status['status_name'] ?></option>' +
				<?php endforeach ?>
		    '</select>' +
		'</div>' +
		'<div class="col-md-2">' +
	    	'<a class="btn btn-danger btn-block remove-task">Remove Task</a>' +
	    '</div>' +
	'</div>';
	
	var multiselect_users = function(shot_task_id) {
		return '<div class="col-md-6">' +
		'<select class="task_owners form-control" name="task_owners[' + shot_task_id + '][]" class="input-xlarge" multiple="multiple">' +
		<?php foreach ($users as $user): ?>
			'<option value="<?php echo $user['id'] ?>">' +
				'<?php echo $user['first_name'] . ' ' . $user['last_name'] ?>' +
			'</option>' +
		<?php endforeach ?>
		'</select>' +
		'</div>';
	} ;
	
	$(document).ready(function() {
		
		$(".task_owners").chosen();
		
		// we do check against this variable to see if a task exists already
		var old_id = '';
				    
	    $(document).on("click", ".remove-task", function() {
	    	var task_id = $(this).parents('.row-task').find('.task_id').val();
	    	var name_value = 'tasks[' + task_id + '][status_id]';
	    	$('#tasks-fields input[name="' + name_value + '"]').remove();
	    	console.log(task_id);
			$(this).parents('.row-task').remove();
		});
		
		$(document).on("click", ".add-task", function() {
			$(this).parent().before(dropdown_group);
		});
		
		$(document).on("click", ".task_id", function() {
			old_id = $(this).val();
		});
		
		$(document).on("click", ".task_id_new option", function() {
			var shot_id = $('input[name=shot_id]').val();
			var task_id = $(this).val();
			var status_id = $(this).parents('.row-task').find('.status_id_new').val();
			var name_value = 'tasks[' + task_id + '][status_id]';
			
			if ($('#tasks-fields input[name="' + name_value + '"]').val() != null) {
				console.log('The field exists');
			} else {
				console.log('Adding new taska');
				$('#tasks-fields').append('<input type="hidden" name="' + name_value + '" value="' + status_id + '">');
				
				var shot_task_id = '';
				
				var target = $(this).parent().parent().next()[0];
				
				//console.log(target);
				
				//var set_shot_task_id = function(shot_task_id) {
				//	$(this).parent().next().after(multiselect_users(shot_task_id));
				//}
				
				
				$.post("/shots/post_add_shot_task/" + shot_id, { 'task_id': task_id, 'status_id': status_id })
				.done(function(data) {
					shot_task_id = data;
					$(target).after(multiselect_users(shot_task_id));		
				});
	
				// we remove temporary classes and assign the normal one
				$(this).parent().removeClass('task_id_new').addClass('task_id');
				$(this).parents('.row-task').find('.status_id_new').removeClass('status_id_new').addClass('status_id');
			}

			//$(this).parent().before(aa); <input type="hidden" name="tasks[1][status_id]" value="7"> task_id status_id
			//tasks-fields
		});
		
		$(document).on("click", ".task_id option", function() {
			//console.log('old_task_id: ' + old_id);
			//console.log('old_task_id: ' + $(this).parent().val());
			var task_id = $(this).val();
			var status_id = $(this).parents('.row-task').find('.status_id').val();
			var old_name_value = 'tasks[' + old_id + '][status_id]';
			var name_value = 'tasks[' + task_id + '][status_id]';
			
			if ($('#tasks-fields input[name="' + name_value + '"]').val() != null) {
				console.log('The field exists');
			} else {
				console.log('Adding new task');
				$('#tasks-fields input[name="' + old_name_value + '"]').remove();
				$('#tasks-fields').append('<input type="hidden" name="' + name_value + '" value="' + status_id + '">');
			}
			
			//$(this).parent().before(aa); <input type="hidden" name="tasks[1][status_id]" value="7"> task_id status_id
			//tasks-fields
		});
		
		$(document).on("click", ".status_id option", function() {
			var status_id = $(this).val()
			var task_id = $(this).parents('.row-task').find('.task_id').val();
			console.log('task_id: ' + task_id);
			console.log('status_id: ' + status_id);
			$('input[name="tasks[' + task_id +'][status_id]"]').val(status_id);
			/*
			var name_value = 'tasks[' + task_id + '][status_id]';
			$('#tasks-fields').append(name_value);
			console.log($(this).parent().attr('name'));
			if ($('#tasks-fields input').attr('name') === name_value){
				console.log('This task exists already');
			} else {
				$('#tasks-fields').append('<input type="hidden" name="' + name_value + '" value="1">')
			}
			*/
			
			//$(this).parent().before(aa); <input type="hidden" name="tasks[1][status_id]" value="7"> task_id status_id
			//tasks-fields
		});
	});
</script>

<h2>Shot <?php echo $shot['shot_name'] ?></h2>
				
<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1">Edit</a></li>
                <li><a href="<?php echo site_url("/shots/view/{$shot['shot_id']}") ?>">Comments</a></li>
	</ul>
</div>

<?php if (isset($flashdata)):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flashdata ?>
</div>
<?php endif ?>

<?php echo validation_errors(); ?>

<?php 
	$attributes = array('role' => 'form');
	echo form_open('shots/edit/' . $shot['shot_id'] , $attributes) 
?>

	<!-- Hidden inputs-->
	<?php echo form_hidden('shot_id', $shot['shot_id']); ?>
	
	<div class="row">
		<!-- Text input-->
		<div class="col-md-3">
			<label class="control-label" for="shot_name">Name</label>
			<input id="shot_name" name="shot_name" value="<?php echo $shot['shot_name']; ?>" class="form-control" required="" type="text">
			<span class="help-block">Shot name, such as "a2s32"</spam>
		</div>
		
		<!-- Select Scene -->
		<div class="col-md-3">
			<label class="control-label" for="scene_id">Scene</label>
			<select id="scene_id" name="scene_id" class="form-control">
		      	<?php foreach ($scenes as $scene): ?>
					<option value="<?php echo $scene['scene_id'] ?>"  <?php echo ($scene['scene_id'] == $shot['scene_id'] ? "selected=\"selected\"" : ""); ?>><?php echo $scene['scene_name'] ?></option>
				<?php endforeach ?>
		    </select>
		</div>
		
		<!-- Text input-->
		<div class="col-md-3">
		  	<label class="control-label" for="shot_duration">Shot duration</label>
		  	<input id="shot_duration" name="shot_duration" value="<?php echo $shot['shot_duration']; ?>" class="form-control" required="" type="text">
		    <span class="help-block">Duration of the shot in frames</span>
		</div>
		
		<!-- Select Status -->
		<div class="col-md-3">
			<label class="control-label" for="status_id">Status</label>
			<select id="status_id" name="shot_status_id" class="form-control">
		      	<?php foreach ($statuses as $status): ?>
					<option value="<?php echo $status['status_id'] ?>"  <?php echo ($status['status_id'] == $shot['status_id'] ? "selected=\"selected\"" : ""); ?>><?php echo $status['status_name'] ?></option>
				<?php endforeach ?>
		    </select>
			<span class="help-block">Not for stats purposes</span>
		</div>
	</div>
	
	
	<div class="row">
		<!-- Textarea -->
		<div class="col-md-6">
		  	<label class="control-label" for="shot_description">Shot description</label>                    
		    <textarea class="form-control" rows="4" id="shot_description" name="shot_description"><?php echo $shot['shot_description']; ?></textarea>
		</div>
		
		<!-- Textarea -->
		<div class="col-md-6">
		  	<label class="control-label" for="shot_notes">Notes</label>             
		    <textarea class="form-control" rows="4" id="shot_notes" name="shot_notes"><?php echo $shot['shot_notes']; ?></textarea>
		</div>
	</div>

					
	<div class="row">
		<!-- Select Task -->
		<div class="control-group col-md-12" id="tasks-selectors">
			<label class="control-label" for="stage_id">Task</label>
			
				<!-- <select id="task_id" name="task_id" class="input-xlarge">
			      	<?php foreach ($tasks as $task): ?>
						<option value="<?php echo $task['task_id'] ?>"><?php echo $task['task_name'] ?></option>
					<?php endforeach ?>
			    </select> -->
			    
		    <?php foreach ($shot_tasks as $shot_task): ?>
		
		    <div class="row row-task">
		    	<div class="col-md-2">
			    	<select class="task_id form-control" name="task_id">
			    		<?php foreach ($tasks as $task): ?>
							<option value="<?php echo $task['task_id'] ?>" <?php echo ($task['task_id'] == $shot_task['task_id'] ? "selected=\"selected\"" : ""); ?>><?php echo $task['task_name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="col-md-2">
					<select class="status_id form-control" name="status_id" class="input-xlarge">
				      	<?php foreach ($statuses as $status): ?>
							<option value="<?php echo $status['status_id'] ?>"  <?php echo ($status['status_id'] == $shot_task['status_id'] ? "selected=\"selected\"" : ""); ?>><?php echo $status['status_name'] ?></option>
						<?php endforeach ?>
				    </select>
				</div>
				<div class="col-md-6">
					<select class="task_owners form-control" name="task_owners[<?php echo $shot_task['shot_task_id'] ?>][]" class="input-xlarge" multiple="multiple">
					<?php 
					$shot_tasks_users_id = array();
					foreach ($shot_tasks_users as $shot_task_user)
					{
						// Selector for owners of each task. First we build an array with the user_ids associated
						// with a specific task	
						
						if ($shot_task_user['shot_task_id'] == $shot_task['shot_task_id'] ) 
						{
							array_push($shot_tasks_users_id, $shot_task_user['user_id']);
						}
					}
					?>
								
					<?php foreach ($users as $user): ?>
						<option value="<?php echo $user['id'] ?>" <?php echo (in_array($user['id'], $shot_tasks_users_id) ? "selected=\"selected\"" : ""); ?>>
							<?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
						</option>
					<?php endforeach ?>
					</select>
				</div>
			    <div class="col-md-2">
			    	<a class="btn btn-danger btn-block remove-task">Remove Task</a>
			    </div>
			</div>
			<?php endforeach ?>
			
			
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default btn-block add-task">Add Task</a>
				</div>
			</div>
			
		</div>
	</div>	
	
	  	
	  	<!-- <select id="tasks" name="tasks" class="input-xlarge" multiple="multiple">
	  	<?php foreach ($shot_tasks as $task): ?>
			<option value="<?php echo $task['task_id'] ?>"><?php echo $task['task_name'] ?></option>
		<?php endforeach ?>
		</select> -->
		
		<div id="tasks-fields">
			<?php foreach ($shot_tasks as $shot_task): ?>
				<input type="hidden" name="tasks[<?php echo $shot_task['task_id'] ?>][status_id]" value="<?php echo $shot_task['status_id'] ?>">
			<?php endforeach ?>
		</div>
	
	

	<hr>
	<!-- Button -->
	<div class="row">
	  <div class="col-md-12">
	    <button id="submit" name="submit" class="btn btn-default">Update Shot</button>
	    <a href="<?php echo '/shots/delete/' . $shot['shot_id'] ?>" class="btn btn-danger">Delete Shot</a>
	  </div>
	</div>
	

</form>
</div> <!-- span9 -->




