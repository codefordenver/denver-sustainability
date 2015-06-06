<div class="buildings index">
	<h2><?php echo __('Buildings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('Property_Name'); ?></th>
			<th><?php echo $this->Paginator->sort('Address_1'); ?></th>
			<th><?php echo $this->Paginator->sort('Lat'); ?></th>
			<th><?php echo $this->Paginator->sort('Lang'); ?></th>
			<th><?php echo $this->Paginator->sort('Google_Address'); ?></th>
			<th><?php echo $this->Paginator->sort('Gross_Square_footage'); ?></th>
			<th><?php echo $this->Paginator->sort('Year_Built'); ?></th>
			<th><?php echo $this->Paginator->sort('Primary_Property_Type'); ?></th>
			<th><?php echo $this->Paginator->sort('Energy_Start_Score'); ?></th>
			<th><?php echo $this->Paginator->sort('Percent_Better_Than_National_Median'); ?></th>
			<th><?php echo $this->Paginator->sort('Weather_Normalized_Site'); ?></th>
			<th><?php echo $this->Paginator->sort('Energy_Start_Certification'); ?></th>
			<th><?php echo $this->Paginator->sort('Building_Website'); ?></th>
			<th><?php echo $this->Paginator->sort('Denver_2030_District_Member'); ?></th>
			<th><?php echo $this->Paginator->sort('Leed_Certification'); ?></th>
			<th><?php echo $this->Paginator->sort('Green_Key_Certification'); ?></th>
			<th><?php echo $this->Paginator->sort('Strategies'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($buildings as $building): ?>
	<tr>
		<td><?php echo h($building['Building']['id']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Property_Name']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Address_1']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Lat']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Lang']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Google_Address']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Gross_Square_footage']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Year_Built']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Primary_Property_Type']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Energy_Start_Score']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Percent_Better_Than_National_Median']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Weather_Normalized_Site']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Energy_Start_Certification']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Building_Website']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Denver_2030_District_Member']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Leed_Certification']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Green_Key_Certification']); ?>&nbsp;</td>
		<td><?php echo h($building['Building']['Strategies']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $building['Building']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $building['Building']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $building['Building']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $building['Building']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Building'), array('action' => 'add')); ?></li>
	</ul>
</div>
