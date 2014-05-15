		<div class="col-md-3">
			<div class="list-group list-shots">
				<?php foreach ($shots as $item): ?>	
                            <a href="<?php echo base_url("/shots/view/{$item['shot_id']}") ;?>" class="list-group-item <?php echo ($item['shot_id'] == $shot['shot_id'] ? "active" : ""); ?>">	
		      		<?php if(isset($item['attachment_path'])): ?>	      		
						<img src="/uploads/thumbnails/80_<?php echo $item['attachment_path'] ?>" />
					<?php else: ?>
						<img src="http://placehold.it/80x45" />
					<?php endif ?>
		      		<?php echo $item['shot_name'] ?>
		      	</a>
				<?php endforeach ?>
			</div>

        </div><!--/span-->