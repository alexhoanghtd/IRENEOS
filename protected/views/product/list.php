<?php
$NumberProductOf1Page = 10;
$totalPages = ceil($data[0]['totalRecord'] / $NumberProductOf1Page);
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        
        <form method='post' id='userform' action='<?= $data[0]['currentPage'] ?>'>
            <input type="submit" value="Delete selected & Quick Active"/></br></br>
            <table class="ct-list-tbl">
                <tr>
                    <td></td>
                    <td>Product</td>  		 		
                    <td>Picture</td>                                        	
                    <td>Sale</td> 
                    <td>Price</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>

                <?php
                $status = null;
                foreach ($data as $item) {
                    ?>

                    <tr>
                    <input type="hidden" name="product[<?= $item['id'] ?>]" value="<?= $item['id'] ?>">
                    <td><input type="checkbox" name="checkbox[]" value="<?= $item['id'] ?>"></td>
                    <td><a href="../View/<?= $item['id'] ?>"><?php print_r($item['product_name']) ?></a></td>
                    <td><img height="100" src="<?php print_r($item['coverURL']) ?>"/></td>                   
                    <td><?php print_r($item['sale']) ?>%</td>
                    <td><?php print_r($item['price']) ?>$</td>
                    <td><input type="checkbox" 
                        <?= ( $item['available'] == '1' ) ? "checked" : "" ?>
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