<?php
$product = $data['product'];
$attributes = $data['attributes'];
$sizes = $data['sizes'];
$colors = $data['colors'];
//print_r($sizes);
//print_r($attributes);
//print_r($product);
?>
<div class="content-inner l-2cols">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/product-attribute.css">
    <div class="col-left clearfix">
        <div class="pic-cover shadow-box patt-cover"  style="background-image: 
             url('<?= isset($product['picUrls'][0]) ? $product['picUrls'][0] : '' ?>')">

        </div>
    </div>
    <div class="col-right clearfix">
        <div class="product-basic col-right-container">
            <h1 class="col-right-header">
                <?= $product['product_name'] ?>
            </h1>
            <blockquote>
                <?= $product['product_description'] ?>
            </blockquote>
            <a href="/product/Update/<?= $product['id'] ?>" class="pupdate block-link">edit basic info of this product</a>
            <a href="/product/Delete/<?= $product['id'] ?>" class="pdelete block-link">delete this product </a>
            <hr/>
            <h2>Product Attributes</h2>
            <div class="pattr-header">
                <ul class="tbl-4cols clearfix">
                    <li>Size</li>
                    <li>Color</li>
                    <li>Quantity</li>   
                    <li>Actions</li>
                </ul>
            </div>
            <!--list all the attribute that already existed -->
            <?php if(!empty($attributes)){foreach ($attributes as $att) { ?>
                <form class="update-pattr" action="/attribute/Update" Method="POST">
                    <input type="hidden" value="<?=$att['id']?>" name="id">
                    <ul class="tbl-4cols clearfix">
                        <li><?=$att['size']?></li>
                        <li><?=$att['color']?></li>
                        <li><input name="quantity" type="text" value="<?=$att['quantity']?>"/></li>
                        <li>
                            <input type="submit" value="Update"/>
                            <a href ="/attribute/Delete/<?=$att['id']?>">delete</a>
                        </li>
                    </ul>
                </form>
            <?php }} ?>

            <?php ?>
            <form class="add-pattr" method="POST" action="/Attribute/Add">
                <input type="hidden" value ="<?=$product['id']?>" name="product_id">
                <ul class="tbl-4cols clearfix" style="background-color: #eee;
                                                      height: 40px;
                                                      line-height: 40px;">
                    <li>
                        <select name="size_id">
                            <option value="-1" selected>Size</option>
                            <?php foreach($sizes as $size){?> 
                            <option value="<?=$size['id']?>"><?=$size['name']?></option>
                                <?php } ?>
                        </select>
                    </li>
                    <li>
                        <select name="color_id">
                            <option value="-1" selected>Color</option>
                            <?php foreach($colors as $color){?> 
                            <option value="<?=$color['id']?>"><?=$color['name']?></option>
                                <?php } ?>
                        </select>
                    </li>
                    <li>
                        <input type="text" placeholder="quantity" name="quantity">
                    </li>
                    <li>
                        <input type="submit" value="Add">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>      