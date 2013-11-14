<!-- layout $content will be shown here -->
<?php 
$product = $data['model'];
$categoryID = $data['categoryID'];
$categories = Category::getCategory();
$attributes = $data['attributes'];
$sizes = $data['sizes'];
$colors = $data['colors'];
//print_r($categories);
?>
<div class="l-2cols content-inner">

    <form class="col-left clearfix"
          action="/Product/UpdatePictures/<?=$product['id']?>" 
                  method="POST"
                  enctype="multipart/form-data">
        
        <input type='hidden' value='<?=$product['id']?>' name ="product[id]">
        <!-- product picture -->
         <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%" src='<?=isset($data['pictureUlrs'][0]) ? $data['pictureUlrs'][0] : "" ?>'/>
                <input type="file" 
                       multiple accept='image/*'
                       name="cover" class="file"
                       onchange="preview(this)">
            </div>
            <div class="more-view clearfix">
                <ul>
                    <li class="pic-input <?php
                    echo (isset($data['pictureUlrs'][1])) ? '' : 'empty';
                    ?>">
                        <img height="100%" src='<?php
                        echo (isset($data['pictureUlrs'][1])) ? $data['pictureUlrs'][1] : '';
                        ?>'/>
                        <input type="file" name="preview1" 
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">
                    </li>
                    <li class="pic-input <?php
                    echo (isset($data['pictureUlrs'][2])) ? '' : 'empty';
                    ?>">
                        <img height="100%" src='<?php
                        echo (isset($data['pictureUlrs'][2])) ? $data['pictureUlrs'][2] : '';
                        ?>'/>
                        <input type="file" name="preview2" 
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">
                    </li>
                    <li class="pic-input <?php
                    echo (isset($data['pictureUlrs'][3])) ? '' : 'empty';
                    ?>">
                        <img height="100%" src='<?php
                        echo (isset($data['pictureUlrs'][3])) ? $data['pictureUlrs'][3] : '';
                        ?>'/>
                        <input type="file" name="preview3" 
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">
                    </li>
                </ul>
            </div>
             <div class="button-group"> <input type="submit" class="add-to-bag dark-bt" value="Upload Pics"> </div>
        </div>
        
    </form>
    <div class="col-right clearfix">
        <div class="col-right-container pdetail-container ">
            <!-- start info form -->
            <form id="update-product" 
                  action="/Product/Update/<?=$product['id']?>" 
                  method="POST">
                <input type='hidden' value='<?=$product['id']?>' name ="product[id]">
                <input value="<?= $product['product_name']?>" type="text" class="col-right-header" placeholder="Product name" name="product[product_name]" required>
                <textarea  placeholder="Write the description here...." 
                           name="product[product_description]"><?php echo $product['product_description']?></textarea>
                <span class="product-price">
                    <input value ="<?= $product['price']; ?>" 
                           type="text" 
                           placeholder="Price" 
                           name="product[price]" 
                           required> $ <br/>
                    <input type="text" 
                           placeholder="Sale" 
                           name="product[sale]"
                           value="<?= $product['sale']; ?>"> %
                </span>
                <div>
                    <span>Product category:</span>

                    <select name="product[categoryID]">
                        <option value="-1" selected>Chose Category..</option>
                        <?php if($categories){ 
                            foreach($categories as $category) {?>
                            <option value="<?=$category['id']?>"
                                    <?=($category['id']==$categoryID)? " selected": ""?> >
                                <?=$category['name']?>
                            </option>
                        <?php }}?>
                    </select>
                </div>
                <div>
                    <input type="checkbox" 
                           <?= ( $product['available'] == '1' )? "checked" : ""?>
                           name="product[available]" value="1"><label>active</label>
                    <input type="checkbox" 
                           <?= ( $product['is_new'] == '1' )? "checked" : ""?>
                           name="product[is_new]" 
                           value="1"><label>is new</label>
                </div>
                <div class="button-group">
                    <input type="submit" class="add-to-bag dark-bt">
                    <input type="reset" href="" class="check-out dark-bt">
                    <a href ="/Product/Delete/<?=$product['id']?>">delete</a>
                </div>           
            </form>
            <!--end info form -->
            
            <!--start attribute setting -->
            <div class="product-basic">
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
                            <a href ="/attribute/Delete/<?=$att['id']?>" style="background-color:#999">delete</a>
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
            <!--End Attribute setting -->
        </div>
    </div>
    <!--end col-right!-->
</div>
