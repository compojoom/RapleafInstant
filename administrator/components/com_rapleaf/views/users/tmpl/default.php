<?php

var_dump($users->getData());

?>
<form action="<?= @route() ?>" method="get" class="-koowa-grid">
<table class="adminlist">
	<thead>

		<tr>
			<th width="8%"></th>
			<th >
				<?= @helper('grid.sort', array('column' => 'name')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'username')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'email')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'age')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'gender')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'location')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'household_income')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'children')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'marital_status')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'education')); ?>
			</th>
			<th >
				<?= @helper('grid.sort', array('column' => 'occupation')); ?>
			</th>
		</tr>
	</thead>

	
		
	<tbody>
	<? foreach ($users as $user) : ?>
		<tr>
			<td align="center">
				<?= @helper('grid.checkbox' , array('row' => $user)); ?>
			</td>
			<td align="left">    					
				<?=$user->name?>
			</td>
			<td align="username">    					
				<?=$user->username?>
			</td>
			<td align="username">    					
				<?=$user->email?>
			</td>
			<td align="username">    					
				<?=$user->age?>
			</td>
			<td align="left">    					
				<?=$user->gender?>
			</td>
			<td align="left">    					
				<?=$user->location?>
			</td>
			<td align="left">    					
				<?=$user->household_income?>
			</td>
			<td align="left">    					
				<?=$user->children?>
			</td>
			<td align="left">    					
				<?=$user->marital_status?>
			</td>
			<td align="left">    					
				<?=$user->education?>
			</td>
			<td align="left">    					
				<?=$user->occupation?>
			</td>
		</tr>
	<? endforeach; ?>

	<? if (!count($users)) : ?>
		<tr>
			<td colspan="20" align="center">
				<?= @text('No Items Found'); ?>
			</td>
		</tr>
	<? endif; ?>	
	</tbody>	
	
	<tfoot>
           <tr>
                <td colspan="13">
					 <?= @helper('paginator.pagination', array('total' => $total)) ?>
                </td>
			</tr>
	</tfoot>
</table>
</form>