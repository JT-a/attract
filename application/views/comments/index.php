<?php $span_value = ($use_sidebar == TRUE ? "span9" : "span12"); ?>

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

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="users">
	<thead>
		<tr>
			<th>Shot name</th>
			<th>Author</th>
			<th>Comment</th>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($comments as $comment): ?>
    	<tr class="comment_<?php echo $comment['comment_id'] ?>">
    		<td><a href="#" comment="/comments/edit/<?php echo $comment['comment_id'] ?>" data-toggle="modal"><?php echo $comment['shot_name'] ?></a></td>
    		<td><?php echo $comment['first_name'] ?></td>
    		<td><?php echo $comment['comment_body'] ?></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Shot name</th>
			<th>Author</th>
			<th>Comment</th>
		</tr>
	</tfoot>
</table>

<a class="btn btn-large btn-block" href="/comments/create">Add comment</a>
</div><!--/span-->

<script>
$(document).ready(function() {
	// Support for AJAX loaded modal window.
	// Focuses on first input textbox after it loads the window.
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('comment');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} else {
			$.get(url, function(data) {
				$('<div class="modal hide fade">' + data + '</div>').modal();
			}).success(function() { $('input:text:visible:first').focus(); });
		}
	});
});
</script>

