<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
    <div class="error-msg"></div>
</div>
<script>
    $(document).ready(function(){
        $('input[type=submit]').click(function(e){
            if($('#UserUsername').val() =='' || $('#UserPassword').val() == ''){
                e.preventDefault();
                if($('#UserUsername').val() ==''){
                    $('.error-msg').html('Please enter a username <br/>');
                }
                 if($('#UserPassword').val() ==''){
                     $('.error-msg').html($('.error-msg').html()+'Please enter a password<br/>');
                }
            }
        });
    });
</script>