<h1><?php echo lang('index_groups_th');?></h1>

<table>
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Actions</th>
	</tr>
	<?php foreach($groups as $group){ ?>
	<tr>
		<td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
		<td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
		<td><?php echo anchor("auth/edit_group/".$group->id, 'Edit') ;?></td>
	</tr>
	<?php } ?>
</table>