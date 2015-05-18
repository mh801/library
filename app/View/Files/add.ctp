<?php 
    echo $this->Form->create('file', array('action' => 'post', 'type' => 'file'));
    echo $this->Form->file('file');
    echo $this->Form->submit('Upload');
    echo $this->Form->end();
?>