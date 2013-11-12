<?php
//CT::widgets('CTList')->setModel($product = new Product());
//echo CT::widgets('CTList')->render();
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        
        <form method='post' id='userform' action='List'>
            <input type="submit" value="Delete selected & Quick Active"/></br></br>

            <table class="ct-list-tbl">
                <tr>
                    <td></td>
                    <td>Category</td>  		 		
                    <td>Number products of category</td>  		
                    <td>Is Active</td>  		
                    <td>Action</td> 
                </tr>

                <?php
                $status = null;
                foreach ($data as $item) {
                    ?>

                    <tr>
                        <input type="hidden" name="category[<?=$item['id']?>]" value="<?=$item['id']?>">
                        <td><input type="checkbox" name="cbDelete[]" value="<?= $item['id'] ?>"></td>
                        <td><?php print_r($item['name']) ?></td>
                        <td><?php print_r($item['num']) ?></td>
                    <td><input type="checkbox" 
                    <?= ( $item['available'] == '1' ) ? "checked" : "" ?>
                           name="cbActive[<?= $item['id'] ?>]" value="1"></td>
                    <td><a href="Update/<?= $item['id'] ?>"> Edit </a><a href="Delete/<?= $item['id'] ?>"> Delete </a></td>
                    </tr>

                <?php } ?>          

            </table>   
        </form>        
    </div>
</div>