<?php
$NumberProductOf1Page = 10;
$totalPages = ceil($data[0]['totalRecord'] / $NumberProductOf1Page);
//print_r($data);
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        
        <form method='post' id='userform' action='<?= $data['currentPage'] ?>'>
            <table class="ct-list-tbl">
                <tr>
                    <td>ID</td>
                    <td>Date</td>  		 		
                    <td>Ship Address</td>  		
                    <td>Customer Name</td>  		
                    <td>Customer Phone</td>
                    <td>Customer Email</td>
                    <td>Tax (%)</td>
                    <td>Shipping Fee</td>
                    <td>Total</td>
                    <td>is Gift</td>
                </tr>

                <?php
                foreach ($data as $item) {
                    ?>
                    <tr>
                        <td><a href="/Bill/View/<?= $item['id'] ?>"><?php print_r($item['id']) ?></a></td>
                        <td><?php print_r($item['issue_date']) ?></td>
                        <td><?php print_r($item['ship_address']) ?></td>
                        <td><?php print_r($item['customer_first_name'] . " " . $item['customer_last_name']) ?></td>
                        <td><?php print_r($item['customer_phone']) ?></td>
                        <td><?php print_r($item['customer_email']) ?></td>
                        <td><?php print_r($item['tax']) ?></td>
                        <td><?php print_r($item['shipping_fee']) ?></td>
                        <td><?php print_r($item['total']) ?></td>
                        <td><?php print_r($item['isGift']) ?></td>
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