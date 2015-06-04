<h2>Add Audience</h2>
<?php echo $this->Form->create('Category',array('url'=>array('action'=>'post')));?>
    <fieldset>
        <legend><?php __('Add Audience');?></legend>
        <?php        
        echo $this->Form->input('name',array(
                                'label'=>'Name',
                                'class'=>'frm-input'));
        echo $this->Form->input('description',array(
                                'label'=>'Description',
                                'class'=>'frm-input'));  
?>
        <labelfor="Audience">Brand</labelfor><br/>
        <select name="Audience">
            <?php
            foreach($audiences as $audience){             
                ?>
                <option value="<?php echo $audience['Audience']['id'] ?>"><?php echo $audience['Audience']['name'] ?></option>
            <?php
            }
            ?>
</select>
<?php
        echo $this->Form->hidden('modified_at',
    						          array('value' => date('Y-m-d H:i:s'))
    							);
        ?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>