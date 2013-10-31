<!-- layout $content will be shown here -->
<?php $product = $data['model'];?>
<div id="" class="l-2cols content-inner clearfix">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box"
                 style="background-image: 
                 url('<?php echo isset($data['pictureUlrs'][0])? $data['pictureUlrs'][0] : '';  ?>')">

            </div>
            <div class="more-view">
                <ul>
                    <li class="<?php
                    echo (isset($data['pictureUlrs'][1])) ? '' : 'empty';
                    ?>"
                        onclick="viewOver(this)"
                        style="background-image: 
                        url('<?php
                        echo (isset($data['pictureUlrs'][1])) ? $data['pictureUlrs'][1] : '';
                        ?>')"></li>
                    <li class="<?php
                    echo (isset($data['pictureUlrs'][2])) ? '' : 'empty';
                    ?>"
                        style="background-image: 
                        url('<?php
                        echo (isset($data['pictureUlrs'][2])) ? $data['pictureUlrs'][2] : '';
                        ?>')"></li>
                    <li class="<?php
                    echo (isset($data['pictureUlrs'][3])) ? '' : 'empty';
                    ?>"
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
            <form id="order-form">
                <ul id="order-items">
                    <li class="clearfix"><label>Quantity</label>
                        <input type="text" value="1">
                    </li>
                    <li class="clearfix"><label>Color</label>
                        <select>
                            <option>Green</option>
                            <option>Red</option>
                            <option>Blue</option>
                        </select>
                    </li >
                    <li class="clearfix"><label>Size</label>
                        <select>
                            <option>XL</option>
                            <option>L</option>
                            <option>S</option>
                        </select>
                    </li>
                </ul>
                <hr/>   
                <div class="sub-total clearfix">
                    <span class="label">Total</span>
                    <span class="sub">$250</span>
                </div>
                <div class="button-group">
                    <a href="" class="add-to-bag dark-bt">Add to bag</a>
                    <a href="" class="check-out dark-bt">Check out</a>
                </div>                                   
            </form> 

        </div>

    </div>

</div>
<!--end of layout $content -->