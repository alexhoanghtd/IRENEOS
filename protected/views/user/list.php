<?php
$NumberUserOf1Page = 10;
$totalPages = ceil($data[0]['totalRecord'] / $NumberUserOf1Page);
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        
        <form method='post' id='userform' action='List'>
            <input type="submit" value="Quick Active"/></br></br>

            <table class="ct-list-tbl">
                <tr>
                    <th></th>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Password</th> 
                    <th>Role</th> 
                    <th>First Name</th>  		
                    <th>Last Name</th>  		
                    <th>Email</th>
                    <th>Address</th>
                    <th>Active</th>
                    <th>Action</th> 
                </tr>

                <?php
                $status = null;
                foreach ($data as $item) {
                    ?>

                    <tr>
                        <input type="hidden" name="user[<?=$item['id']?>]" value="<?=$item['id']?>">
                        <!-- <td><input type="checkbox" name="cbDelete[]" value="<?= $item['id'] ?>"></td> -->
                        <td></td>
                        <td><img height="100" src="<?php print_r($item['avatarUrl']) ?>"/></td>
                        <td><?php print_r($item['username']) ?></td>
                        <td><?php print_r($item['password']) ?></td>
                        <td><?php print_r($item['role']) ?></td>
                        <td><?php print_r($item['first_name']) ?></td>
                        <td><?php print_r($item['last_name']) ?></td>
                        <td><?php print_r($item['email']) ?></td>
                        <td><?php print_r($item['address']) ?></td>
                        <td><input type="checkbox" 
                        <?= ( $item['active'] == '1' ) ? "checked" : "" ?>
                               name="cbActive[<?= $item['id'] ?>]" value="1"></td>
                        
                        <td><a href="Update/<?= $item['id'] ?>"> Edit </a><a href="Delete/<?= $item['id'] ?>"> Delete </a></td>
                    </tr>

                <?php } ?>          

            </table>   
            
            </br></br>

            <?php
            if ($totalPages > 1) {
                $currentPage = $data[0]['currentPage'];
                if ($currentPage != 1) {
                    ?>
                    <a href="<?= $currentPage - 1 ?>" name="back">Back</a>
                    <?php
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $currentPage) {
                        ?>
                        <b><?= $i ?></b>
                        <?php
                    } else {
                        ?>
                        <a href="<?= $i ?>" name="<?= $i ?>"><?php print_r($i) ?></a>
                        <?php
                    }
                }
                if ($currentPage != $totalPages) {
                    ?>
                    <a href="<?= $currentPage + 1 ?>" name="next">Next</a>
                    <?php
                }
            }
            ?>
                    
        </form>        
    </div>
</div>