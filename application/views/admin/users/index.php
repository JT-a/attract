<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

    <h2><?php echo $title ?></h2>

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="users">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Group</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>

                <tr>
                    <td><img src="<?php echo $user->gravatar; ?>" /> </td>
                    <td><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td>
                        <?php foreach ($user->groups as $group): ?>
                            <span class="label label-default"><?php echo $group->name; ?></span>
                        <?php endforeach ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="#" user="<?php echo site_url("/admin/edit_user/{$user->id}") ?>" data-toggle="modal" class="btn btn-default btn-xs">Edit</a>
                            <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></li>
                                <li><?php echo(anchor('/admin/delete_user/' . $user->id, 'Delete')) ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Group</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <a class="btn btn-default btn-lg btn-block" data-toggle="modal" user="<?php echo site_url("/admin/create_user/") ?>" href="#">Add user</a>

</div><!--/span-->

<script>
    $(document).ready(function() {
        // Support for AJAX loaded modal window.
        // Focuses on first input textbox after it loads the window.
        $('[data-toggle="modal"]').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('user');
            if (url.indexOf('#') == 0) {
                $(url).modal('open');
            } else {
                $.get(url, function(data) {
                    $('<div class="modal fade">' + data + '</div>').modal();
                }).success(function() {
                    $('input:text:visible:first').focus();
                });
            }
        });
    });
</script>




