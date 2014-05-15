		<div class="col-md-3">
			<div class="list-group">
				<a href="<?php echo site_url("/user/tasks/") ;?>" class="list-group-item <?php echo ($title == 'My tasks' ? "active" : ""); ?>">My tasks</a>
				<a href="<?php echo site_url("/user/activity/") ;?>" class="list-group-item <?php echo ($title == 'Activity' ? "active" : ""); ?>">
					Activity 
					<?php echo ($unread_comment_notifications > 0 ? ' <span class="badge">' . $unread_comment_notifications . '</span> ' : ''); ?>
				</a>
		      	<a href="<?php echo site_url("/user/profile/") ;?>" class="list-group-item <?php echo ($title == 'Edit Profile' ? "active" : ""); ?>">Profile</a>
		      	<a href="<?php echo site_url("/user/password/") ;?>" class="list-group-item <?php echo ($title == 'Password' ? "active" : ""); ?>">Password</a>
			</div>

        </div><!--/span-->
        