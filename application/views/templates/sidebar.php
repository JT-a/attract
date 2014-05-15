<div class="col-md-3">
    <div class="list-group">
        <a href="<?php echo site_url('shots') ?>" class="list-group-item <?php echo ($title == "Shots" ? "active" : ""); ?>">Shots</a>
        <a href="<?php echo site_url('scenes') ?>" class="list-group-item <?php echo ($title == "Scenes" ? "active" : ""); ?>">Scenes</a>
        <a href="<?php echo site_url('sequences') ?>" class="list-group-item <?php echo ($title == "Sequences" ? "active" : ""); ?>">Sequences</a>
        <a href="<?php echo site_url('stats') ?>" class="list-group-item <?php echo ($title == "Stats" ? "active" : ""); ?>">Stats</a>
    </div>


    <?php if ($is_admin == TRUE): ?>
        <div class="panel panel-default">
            <div class="panel-heading">Admin Panel</div>
            <div class="list-group">
                <a href="<?php echo site_url('/admin/users') ?>" class="list-group-item <?php echo ($title == "Users" ? "active" : ""); ?>">User management</a>
                <a href="<?php echo site_url('tasks') ?>" class="list-group-item <?php echo ($title == "Tasks" ? "active" : ""); ?>">Tasks</a>
                <a href="<?php echo site_url('statuses') ?>" class="list-group-item <?php echo ($title == "Statuses" ? "active" : ""); ?>">Statuses</a>
                <a href="<?php echo site_url('admin/calendar') ?>" class="list-group-item <?php echo ($title == "Calendar" ? "active" : ""); ?>">Calendar</a>
                <a href="<?php echo site_url('shows') ?>" class="list-group-item <?php echo ($title == "Shows" ? "active" : ""); ?>">Show management</a>
            </div>

        </div>

    <?php endif ?>
</div><!--/span-->