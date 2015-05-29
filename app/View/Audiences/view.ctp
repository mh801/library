<table>
    <tr>
        <th>ID</th>
        <th>Brand Name</th>
        <th>Description</th>
        <th>Brand Audiences</th>
    </tr>
   <?php foreach($audience as $a){ ?>
    <tr>
        <td><?php echo $a['id'] ?></td>
        <td><?php echo $a['name'] ?></td>
        <td><?php echo $a['description'] ?></td>
        <td>
            <?php 
                    if(isset($category)){
                        foreach($category as $cat){ 
                            echo '<a href="/categories/view/'. $cat['categories']['id'] .'">'. $cat['categories']['name'] . '</a><br/>';
                        }
                        }else{
                            echo 'N/A';
                        }
                     ?>
        </td>
    </tr>
    <?php } ?>
</table>
