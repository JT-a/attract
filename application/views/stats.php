<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>


<script>
	$(function() {
		<?php foreach ($tasks as $task_name => $value): ?>
			<?php foreach ($value['statuses'] as $status_name => $status_count): ?>
				$('.dial-<?php echo $task_name ?>-<?php echo $status_name ?>').val(<?php echo $status_count ?>).trigger('change');
			<?php endforeach ?>
		<?php endforeach ?>
	    
	    $('.dial').knob({
	    	'min':0,
	        'max':100,
	        'readOnly': true,
	        //'value': 34,
	        'width': 120,
	        'height': 120,
	        'fgColor': '#333',
	        'dynamicDraw': true,
	        'thickness': 0.2,
	        'tickColorizeValues': true,
			'skin':'tron'
	    });

	});
</script>

<script>
	$(document).ready(function() {
		$('.task-filter', this).change( function () {
			
			var task_id = $(this).attr('task-id');
			var status_id = $(this).val();
			
			var target = $(this).parent().parent().next();
			
			$.post("<?php echo site_url('/shots/post_index')?>", { task_id: task_id, status_id: status_id } , function(data) {
			  //$('.modal-body').html(data);
			  //alert(data);
			  
			  // we check if a table already exists, if yes we remove it
			  if ($(target).next().hasClass('filtered-shots-tasks')) {
			  	$(target).next().remove();
			  } 
			  // we add the new table after the current row
			  $(target).after(data);
			});
			
		});
	    
		
	});
	
	
	
</script>


<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<?php foreach ($tasks as $task_name => $value): ?>
	
	<div class="row status-header">
		<div class="col-md-6">
			<h3 class="stats-title"><?php echo $task_name; ?> - <?php echo $value['tasks_count']; ?> tasks</h3>
		</div>
		<div class="col-md-offset-3 col-md-3">
			<select task-id="<?php echo $value['task_id']; ?>" class="task-filter form-control pull-right">
				<?php foreach ($statuses as $status) : ?>
					<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	
	
	<div class="row status-progress">
		<div class="col-md-12">
			<div class="progress">
			<?php foreach ($value['statuses'] as $status_name => $status): ?>
				<?php if ($status_name != 'todo' AND $status > 0): ?>
				<div class="progress-bar progress-bar-<?php echo $status_name ?>" style="width: <?php echo $status ?>%;"><span><?php echo $status_name ?>: <?php echo $status ?>%</span></div>
				<?php endif ?>
			<?php endforeach ?>
			</div>
		</div>
	</div>
	
	<!-- <div class="row-fluid stats-knobs">
		<?php foreach ($value['statuses'] as $status_name => $status): ?>
		<div class="span2<?php $count == 0 ? print(" offset1") : print(""); ?>">
			<h4><?php echo $status_name ?></h4>
			<p><input type="text"  class="dial dial-<?php echo $task_name ?>-<?php echo $status_name ?>" ></p>
		</div>
		<?php $count++; ?>
		<?php endforeach ?>
	</div> -->

<?php endforeach ?>


<hr>


<h3>Film duration</h3>
<p>Total film duration is <?php echo $total_duration_frames ?> frames, or <?php echo $total_duration_time ?></p>
<h3>Film format</h3>
<p>Film reel is available at the following resolutions </p>
<hr>


</div><!--/span-->



