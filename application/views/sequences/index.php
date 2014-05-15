<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<?php 
if ($this->session->flashdata('message') != '')
	{
	    $flashdata = $this->session->flashdata('message'); 
	}
?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<?php if (isset($flashdata)):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flashdata ?>
</div>
<?php endif ?>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="users">
	<thead>
		<tr>
			<th>Sequence name</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($sequences as $sequence): ?>
    	<tr class="sequence_<?php echo $sequence['sequence_id'] ?>">
            <td><a href="#" sequence="<?php echo site_url("/sequences/edit/{$sequence['sequence_id']}") ?>" data-toggle="modal"><?php echo $sequence['sequence_name'] ?></a></td>
    		<td><?php echo $sequence['sequence_description'] ?></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Sequence name</th>
			<th>Description</th>
		</tr>
	</tfoot>
</table>

<a class="btn btn-default btn-lg btn-block" href="<?php echo site_url("/sequences/create") ?>">Add sequence</a>
</div><!--/span-->

<script>
$(document).ready(function() {
	// Support for AJAX loaded modal window.
	// Focuses on first input textbox after it loads the window.
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('sequence');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} else {
			$.get(url, function(data) {
				$('<div class="modal fade">' + data + '</div>').modal();
			}).success(function() { $('input:text:visible:first').focus(); });
		}
	});
});
</script>

