<h2>Category Types</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Type Name</th>
        <th>Description</th>
        <th>Category</th>
    </tr>
   <?php foreach($type as $t){ ?>
    <tr>
        <td><?php echo $t['id'] ?></td>
        <td><?php echo $t['name'] ?></td>
        <td><?php echo $t['description'] ?></td>
        <td>
            <?php foreach($category as $cat){ 
                echo '<a href="/categories/view/'.$cat['categories']['id'].'">'. $cat['categories']['name'] . '</a><br/>';
            } ?>
        </td>
    </tr>
    <?php } ?>
</table>
