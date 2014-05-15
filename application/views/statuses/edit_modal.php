<div class="modal-dialog">

    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Task details</h4>
        </div>
        <div class="modal-body">
            <?php $attributes = array('id' => 'the-status'); ?>
            <?php echo form_open(site_url("statuses/edit/" . $status['status_id']), $attributes); ?>
            <?php echo form_hidden('status_id', $status['status_id']); ?>

            <!-- Text input-->
            <div class="form-group">
                <label class="control-label" for="status_name">Status name</label>
                <input id="status_name" name="status_name" value="<?php echo $status['status_name'] ?>" class="form-control" type="text" required="">
                <p class="help-block">Enter the status name, e.g. "In Progress"</p>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="control-label" for="status_color">Status name</label>
                <input id="status_color" name="status_color" value="<?php echo $status['status_color'] ?>" class="form-control" type="text">
                <p class="help-block">Select a color</p>
            </div>

            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <a href="<?php echo site_url("/status/delete/{$status['status_id']}"); ?>" id="delete" class="btn btn-danger pull-left"><i class="glyphicon glyphicon-fire icon-white"></i> Delete</a>
            <button type="submit" id="submit" class="btn btn-primary" >Save Changes</button>
            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo assets_url(); ?>/js/jquery.validate.min.js"></script>
<script src="<?php echo assets_url(); ?>/js/bootstrap-colorpicker.min.js"></script>
<script>
    /*
     $('#status_color').colpick({
     colorScheme:'dark',
     layout:'rgbhex',
     color:'ff8800',
     onSubmit:function(hsb,hex,rgb,el) {
     $(el).css('background-color', '#'+hex);
     $(el).colpickHide();
     }
     })
     .css('background-color', '#ff8800');
     */

    $('#status_color').colorpicker();

    var validator = $("#the-status").validate();

    $('#submit').click(function() {
        if (validator.form()) {
            $('.modal-body > form').submit();
        } else {
            return false;
        }

    });
</script>

