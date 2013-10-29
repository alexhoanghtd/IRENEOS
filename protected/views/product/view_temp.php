<!--Content-header if you want :D-->
			<div class="content-header">
				<div id="categories-menu">
					<nav>
						<ul>
							<li><a href="#">Jacket</a></li>
							<li><a href="#">Top</a></li>
							<li><a href="#">Trouser</a></li>
							<li><a href="#">hat</a></li>
						</ul>
					</nav>
				</div>
			</div>

<!--PRODUCT DETAIL AREA-->
<div id="product-detail-container" class="detail-2-cols clearfix">
    <!--product picture-->
    <div id="product-detail-col-left" class="clearfix">
        <div class="fit-me-top">
            <div id="product-main-view" style="background-image: url('<?php echo $data['coverURL'] ?>')"></div>
            <div id="product-more-view">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
    <!--product details -->
    <div id="product-detail-col-right">
        <div class="fit-me-full">
            <div id="product-detail-header">
                <h1><?php echo $data['product_name'] ?></h1>
                <p><?php echo $data['product_description'] ?></p>
                <span class="product-price"><?php if($data['sale'] > 0){
                    echo '$'.($data['price'] - ($data['price'] * $data['sale'] /100)); ?>
                    <span class="product-old-price">
                        <?php echo '$'.$data['price']; ?>
                    </span>
                <?php }else{ echo '$'.$data['price'];}?> </span>	
            </div>
            <form id="product-order-form">
                <div id="order-options">
                    <ul class="clearfix">
                        <li class="clearfix"><label>Quantity</label> <input type="text" class="order-input" value="1"></li>
                        <li class="clearfix">
                            <label>Size</label>
                            <select class="order-input">
                                <option>S</option>
                                <option>M</option>
                                <option>XL</option>
                                <option>L</option>
                            </select>
                        </li >
                        <li class="clearfix"><label>Color</label>
                            <select class="order-input">
                                <option>Red</option>
                                <option>Grey</option>
                                <option>Green</option>
                                <option>Cyan</option>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="sub-total"><span>$260</span></div>
                <div id="action-bts-group">
                    <a href="#" id="add-to-bag">Add to Bag</a>
                    <a href="#" id="check-out">Check out</a>
                    <a href="#" id="share-facebook">Share to <span>f</span></a>
                </div>
            </form>
        </div>


    </div>
</div>