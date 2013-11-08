<?php
//CT::widgets('CTList')->setModel($product = new Product());
//echo CT::widgets('CTList')->render();
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        
        <form method='post' id='userform' action='List'>
            <input type="submit" value="Delete selected"/></br></br>
            <table class="ct-list-tbl">
                <tr>
                    <td></td>
                    <td>Product</td>  		 		
                    <td>Number products of category</td>  		
                    <td>Status</td>  		
                    <td>Action</td> 
                </tr>

                <?php
                $status = null;
                foreach ($data as $items) {
                    if ($items['available'] == 1) {
                        $status = 'is active';
                    } else {
                        $status = 'not active';
                    }   
                    ?>

                    <tr>
                        <td><input type="checkbox" name="checkbox[]" value="<?= $items['id'] ?>"></td>
                        <td><?php print_r($items['name']) ?></td>
                        <td><?php print_r($items['num']) ?></td>
                        <td><?php print_r($status) ?></td>
                        <td><a href="Update/<?= $items['id'] ?>"> Edit </a><a href="Delete/<?= $items['id'] ?>"> Delete </a></td>
                    </tr>

                <?php } ?>          

            </table>   
        </form>        
    </div>
</div>