<h2>Add Category Type</h2>
<?php echo $this->Form->create('Type',array('url'=>array('action'=>'post')));?>
    <fieldset>
        <legend><?php __('Add Category Type');?></legend>
        <?php        
        echo $this->Form->input('name',array(
                                'label'=>'Name',
                                'class'=>'frm-input'));
        echo $this->Form->input('description',array(
                                'label'=>'Description',
                                'class'=>'frm-input'));  
?>
        <labelfor="Audience">Category</labelfor><br/>
        <select name="Category">
            <?php
            foreach($categories as $category){             
                ?>
                <option value="<?php echo $category['Category']['id'] ?>"><?php echo $category['Category']['name'] ?></option>
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