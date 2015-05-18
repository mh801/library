<table>
    <tr>
        <th>ID</th>
        <th>Category Name</th>
        <th>Description</th>
        <th>Audience</th>
        <th>Types</th>
    </tr>
   <?php foreach($category as $cat){ ?>
    <tr>
        <td><?php echo $cat['id'] ?></td>
        <td><?php echo $cat['name'] ?></td>
        <td><?php echo $cat['description'] ?></td>
        <td>
            <?php 
                if(isset($audience)){
                    foreach($audience as $aud){ 
                        echo '<a href="/audiences/view/'. $aud['audiences']['id'].'">'. $aud['audiences']['name'] . '</a><br/>';
                    }
                }else{
                    echo 'N/A';
                }   ?>
        </td>
        <td>
            <?php 
                if(isset($types)){
                    foreach($types as $t){ 
                        echo '<a href="/audiences/view/'. $t['types']['id'].'">'. $t['types']['name'] . '</a><br/>';
                    }
                }else{
                    echo 'N/A';
                }   ?>
        </td>        
    </tr>
    <?php } ?>
</table>
