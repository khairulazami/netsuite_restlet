
<h1>Delete a Record</h1>
<?php echo $this->Form->create('Attendance'); ?>
<p>
<?php
echo $this->Form->input('employee_id', array(
    'type' => 'text',
    'label' => 'Employee ID'
));
?>
</p>

<p>
<?php
echo $this->Form->input('employee_name', array(
    'label' => 'Employee Name'
));
?>
</p>

<p>
<?php
echo $this->Form->input('check_in', array(
    'label' => 'Check IN'
));
?>

<?php
echo $this->Form->input('check_out', array(
    'label' => 'Check OUT'
));
?>
</p>
<p>
    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->submit('back', array('type' => 'button', 'style' => 'width: 70px;', 'onclick' => 'javascript:history.go(-1);')); ?>
</p>
<?php echo $this->Form->end(); ?>