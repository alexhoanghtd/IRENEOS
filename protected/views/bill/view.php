<?php $billData = $data['billdata'];
      $billDetails = $data['billDetails'];?>
<div class="content-inner single-col bill">
<link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/bill.css">
    <div class="bill-header clearfix"> 
        <div class="bill-description">
            <h2>Bill Description </h2>
            <ul>
                <li>
                    <h3>Issue Date</h3>
                    <span><?=$billData['issue_date']?></span>
                </li>
                <li>
                    <h3>Status</h3>
                    <span>Delivered</span>
                </li>
            </ul>
        </div>
        <div class="bill-to">
            <div class="billing-address">
                <h2>Bill to</h2>
                <ul>
                    <li>
                        <h3>Name</h3>
                        <span><?= $billData['customer_first_name']." ".$billData['customer_last_name']?></span>
                    </li>
                    <li>
                        <h3>Phone Number</h3>
                        <span><?=$billData['customer_phone']?></span>
                    </li>
                    <li>
                        <h3>Email</h3>
                        <span><?=$billData['customer_email']?></span>
                    </li>
                    <li>
                        <h3>Adress:</h3>
                        <span><?=$billData['ship_address']?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="bill-to">
            <div class="billing-address">
                <h2>Ship to</h2>
                <ul>
                    <li>
                        <h3>Name</h3>
                        <span><?= $billData['customer_first_name']." ".$billData['customer_last_name']?></span>
                    </li>
                    <li>
                        <h3>Phone Number</h3>
                        <span><?=$billData['customer_phone']?></span>
                    </li>
                    <li>
                        <h3>Email</h3>
                        <span><?=$billData['customer_email']?></span>
                    </li>
                    <li>
                        <h3>Adress:</h3>
                        <span><?=$billData['ship_address']?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="bill-items">
    <h1>Products Informations</h1>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Size</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>Price ($)</th>
        </tr>
        <?php 
            $subtotal = 0;
            $count = 1;
            foreach($billDetails as $billDetail){ 
            $color = Color::getColor($billDetail->getVal('color_id'));
            $size = Size::getSize($billDetail->getVal('size_id'));
            $product = new Product($billDetail->getVal('product_id'));
            $price = $product->getVal('price') - $product->getVal('price')* $product->getVal('sale')/100 ;
            ?>
        <tr>
            <td><?=$count?></td>
            <td><?=$product->getVal('product_name')?></td>
            <td><?=$size?></td>
            <td><?=$color?></td>
            <td><?=$billDetail->getVal('quantity')?></td>
            <td><?=$price?></td>
        </tr>
            
            
       <?php 
       $subtotal += $price * $billDetail->getVal('quantity');
       $count++;
            } ?>
    </table>
    </div>
    <hr>
    <div class="bill-bottom-line">
        <h1>Summary</h1>
        <ul>
            <li>
                <h3>Sub Total: </h3><span><?=$subtotal?></span>
            </li>
            <li>
                <h3>Tax: </h3><span><?=$billData['tax']?>%</span>
            </li>    
            <li>
                <h3>Shipping fee: </h3><span>$ <?=$billData['shipping_fee']?></span>
            </li>
            <hr>
            <li class="bill-total"> 
                <h3>Total: </h3><span>$<?=$billData['total']?></span>
            </li>
        </ul>
    </div>
</div>