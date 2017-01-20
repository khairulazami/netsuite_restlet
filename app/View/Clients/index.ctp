
<h1>Client Actions</h1>
<p>
Choose your action
<ul>
<li><?php echo $this->Html->link('Request List', array('controller' => 'clients', 'action' => 'request_index')); ?></li>
<li><?php echo $this->Html->link('Request Add a record', array('controller' => 'clients', 'action' => 'request_add')); ?></li>
<li><?php echo $this->Html->link('View record with ID 1', array('controller' => 'clients', 'action' => 'request_view', 1)); ?></li>
<li><?php echo $this->Html->link('Update record with ID 2', array('controller' => 'clients', 'action' => 'request_edit', 2)); ?></li>
<li><?php echo $this->Html->link('Delete record with ID 3', array('controller' => 'clients', 'action' => 'request_delete'), 3); ?></li>
</ul>

</p>

