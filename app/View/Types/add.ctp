<h2>Add Piece Type</h2>
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
        
        <labelfor="Brand">Brand</labelfor><br/>
        <select name="Audience" id="audience">
            <?php
            foreach($audiences as $aud){             
                ?>
                <option value="<?php echo $aud['Audience']['id'] ?>"><?php echo $aud['Audience']['name'] ?></option>
            <?php
            }
            ?>
</select>        
        <br/><br/>
        <labelfor="Category">Audience</labelfor><br/>
        <select name="Category" id="category">
            <?php
            foreach($categories as $category){             
                ?>
                <option value="<?php echo $category['Category']['id'] ?>"><?php echo $category['Category']['name'] ?></option>
            <?php
            }
            ?>
</select>
        <br/>
<?php
        echo $this->Form->hidden('modified_at',
    						          array('value' => date('Y-m-d H:i:s'))
    							);
        ?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>

<script>
        $('#audience').on('change',function(){
        $.post( "/categories/filterbyaudience/?id="+$('#audience').val(),function(data){
            if(data){
             $('#category').html(data);
            }
        });
    });
</script>