<?php 
$span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); 
if ($this->session->flashdata('message') != '')
{
	$flashdata = $this->session->flashdata('message'); 
}

?>
<div class="<?php echo $span_value ?>">
	
	<h2>
		Shot <?php echo $shot['shot_name'] ?> 
			<? if ($subscriptions['comments']): ?>
			<button id="comments_unsubscribe" class="btn btn-default pull-right">Unsubscribe from comments</button>
			<? else: ?>
			<button id="comments_subscribe" class="btn btn-default pull-right">Subscribe to comments</button>
			<? endif ?>
		
	</h2>
	
	
	<?php if (isset($flashdata)):?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo $flashdata ?>
	</div>
	<?php endif ?>
	
	<div class="row">
		<div class="col-md-6">
			<?php if($previews): ?>
				<div class="row">
				<?php foreach ($previews as $preview): ?>
					<?php if($preview['is_current'] == TRUE): ?>
						<div class="col-md-10">
							<img class="img-responsive" src="/uploads/thumbnails/400_<?php echo $preview['attachment_path'] ?>" />
							<?php echo anchor('/shots/delete_preview/' . $preview['attachment_id'], 'Delete') ?>
						</div>
					<?php else: ?>
						<div class="col-md-2">
							<img class="img-responsive" src="/uploads/thumbnails/80_<?php echo $preview['attachment_path'] ?>" />
							<?php echo anchor('/shots/delete_preview/' . $preview['attachment_id'], 'Delete') ?>
						</div>
					<?php endif ?>
				<?php endforeach ?>
				</div>
			<?php else: ?>
				<img src="http://placehold.it/320x180">
				 
		
			<?php endif ?>
			
			<?php echo form_open_multipart(site_url("shots/post_add_preview")); ?>
			<form class="form">    
				<?php echo form_hidden('shot_id', $shot['shot_id']);?>                   
			    <div class="fileinput fileinput-new" data-provides="fileinput">
				  	<span class="btn btn-default btn-file">
				  		<span class="fileinput-new">Select shot preview</span>
				  		<span class="fileinput-exists">Change selection</span>
				  		<input type="file" name="userfile" size="20" />
				  	</span>
				  	<span class="fileinput-filename"></span>
				  	<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
				</div>
			
				<button class="btn btn-default">Add Preview</button>
			</form>
			<?php echo form_close();?>
		</div>	
		<div class="col-md-6">
			<p><?php echo $shot['shot_description']; ?></p>
		</div>
	</div>
	
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
                    <li><a href="<?php echo site_url("/shots/edit/{$shot['shot_id']}") ?>">Edit</a></li>
			<li class="active"><a href="#">Comments</a></li>
		</ul>
	</div>
	
	<div class="media">
	    <span class="pull-left">
	    	<img class="media-object" src="<?php echo $gravatar ?>">
	    </span>
	    <?php echo $error;?>
	    <div class="media-body">
	    	<?php echo form_open_multipart("shots/post_add_comment"); ?>
	    	
	    	<form class="form">    
	    		<?php echo form_hidden('shot_id', $shot['shot_id']);?>                
			     
			  		<textarea required="" name="comment_body" id="comment_body" data-provide="markdown" class="md-input" rows="5" style="resize: none;"></textarea>
			  		<div class="md-footer">
					    <div class="fileinput fileinput-new" data-provides="fileinput">
						  	<span class="btn btn-default btn-file">
						  		<span class="fileinput-new">Select file</span>
						  		<span class="fileinput-exists">Change</span>
						  		<input type="file" name="userfile" >
						  	</span>
						  	<span class="fileinput-filename"></span>
						  	<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
						</div>
						<button class="btn btn-default pull-right">Add Comment</button>
					</div>
					
			</form>
	    	<?php echo form_close();?>
	    	
	    </div>
    </div>

	<?php foreach ($comments as $comment): ?>
    <div class="media shot-comment">
	    <a class="pull-left" href="#">
	    	<img class="media-object" src="<?php print_r ($comment['gravatar']); ?>">
	    </a>
	    <div class="media-body">
	    	<div>
	    		<h5 class="media-heading pull-left"><?php echo $comment['first_name'] ?></h5>
	    		<h5 class="media-heading pull-right details">
	    			<?php echo $comment['comment_creation_date'] ?>
	    			<a href="/comments/delete/<?php echo $comment['comment_id'] ?>"><i class="glyphicon glyphicon-trash"></i></a>
	    		</h5>
	    	</div>
	    	<div class="clearfix"></div>
	    	
	    	<div class="thread_comment_body"><?php echo $comment['comment_body'] ?></div>
	    	<?php if($comment['attachment_path']): ?>
	    		<a href="/uploads/originals/<?php echo $comment['attachment_path'] ?>">
	    			<img src="/uploads/thumbnails/200_<?php echo $comment['attachment_path'] ?>" />
	    		</a>
	    	<?php endif ?>
	    	
	    	
	    </div>
    </div>
	<?php endforeach ?>
	
	
</div>

<script>
	//$('.thread_comment_body').html(markdown.toHTML($(this).html()));
	$( '.thread_comment_body' ).each(function() {
		//$(this).html('a');
		var test = markdown.toHTML($(this).html());
		$(this).html(test);
	});
	//console.log($('.thread_comment_body').html());
	
	$(document).on("click", "#comments_subscribe", function() {
		$.post( "/shots/post_subscribe_to_comments/", { shot_id: <?php echo $shot['shot_id'] ?> , subscription_type: 'comments' })
		.done(function( data ) {
			console.log('Subscribed to comments');
			$('#comments_subscribe').text('Unsubscribe from comments');
			$('#comments_subscribe').attr('id', 'comments_unsubscribe');
		});
	});
	
	$(document).on("click", "#comments_unsubscribe", function() {
		$.post( "/shots/post_unsubscribe_from_comments/", { shot_id: <?php echo $shot['shot_id'] ?> , subscription_type: 'comments' })
		.done(function( data ) {
			console.log('Unsubscribed from comments');
			$('#comments_unsubscribe').text('Subscribe to comments');
			$('#comments_unsubscribe').attr('id', 'comments_subscribe');
		});
	});

</script>

