<h2>Add Link</h2>
<?php echo $this->Form->create('Link',array('url'=>array('action'=>'post')));?>
    <fieldset>
        <legend><?php __('Add Link');?></legend>
        <?php        
        echo $this->Form->input('url',array(
                                'label'=>'URLs (separated by comma)',
                                'class'=>'frm-input')); 
?>
<?php
        echo $this->Form->hidden('modified_at',
    						          array('value' => date('Y-m-d H:i:s'))
    							);
        ?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>