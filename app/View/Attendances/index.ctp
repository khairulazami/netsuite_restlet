<h1>Attendances Actions</h1>
<p>
Choose your action
<ul>
    <li><?php echo $this->Html->link('View record', array('controller' => 'attendances', 'action' => 'get_record')); ?></li>
    <li><?php echo $this->Html->link('Add a record', array('controller' => 'attendances', 'action' => 'create_record')); ?></li>
    <li><?php echo $this->Html->link('Remove record', array('controller' => 'attendances', 'action' => 'delete_record')); ?></li>
    <li><?php echo $this->Html->link('Update record', array('controller' => 'attendances', 'action' => 'update_record')); ?></li>
</ul>
</p>

