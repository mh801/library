<h2>Add Keywords</h2> (separated by a comma)<br/>
<?php echo $this->Form->create('Keyword',array('url'=>array('action'=>'post')));?>
    <fieldset>
        <legend><?php __('Add Keywords');?></legend>
        <?php        
        echo $this->Form->text('keyword',array(
                                'label'=>'Name',
                                'class'=>'frm-input'));
?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>