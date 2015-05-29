<div id="content-frm">
<h2>Add Content Piece</h2>
<?php echo $this->Form->create('ContentPiece',array('url'=>array('action'=>'post'),'id'=>'main-frm'));?>
    <fieldset>
        <legend><?php __('Add Content Piece');?></legend>
        <?php        
        echo $this->Form->input('name',array(
                                'label'=>'Name',
                                'class'=>'frm-input'));
        echo $this->Form->input('description',array(
                                'label'=>'Description',
                                'class'=>'frm-input')); 
        echo $this->Form->input('phone_number',array(
                                'label'=>'Phone Number',
                                'class'=>'frm-input')); 
        echo $this->Form->hidden('modified_at',
    						          array('value' => date('Y-m-d H:i:s'))
    							);
        echo $this->Form->hidden('is_active',
    						          array('value' => 1)
    							);
?>
        
<?php                
        echo $this->Form->input('Keyword',array(
                                'label'=>'Keywords (separated by comma)',
                                'class'=>'frm-input')); 
        
        echo $this->Form->input('Link',array(
                                'label'=>'Links (separated by comma)',
                                'class'=>'frm-input')); 
?>
        <labelfor="Audience">Brand</labelfor><br/>
            <select name="Audience" id="audience">
                <?php
                foreach($audiences as $audience){             
                    ?>
                    <option value="<?php echo $audience['Audience']['id'] ?>"><?php echo $audience['Audience']['name'] ?></option>
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
          <br/><br/>      
        <labelfor="Partner">Partner</labelfor><br/>
            <select name="Partner">
                <option value="">Choose a Partner</option>
                <?php
                foreach($partners as $partner){             
                    ?>
                    <option value="<?php echo $partner['Partner']['id'] ?>"><?php echo $partner['Partner']['description'] ?></option>
                <?php
                }
                ?>
        </select>        
        
        <br/><br/>
        <labelfor="Type">Type</labelfor><br/>
            <select name="Type" id="type">
                <?php
                foreach($types as $type){             
                    ?>
                    <option value="<?php echo $type['Type']['id'] ?>"><?php echo $type['Type']['name'] ?></option>
                <?php
                }
                ?>
        </select>        
        
        <?php
        echo $this->Form->submit('Add');
        echo $this->Form->end();
        ?>
    </fieldset>

</div>
<?php 
    echo $this->Form->create('file', array('action' => 'post', 'type' => 'file','id'=>'sub-form'));
?>

<div id="file-frm">

    <labelfor="File">File</labelfor><br/>
<?PHP
    echo $this->Form->file('file');
    echo $this->Form->hidden('modified_at',
    						      array('value' => date('Y-m-d H:i:s'))
    							);
    echo $this->Form->hidden('ContentPiece',
    						          array('value' => '',
                                           'class' => 'cid')
    							);
    echo $this->Form->submit('Upload File');
    echo $this->Form->end();
?>
</div>
<script>
$(document).ready(function(){
    $('#file-frm').hide();
    $('#main-frm').submit(function(e){
        e.preventDefault();
        $.post( "/content_pieces/ajaxpost",$('#main-frm').serialize(), function( data ) {
            $('.cid').val(data); 
             $('#content-frm').hide();
             $('#file-frm').show();
        });
    });

        $('#audience').on('change',function(){
        $.post( "/categories/filterbyaudience/?id="+$('#audience').val(),function(data){
            if(data){
             $('#category').html(data);
            }
        });
    });
        $('#category').on('change',function(){
        $.post( "/types/filterbycategory/?id="+$('#category').val(),function(data){
           
            if(data){
             $('#type').html(data);
            }
        });
    });   
    
});
</script>