<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', '');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
    
	<?php
		echo $this->Html->meta('icon');

		
        echo $this->Html->css('//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css');
        echo $this->Html->css('cake.generic');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
        echo $this->Html->script('jquery-1.11.2.min');
        echo $this->Html->script('jqcloud');
        //datatables has been modified to prevent auto resize of columns
       // echo $this->Html->script('/js/jquery.dataTables.min.js');
 echo $this->Html->script('/js/dataTables.js');
	?>
    <script type="text/javascript" src="//use.typekit.net/wcd8lgx.js"></script>
    
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/css/jqcloud.css">
</head>
<body>
	<div id="container">
		<div id="header">
              <?php if($this->Session->check('Auth.User')){
                    echo $this->Html->link('Logout', '/logout');
                } ?>
			<h1 class="logo"><?php echo $this->Html->link($cakeDescription, '/'); ?></h1>
            <div class="th-icon">
                <img src="https://8a14a4cdc153845f32b5-8250b0a3feea020289d5768bda2f75a1.ssl.cf1.rackcdn.com/contentlibrary/th-icon.png"/><br/>
              
            </div>
            <!--
            <menu>
                <?php echo $this->Html->link('Show Content Pieces', '/'); ?> |<?php echo $this->Html->link('Add Content Piece', '/content_pieces/add'); ?> | <?php echo $this->Html->link('Add Audience', '/audiences/add'); ?> | <?php echo $this->Html->link('Add Category', '/categories/add'); ?> | <?php echo $this->Html->link('Add Category Type', '/types/add'); ?>
            </menu>
            -->
           
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		  <div id="footer">
			
			<p>
				Copyright &copy;2015 TruHearing&reg;
			</p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
        
        
    <script>
        $(document).ready(function(){

                                              
        });    
    </script>    
</body>
</html>
