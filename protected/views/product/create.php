<!-- layout $content will be shown here -->
<form id="create-product" class="l-2cols clearfix content-inner" method="POST" action="/product/Create/">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty">

            </div>
            <div class="more-view">
                <ul>
                    <li class="empty"></li>
                    <li class="empty"></li>
                    <li class="empty"></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div class="col-right-container pdetail-container">
            <input type="text" class="col-right-header" placeholder="Product name" name="product[product_name]">
            <textarea  placeholder="Write the description here...." name="product[product_description]"></textarea>
            <span class="product-price">
                <input type="text" placeholder="Price" name="product[price]"> 
                <input type="text" placeholder="Sale" style="display:block" name="product[sale]">
            </span>
            <div>
                <input type="checkbox" name="product[available]" value="1"><label>active</label>
                <input type="checkbox" name="product[is_new]" value="1"><label>is new</label>
            </div>
                <div class="button-group">
                    <input type="submit" class="add-to-bag dark-bt">
                    <input type="reset" href="" class="check-out dark-bt">Cancel</a>
                </div>                                   

        </div>

    </div>

</form>
<!--end of layout $content -->