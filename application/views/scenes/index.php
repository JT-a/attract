<?php $span_value = ($use_sidebar == TRUE ? "col-md-9" : "col-md-12"); ?>

<div class="<?php echo $span_value ?>">

<h2><?php echo $title ?></h2>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="scenes">
	<thead>
		<tr>
			<th>Scene name</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($scenes as $scene): ?>
    	<tr>
                <td><a href="<?php echo base_url("/scenes/edit/{$scene['scene_id']}") ?>"><?php echo $scene['scene_name'] ?></a></td>
    		<td><?php echo $scene['scene_description'] ?></td>
    	</tr>
	<?php endforeach ?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>Scene Name</th>
			<th>Description</th>
		</tr>
	</tfoot>
</table>

<a class="btn btn-default btn-lg btn-block" href="<?php echo base_url("/scenes/create/") ?>">Add scene</a>


</div><!--/span-->



