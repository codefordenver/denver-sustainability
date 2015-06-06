<div class="buildings view">
<h2><?php echo __('Building'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($building['Building']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Property  Name'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Property_Name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address 1'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Address_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lang'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Lang']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Google  Address'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Google_Address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gross  Square Footage'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Gross_Square_footage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Year  Built'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Year_Built']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Primary  Property  Type'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Primary_Property_Type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Energy  Start  Score'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Energy_Start_Score']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Percent  Better  Than  National  Median'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Percent_Better_Than_National_Median']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weather  Normalized  Site'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Weather_Normalized_Site']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Energy  Start  Certification'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Energy_Start_Certification']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Building  Website'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Building_Website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Denver 2030  District  Member'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Denver_2030_District_Member']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Leed  Certification'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Leed_Certification']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Green  Key  Certification'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Green_Key_Certification']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Strategies'); ?></dt>
		<dd>
			<?php echo h($building['Building']['Strategies']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Building'), array('action' => 'edit', $building['Building']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Building'), array('action' => 'delete', $building['Building']['id']), array(), __('Are you sure you want to delete # %s?', $building['Building']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Buildings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Building'), array('action' => 'add')); ?> </li>
	</ul>
</div>
