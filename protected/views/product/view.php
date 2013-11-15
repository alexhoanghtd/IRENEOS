<!-- layout $content will be shown here -->
<?php $product = $data['model'];
      $attrs = $data['attrs'];
      //echo (empty($attr))? "empty" : "not empty";
      //print_r($attrs);?>
<div id="" class="l-2cols content-inner clearfix">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box"
                 <?php if(isset($data['pictureUlrs'][0])){?>
                        onclick="viewOver(this,<?=$product['id']?>)"
                 <?php } ?>
                 style="background-image: 
                 url('<?php echo isset($data['pictureUlrs'][0])? $data['pictureUlrs'][0] : '';  ?>')">

            </div>
            <div class="more-view">
                <ul>
                    <li class="<?=(isset($data['pictureUlrs'][1])) ? '' : 'empty';?>"
                        <?php if(isset($data['pictureUlrs'][1])){?>
                        onclick="viewOver(this,<?=$product['id']?>)"
                        <?php } ?>
                        style="background-image: 
                        url('<?php
                        echo (isset($data['pictureUlrs'][1])) ? $data['pictureUlrs'][1] : '';
                        ?>')"></li>
                    <li class="<?php
                    echo (isset($data['pictureUlrs'][2])) ? '' : 'empty';
                    ?>"
                        <?php if(isset($data['pictureUlrs'][2])){?>
                        onclick="viewOver(this,<?=$product['id']?>)"
                        <?php } ?>
                        style="background-image: 
                        url('<?php
                        echo (isset($data['pictureUlrs'][2])) ? $data['pictureUlrs'][2] : '';
                        ?>')"></li>
                    <li class="<?php
                    echo (isset($data['pictureUlrs'][3])) ? '' : 'empty';
                    ?>"<?php if(isset($data['pictureUlrs'][3])){?>
                        onclick="viewOver(this,<?=$product['id']?>)"
                        <?php } ?>
                        style="background-image: 
                        url('<?php
                        echo (isset($data['pictureUlrs'][3])) ? $data['pictureUlrs'][3] : '';
                        ?>')"></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div id="" class="col-right-container pdetail-container">
            <h1 class="col-right-header"><?php echo $product['product_name']?></h1>
            <blockquote>
                    <?php echo $product['product_description']?>
            </blockquote>
            <span class="product-price">
                <?php $sale = (isset($product['sale']))? $product['sale'] : '';
                        if(!empty($sale)){
                            $newPrice = $product['price'] - (($product['price'] * $sale)/ 100);
                            echo '$'.$newPrice;?>
                <span class="old-price"><?php  echo '$'.$product['price'];?></span>
                            
                <?php
                        }else{
                            echo '$'.$product['price'];
                        }
                ?></span>
            <form id="order-form" method="POST" action="/bag/Add">
                <input type="hidden" value ="<?= $product['id']?>" name="id">
                <h2>Available Product Attribute</h2>
                <ul class="product-attributes ">
                    <li>
                        <ul class="tbl-3cols clearfix header-row">
                            <li>Size</li>
                            <li>Color</li>
                            <li>Quanity</li>
                        </ul>
                    </li>
                    <li>
                        <?php 
                        if(!empty($attrs)){foreach($attrs as $att){
                            ?>
                        <ul class="tbl-3cols clearfix">
                            <input type="hidden" value="<?=$att['id']?>" name="attribute[<?=$att['id']?>]">
                            <li><?=$att['size']?></li>
                            <input type="hidden" value="<?=$att['size']?>" name="<?=$att['id']?>[size]">
                            <li><?=$att['color']?></li>
                            <input type="hidden" value="<?=$att['color']?>" name="<?=$att['id']?>[color]">
                            <li>
                                <select name="attribute[<?=$att['id']?>][quantity]">
                                    <option selected value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </li>

                        </ul>
                            <?php
                        }}
                        ?>

                    </li>
                </ul>
                <hr/>   
                <div class="sub-total clearfix">
                    <span class="label">Total</span>
                    <span class="sub">$250</span>
                </div>
                <div class="button-group">
                    <input type="submit" class="add-to-bag dark-bt" value="Add To Bag">
                    <a href="" class="check-out dark-bt">Check out</a>
                </div>                                   
            </form> 

        </div>

    </div>

</div>
<!--end of layout $content -->