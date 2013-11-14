<link rel="stylesheet" type="text/css" href="<?= ct::baseURL() ?>/css/bag.css">
<div class ="content-inner clearfix">
    <div class="bag-wrapper">
        <ul class="bag-items">
            <?php
            $total = 0;
            if (empty($data)) {
                echo 'No item here';
            } else {
                $productIDs = array_keys($data);
                
                foreach ($productIDs as $productID) {
                    //start showing an item (grouped by product)
                    $product = new Product($productID);
                    $picture = new Pictures();
                    $urls = $picture->getProductPictures($productID);
                    $price = (float) $product->getVal('price');
                    $sale = (float) $product->getVal('sale');
                    $finalPrice = $price - ($price * $sale / 100);
                    ?>
                    <li class="shadow-box clearfix">
                        <a href="/bag/Remove/<?=$productID?>" class="remove"></a>  
                        <div class="item-preview pic-cover"
                             style="background-image: url('<?= $urls[0] ?>')">
                            <a href="/product/View/<?= $productID ?>">

                            </a>
                        </div> 
                        <div class="item-wrapper">
                            <div class="item-detail clearfix">   
                                <div class="product-header">
                                    <h1 class="product-name"><a href=""><?= $product->getVal('product_name') ?></a></h1>
                                    <span class="product-price">
                                        <span class="price-label">Unit Price:</span>$
                                        <?= $finalPrice ?>
                                        <?php if ($sale > 0) { ?>
                                            <span class="old-price">$
                                                <?= $price ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </div>
                                <ul class="attributes">
                                    <li>
                                        <ul class="tbl-4cols col-header clearfix">
                                            <li>Size</li>
                                            <li>Color</li>
                                            <li>Quantity</li>
                                            <li>Edit</li>
                                        </ul>
                                    </li>
                                    <?php
                                    $atts = $data[$productID];
                                    $attIDs = array_keys($atts);
                                    $subtotal = 0;
                                    foreach ($attIDs as $attID) {
                                        $att = $atts[$attID];
                                        ?>
                                        <li>
                                            <ul class="tbl-4cols clearfix">
                                                <li><?= $att['size'] ?></li>
                                                <li><?= $att['color'] ?></li>
                                                <li><?= $att['quantity'] ?> item(s)</li>
                                                <li>
                                                    <a href="/bag/AddUp/<?=$attID?>">+</a>
                                                    <a href="/bag/SubDown/<?=$attID?>">-</a>
                                                    <a href="/bag/RemoveAtt/<?=$attID?>">Remove</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php
                                        $subtotal += (int) $att['quantity'] * $finalPrice;
                                    }
                                    ?>
                                </ul> 
                                <hr>       		
                                <div class="sub-total clearfix">
                                    <span class="label">Total</span>
                                    <span class="sub">$<?= $subtotal ?></span>
                                </div>	
                            </div>
                    </li>
                    <?php $total += $subtotal;
                }
            }
            ?>

        </ul>

        <div class="bag-bottom-line">
            <div class="bag-total">
                <span class="bag-total-label">Bag Total</span>
                <span>$<?=$total?></span>
            </div>
            <a href="/bag/Checkout" class="check-out-bt">Check Out</a>
        </div>
    </div>
</div>