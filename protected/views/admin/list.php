<?php
//CT::widgets('CTList')->setModel($product = new Product());
//echo CT::widgets('CTList')->render();
?>

<div class="content-inner">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/ct-list.css">
    <div class="single-col">        

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
                    <td><a href="Bill/View/<?=$item['id']?>"><?php print_r($item['id']) ?></a></td>
                    <td><?php print_r($item['issue_date']) ?></td>
                    <td><?php print_r($item['ship_address']) ?></td>
                    <td><?php print_r($item['customer_first_name']." ".$item['customer_last_name']) ?></td>
                    <td><?php print_r($item['customer_phone']) ?></td>
                    <td><?php print_r($item['customer_email']) ?></td>
                    <td><?php print_r($item['tax']) ?></td>
                    <td><?php print_r($item['shipping_fee']) ?></td>
                    <td><?php print_r($item['total']) ?></td>
                    <td><?php print_r($item['isGift']) ?></td>
                </tr>
            <?php } ?>          

        </table>                   
    </div>
</div>