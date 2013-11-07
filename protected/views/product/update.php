<!-- layout $content will be shown here -->
<?php 
$product = $data['model'];
//print_r($data);
?>
<form id="update-product" class="l-2cols clearfix content-inner" 
      method="POST" 
      action="/product/Update/<?=$product['id']?>"
      enctype="multipart/form-data">
    <input type='hidden' value='<?=$product['id']?>' name ="product[id]">
           <!--2 colums layout left col -->
           <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%" src='<?=isset($data['pictureUlrs'][0]) ? $data['pictureUlrs'][0] : "" ?>'/>
                <input type="file" 
                       multiple accept='image/*'
                       name="cover" class="file"
                       onchange="preview(this)">
            </div>
            <div class="more-view">
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
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div class="col-right-container pdetail-container">
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
                <select>
                    <option>Top</option>
                    <option>Trouser</option>
                    <option>Hat</option>
                    <option>Dresses</option>
                </select>
            </div>
            <div>
                <input type="checkbox" 
                       <?= $product['available']? "checked" : ""?>
                       name="product[available]" value="1"><label>active</label>
                <input type="checkbox" 
                       <?= $product['is_new']? "checked" : ""?>
                       name="product[is_new]" 
                       value="1"><label>is new</label>
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt">
                <input type="reset" href="" class="check-out dark-bt">
            </div>                                   

        </div>

    </div>

</form>
<!--end of layout $content -->