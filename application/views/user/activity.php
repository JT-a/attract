<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="activity">
	<thead>
		<tr>
			<th>Notification</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($comment_notifications as $comment): ?>
    	<tr <?php echo ($comment['was_seen'] == TRUE ? 'class="seen_notification"' : ''); ?>>   		
    		<td>New comment on <a href="/shots/view/<?php echo $comment['shot_id'] ?>/view_comments"><?php echo $comment['shot_name'] ?></a></td>
    		<td><?php echo $comment['user_id'] ?></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Notification</th>
			<th></th>
		</tr>
	</tfoot>
</table>

</div><!--/span-->
