<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">User details</h4>
        </div>
        <div class="modal-body">
            <?php $attributes = array('id' => 'new-user'); ?>
            <?php echo form_open(site_url("admin/edit_user/" . $user['id']), $attributes); ?>
            <?php echo form_hidden('user_id', $user['id']); ?>

            <!-- Text input-->
            <div class="form-group">
                <label class="control-label" for="first_name">First name</label>
                <input id="first_name" name="first_name" value="<?php print_r($user['first_name']); ?>" class="form-control" type="text" required="">
                <p class="help-block">enter first name, e.g. "Katniss"</p>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="control-label" for="last_name">Last name</label>
                <input id="last_name" name="last_name" value="<?php print_r($user['last_name']); ?>" class="form-control" type="text" required="">
                <p class="help-block">enter last name, e.g. "Everdeen"</p>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input id="password" name="password" value="" class="form-control" type="password">
                <p class="help-block">type here only if you want to change your current password</p>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="control-label" for="password_confirm">Confirm password </label>
                <input id="password_confirm" name="password_confirm" value="" class="form-control" type="password">
                <p class="help-block">type here only if you want to change your current password</p>
            </div>


            <?php foreach ($groups as $group): ?>
                <label class="checkbox-inline">
                    <?php
                    $gID = $group['id'];
                    $checked = null;
                    $item = null;
                    foreach ($user['current_groups'] as $grp) {
                        if ($gID == $grp->id) {
                            $checked = ' checked="checked"';
                            break;
                        }
                    }
                    ?>
                    <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                    <?php echo $group['name']; ?>
                </label>
            <?php endforeach ?>
            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>
            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo assets_url(); ?>/js/jquery.validate.min.js"></script>
<script>
    var validator = $("#new-user").validate();

    $('#submit').click(function() {
        if (validator.form()) {
            $('.modal-body > form').submit();
        } else {
            return false;
        }

    });
</script>

