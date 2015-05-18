<table>
    <tr>
        <th>ID</th>
        <th>Audience Name</th>
        <th>Description</th>
    </tr>     
   <?php foreach($audience as $aud){ ?>
     <?php foreach($aud as $a){ ?>
    <tr>
        <td><?php echo $a['id'] ?></td>
        <td><a href="/audiences/view/<?php echo $a['id'] ?>"><?php echo $a['name'] ?></a></td>
        <td><?php echo $a['description'] ?></td>
    </tr>
    <?php } } ?>
</table>
