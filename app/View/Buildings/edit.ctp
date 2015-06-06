<div class="buildings form">
<?php echo $this->Form->create('Building'); ?>
	<fieldset>
		<legend><?php echo __('Edit Building'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Property_Name');
		echo $this->Form->input('Address_1');
		echo $this->Form->input('Lat');
		echo $this->Form->input('Lang');
		echo $this->Form->input('Google_Address');
		echo $this->Form->input('Gross_Square_footage');
		echo $this->Form->input('Year_Built');
		echo $this->Form->input('Primary_Property_Type');
		echo $this->Form->input('Energy_Start_Score');
		echo $this->Form->input('Percent_Better_Than_National_Median');
		echo $this->Form->input('Weather_Normalized_Site');
		echo $this->Form->input('Energy_Start_Certification');
		echo $this->Form->input('Building_Website');
		echo $this->Form->input('Denver_2030_District_Member');
		echo $this->Form->input('Leed_Certification');
		echo $this->Form->input('Green_Key_Certification');
		echo $this->Form->input('Strategies');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Building.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Building.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Buildings'), array('action' => 'index')); ?></li>
	</ul>
</div>
